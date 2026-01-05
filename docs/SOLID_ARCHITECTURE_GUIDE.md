# SOLID Architecture Guide — safarimeet

This document analyzes the current project structure and explains how SOLID principles apply (and could be applied) to this Laravel + Livewire project. It is written for junior → mid-level developers and future maintainers.

---

**Contents**
- 1. Project Architecture Overview
- 2. Current Problems (If Any)
- 3. SOLID Principles – Project Specific
- 4. Ideal SOLID-Based Architecture (Conceptual)
- 5. Database & Query Best Practices
- 6. Frontend Data Flow (Livewire)
- 7. SOLID Conversion Roadmap (non-breaking)
- 8. Project-Wide Development Rules

---

## 1. Project Architecture Overview

- Top-level layout observed
  - Controllers: `app/Http/Controllers` and `app/Http/Controllers/Api/*` (example: `Api/Common/SafariPackage/SafariPackageController.php`, `Api/BaseController.php`).
  - Livewire components: `app/Livewire` (many components; ~237 found). Key large components:
    - `app/Livewire/Front/SharedSafari/Organize/CreateSafari.php` (≈900 lines) — heavy business flows, file uploads, mail.
    - `app/Livewire/TravelAgent/Package/PackageList.php` — creation & editing of packages, validation, image handling.
    - `app/Livewire/Admin/Accommodation/Accommodations.php` — CRUD, image uploads, deletions.
    - `app/Livewire/Admin/Enquiries/GeneralEnquiry.php` — listing & filtering of enquiries.
  - Models: `app/Models` (Package, SafariEnquiry, Accommodation, SafariAccommodation, FeaturePackageSafari, ItineraryPackage, etc.).
  - Helpers: `app/Helpers` (ImageUploadHelper, ImageHelper, UserHelper, SettingHelper) used from UI components and controllers.
  - Traits: `app/Traits` (e.g., `HasSlug.php`).

- Where logic currently lives
  - Livewire components contain: input validation rules, DB queries (Eloquent calls, `create`, `update`, `delete`), file uploads and removal (via `ImageUploadHelper`), slug generation, complex conditionals, redirect logic, broadcasting/dispatch events, and response presentation.
  - API controllers (e.g., `SafariPackageController`) handle request parsing, filtering logic (many `if`/`switch` cases), data shaping (mapping images to full URLs), composing complex responses, and some validation.
  - Models are primarily Eloquent models with relationships and occasionally helper methods (ID aliasing, small helpers), but little separation beyond relationships.
  - Helpers contain cross-cutting concerns like image upload and user IP data.

- High-level patterns
  - CRUD and business rules are implemented directly in Livewire components or controllers rather than centralized services.
  - Helpers are used for orthogonal concerns (image handling, IP detection) — a pragmatic but ad-hoc separation.

## 2. Current Problems (If Any)

- SRP violations — classes doing multiple jobs
  - Large Livewire components (e.g., `CreateSafari.php`, `PackageList.php`, `Accommodations.php`) mix:
    - Validation rules and authorization checks
    - Query building and Eloquent persistence
    - File upload and image file system operations
    - Presentation logic (redirects, view shaping)
    - Notification/mail sending (in some components)
  - API controllers doing both domain selection/filtering and heavy response transformation.
  - Models sometimes contain presentation-motivated transformations (occasionally building URL strings in controllers rather than using resources/transformers).

- Tight coupling
  - Livewire components directly reference concrete Eloquent models and helpers (e.g., `Package::create()`, `ImageUploadHelper::upload()`), making testing and swapping implementations harder.
  - Controller methods tightly couple filtering logic and output formatting (e.g., appending `APP_URL` to images), reducing reusability.

- Queries inside Livewire / Controllers
  - Filtering and searching logic are implemented inline in components/controllers rather than in repositories, query objects, scopes, or services.
  - Conditional logic scattered across controller methods and Livewire `render()` methods.

- Validation mixed with business logic
  - `$this->validate()` and `rules()` methods live in Livewire components, and immediately after validation the components execute business workflows (DB writes, image uploads, side-effects). This prevents reusing validation in other contexts (API controllers, console jobs) without duplication.

- Missing abstractions
  - No dedicated service layer for domain workflows (Package creation, Safari organization, Enquiry workflows, Booking handling).
  - No interface-driven repositories; data access code is duplicated and spread across many components/controllers.

## 3. SOLID Principles – Project Specific

This section maps each SOLID principle to concrete spots in the codebase and suggests project-specific remedies.

S — Single Responsibility Principle (SRP)
- Observations
  - `CreateSafari.php` and `PackageList.php` do many responsibilities: validate input, store files, perform DB persistence, generate slugs, call helpers, send emails, and perform redirects.
  - `Admin/Accommodation/Accommodations.php` handles file uploads, image deletion, and cascade-deletes of related models.
- What should have been separated
  - Validation → Form Request / Form DTO
  - File handling → ImageService (upload, delete, transform)
  - Persistence → Repository (PackageRepository, AccommodationRepository)
  - Business rules / orchestration → Service (SharedSafariService, PackageService)
  - Presentation / UI state → Livewire component only
- Concrete example of responsibilities to extract
  - Extract slug generation and uniqueness logic from Livewire to a `SlugService` called inside `PackageService`.
  - Move upload flow to `ImageService::uploadForPackage($file, $path)` and make component call the service.

O — Open / Closed Principle (OCP)
- Observations
  - `SafariPackageController::getsafariPackage()` and `getPackagesDataByTitle()` use many `switch`/`case` or `if` chains to react to request filters and characteristic IDs.
- How to improve
  - Introduce Query Filter objects or `Specification` classes: e.g., `PackageQueryFilter` which composes filter objects (StateFilter, PriceRangeFilter, SpeciesFilter) and can be extended without modifying core controller logic.
  - For characteristic-based responses, use a registry of handlers keyed by characteristic id (or an enum) — e.g., `CharacteristicHandlerInterface` implementations registered through a service provider, so adding a new characteristic only requires adding a handler class and binding it.

L — Liskov Substitution Principle (LSP)
- Observations
  - Project uses few inheritance hierarchies; Eloquent models inherit from `Model`. There are not many custom parent classes or class hierarchies to violate LSP directly.
  - Helpers and components use concrete classes directly instead of depending on contracts — risk is limited LSP violations but more of DIP issues (next section).
- Guidance
  - If creating base classes (e.g., `BasePackageService`) avoid methods with restrictive side-effects and prefer composition of small behaviors (strategy pattern) so subclasses maintain substitutability.

I — Interface Segregation Principle (ISP)
- Observations
  - Some helpers (e.g., `ImageUploadHelper`) are used directly; there is no separation of concerns for a larger `Storage` interface vs. image-processing interface.
- Suggested smaller focused contracts
  - `ImageUploaderInterface` → `upload`, `delete`, `getUrl`
  - `PackageRepositoryInterface` → `findBySlug`, `paginateFiltered`, `create`, `update`
  - `BookingRepositoryInterface` → `reserveSeats`, `getAvailability` (small focused methods)
  - `NotificationSenderInterface` → `sendToUser`, `sendToAdmin`
- Benefit
  - Livewire components and services can depend on minimal interfaces rather than a single fat interface, making mocks for tests simpler and implementations swappable.

D — Dependency Inversion Principle (DIP)
- Observations
  - Livewire components and controllers call concrete classes (Eloquent models, Helpers) directly.
  - This makes unit testing harder and ties components to Laravel-specific implementations.
- Where to invert dependencies
  - Inject repository interfaces into services (and services into controllers/Livewire components). Example: `PackageService` depends on `PackageRepositoryInterface`, not on `Package` model.
  - Bind concrete implementations to interfaces in a service provider (e.g., `AppServiceProvider` or a dedicated `RepositoryServiceProvider`).
- Concrete starting points
  - Replace direct calls like `Package::create(...)` with `app(PackageRepositoryInterface::class)->create($data)`.
  - Replace `ImageUploadHelper::upload(...)` with `app(ImageUploaderInterface::class)->upload(...)` so storage implementation can change (local → S3) without changing components.

## 4. Ideal SOLID-Based Architecture (Conceptual)

Below are recommended roles and responsibilities (no code). Use the project vocabulary (Package, SharedSafari, Enquiry, Accommodation).

- `StoreBookingRequest` → validation & authorization only
  - Purpose: represent the incoming booking payload and rules.
  - Responsibilities:
    - Validate shape (required fields, types, existence rules).
    - Authorize caller (user can book this package?); keep only request concerns.
  - Must NOT:
    - Perform any DB writes, file uploads, price logic, availability changes, or notifications.

- `BookingService` → business rules & orchestration
  - Purpose: encapsulate the business workflow for creating a booking.
  - Responsibilities:
    - Coordinate repository calls (lock inventory / seat allocation), pricing computation, voucher/discount rules, payment handoffs (if synchronous), and notification dispatch.
    - Apply domain rules (e.g., seat allocation, maximum per booking, hold-and-release timers).
    - Return a unified result object or throw domain-specific exceptions.
  - Must NOT:
    - Know about HTTP request internals or Livewire state.

- `Repository` layer → database queries & persistence
  - Purpose: provide a single place for data access patterns, complex queries, eager loading choices.
  - Responsibilities:
    - Implement `PackageRepository`, `BookingRepository`, `EnquiryRepository`, `AccommodationRepository`.
    - Provide expressive methods: `paginateFiltered(array $filters)`, `findBySlugWithRelations($slug)`, `getAvailableSeats($packageId)`.
    - Contain query optimizations, scopes, and dedicated query objects.
  - Must NOT:
    - Contain business orchestration or validation logic.

- Livewire Component → UI state & interaction only
  - Purpose: manage ephemeral state, interactions, and validation errors shown to the user.
  - Responsibilities:
    - Capture inputs and run `->validate()` (or accept validated DTOs from requests in server-driven flows).
    - Call Services (e.g., `PackageService::createFromDto($dto)`) and handle success/failure (redirects, flash messages, UI updates).
    - Minimal shaping of data strictly needed for the view (not business logic).
  - Must NOT:
    - Perform raw queries, complex data mapping, send emails directly, or perform business orchestration beyond UI-level decisions.

- Controller → request forwarding only
  - Purpose: thin adapter between HTTP/API boundaries and the domain layer.
  - Responsibilities:
    - Convert HTTP-specific concerns (request → DTO) and forward to Services or Repositories.
    - Return appropriate HTTP responses (use Resource classes / Transformers for consistent shapes).
  - Must NOT:
    - Contain heavy business logic or direct persistence code beyond delegating to repository/service.

## 5. Database & Query Best Practices

- Where queries should live
  - Place queries in Repositories and Eloquent Scopes. For complex searches, use a dedicated `PackageQueryFilter` or `Spec` object that receives the request filters and returns a Builder.
  - Keep the Livewire `render()` method delegating to repository methods, e.g., `return $this->packageRepo->paginateForListing($filters, $perPage)`.

- What logic should never be in Livewire
  - Raw SQL / `whereRaw` conditions, heavy joins, data-shaping logic (image base URL manipulations), file system operations, payment integrations.
  - Business rule decisions like seat-reservation logic and transactionally-sensitive operations.

- How data should be prepared before sending to frontend
  - Use Resource classes (Laravel API Resources) or DTOs formed in the Service layer to control what fields are sent and to standardize transformations (image full URLs, computed fields like `is_bookable`).
  - Convert nested relations to simple arrays in the Service/Repository; Livewire receives a small, well-defined payload only.

- Pagination, filters, derived data
  - Implement server-side pagination in Repositories using `paginate()` with consistent `perPage` input; expose `current_page`, `last_page`, `total` through Resource wrapper.
  - Filters should be composable: each filter is a small callable that modifies the query builder.
  - Derived fields (e.g., `min_price`, `max_price`, `availability_count`) should be computed in Service methods, not in Views or components.

## 6. Frontend Data Flow (Livewire)

Canonical flow: UI → Livewire (thin) → Service → Repository → DB → Service → Livewire → UI

- What Livewire should do (thin):
  - Collect user inputs and call `->validate()` or receive a validated DTO.
  - Call an injected service method (e.g., `$this->packageService->create($dto)`).
  - Handle success/failure states (dispatch events, redirect, show toast) but not execute domain mutations directly.

- What must be computed server-side
  - Pricing rules, tax/fee computations, seat availability, composite aggregations (e.g., min/max price across related rates), slug uniqueness checks, image URL normalization.

- What should be formatted before rendering
  - Dates in the user's timezone, localized strings, image full URLs, small derived flags like `isOwnedByCurrentUser`.
  - Keep this formatting in either Services or Resource/Presenter classes rather than inline in components.

- How to keep Livewire components thin
  - Inject services/repositories (via container or constructor). Example conceptual pattern for a Livewire create flow:
    - Component validates input → constructs DTO → calls `SharedSafariService::create($dto)` → receives `Result` → shows message or redirect.

## 7. SOLID Conversion Roadmap (NO CODE)

Goal: incrementally introduce services, repositories, and interfaces without breaking behavior.

Phase 0 — Preparation (safe, reads only)
- Add tests around critical behavior (listings, create flows). Start with high-level feature tests or API tests to cover current behavior.
- Add a `docs/` file (this document) and a `design/` or `diagrams/` as needed.

Phase 1 — Read-only extraction & repository façade
1. Identify read-only endpoints and listing Livewire components (e.g., `GeneralEnquiry`, `SafariPackage listing components`) and create `PackageRepository` (concrete) with methods used by these components.
2. Replace direct `Package::where(...)->paginate(...)` usage in `render()` with calls to the repository. Do this only for non-write paths.
3. Keep repository implementation backed by Eloquent; tests should ensure behavior unchanged.

Phase 2 — Introduce Services for create/update flows (safe, iterative)
1. Create `PackageService` and implement `createFromArray()` that internally uses `PackageRepository` and `ImageUploader`.
2. Move image handling out of Livewire into `ImageService`.
3. Refactor `PackageList::store()` to call `PackageService::createFromArray()` and adapt to return the created `Package` or throw an exception on failure.
4. Repeat for `Accommodations::store()` and `CreateSafari` flows.

Phase 3 — Form Requests & DTOs (validation separation)
1. Introduce Form Requests for API controllers first (non-breaking for Livewire).
2. For Livewire, create lightweight DTOs or reusable validation classes and move `rules()` definitions into dedicated request-like classes shared by both controllers and components.

Phase 4 — Interface segregation and DIP
1. Create interfaces: `PackageRepositoryInterface`, `ImageUploaderInterface`, `PackageServiceInterface`.
2. Bind concrete implementations in a `RepositoryServiceProvider`.
3. Update services and Livewire components to depend on interfaces (use constructor injection where possible or `app()` resolved types).

Phase 5 — Replace conditional switch chains with handlers
1. Replace large `switch` blocks in `SafariPackageController::getPackagesDataByTitle()` with a registry of `CharacteristicHandlerInterface` implementations.
2. Add tests for each handler and ensure controllers only delegate to the registry.

Phase 6 — Continuous cleanup and tests
1. Add unit tests for services, repositories, and handlers.
2. Gradually remove direct DB calls from components; they should only orchestrate presentation.
3. Harden transaction boundaries in services where multiple DB operations must be atomic.

Rollback / safety measures
- Keep behavior parity by adding feature tests before refactor.
- Migrate one feature at a time; always verify UI behavior after each step.

## 8. Project-Wide Development Rules (Guidelines)

- When to create a Service
  - Create a Service when a domain operation:
    - touches multiple models, or
    - uses external integrations (mail, payment, image processing), or
    - contains conditional workflows (seat allocation, multi-step creation).

- When to use a Form Request
  - Use a Form Request for any HTTP API controller action.
  - For Livewire components, keep `rules()` but share definitions with a reusable `Validation` class or migrate to `FormRequest`-like DTOs to keep rules consistent.

- When to introduce a Repository
  - Introduce a Repository when the same query or filtering logic is used from multiple places (APIs, Livewire, console), or when query complexity is non-trivial.

- What should never be done in Livewire
  - Complex transactionally-sensitive writes, payment processing, raw SQL generation, or file storage manipulations.
  - Avoid writing `whereHas` filters, `whereRaw` or heavy mapping inline — delegate to repository/filter classes.

- How to keep controllers thin
  - Controllers should assemble validated input and call Services, then return Resources.
  - Avoid direct Eloquent queries, file ops, or mail-sending code inside controllers.

- Naming and layering conventions
  - Services: `App/Services/*Service.php` (e.g., `PackageService`, `BookingService`)
  - Repositories: `App/Repositories/*Repository.php` with matching interfaces `App/Repositories/Contracts/*RepositoryInterface.php`
  - Handlers: `App/Handlers/Characteristics/*Handler.php` implementing small handler interfaces.
  - Helpers: restrict to infra concerns only (image processing, remote API wrappers) and prefer injecting them behind interfaces.

- Testing rules
  - Write unit tests for Services and Repositories first.
  - Use integration/feature tests to cover Livewire flows during the migration.

---

### Appendix — Concrete file examples (where problems show up)
- Large Livewire components to prioritize: `app/Livewire/Front/SharedSafari/Organize/CreateSafari.php`, `app/Livewire/TravelAgent/Package/PackageList.php`, `app/Livewire/Admin/Accommodation/Accommodations.php`.
- API controller to prioritize: `app/Http/Controllers/Api/Common/SafariPackage/SafariPackageController.php` (heavy filtering & response shaping).
- Helpers in use: `app/Helpers/ImageUploadHelper.php`, `app/Helpers/UserHelper.php` — these are good single-responsibility helpers but should be wrapped behind interfaces for swapping implementations.

---

End of document.
