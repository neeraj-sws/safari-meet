MISTAKES ANALYSIS — safarimeet

Purpose
- For each major architectural mistake found in the codebase: show where it exists, why it is harmful, and how it should have been implemented (file-wise guidance only).

Mistake 1 — Fat Livewire components (Create + Orchestrate + Persist)
❌ What exists currently
- Example: `app/Livewire/Front/SharedSafari/Organize/CreateSafari.php` (~908 lines). The component:
  - Validates inputs via internal `rules()` and direct `Validator` calls.
  - Uploads images using `ImageUploadHelper::upload()`.
  - Generates slugs and ensures uniqueness inline.
  - Creates Package and many related models directly (SafariesType, FeatureThingsToCarrySafari etc.).
  - Sends mail using `DynamicMail` and performs redirects.

❗ Why this is a problem
- Hard to unit test: side effects (file system, mail, DB) are embedded in one class.
- High cognitive load: a single file contains multiple concerns making maintenance error-prone.
- Fragile: changing storage (S3 vs local) or mail provider needs edits in multiple places.

✅ How it SHOULD have been done
- Responsibilities separated
  - Validation → `StoreSharedSafariRequest` (app/Http/Requests/SharedSafari/StoreSharedSafariRequest.php)
  - Image handling → `ImageService::uploadForSharedSafari()` (app/Services/ImageService.php implementing ImageUploaderInterface)
  - Orchestration → `SharedSafariService::createFromDto(SharedSafariDto $dto)` (app/Services/SharedSafariService.php)
  - Persistence → `SharedSafariRepository` (app/Repositories/SharedSafariRepository.php) handling complex Eloquent relationships
  - Mail → `NotificationService` or `MailSenderInterface` used by `SharedSafariService`
- File locations
  - DTO: app/DTOs/SharedSafari/SharedSafariDto.php
  - Request: app/Http/Requests/SharedSafari/StoreSharedSafariRequest.php

Mistake 2 — Query + Presentation mixing in API controllers
❌ What exists currently
- Example: `app/Http/Controllers/Api/Common/SafariPackage/SafariPackageController.php`:
  - Builds complex queries with many `if` conditions in the controller method.
  - Uses switch/case (`getPackagesDataByTitle`) to decide how to fetch and shape data.
  - Mutates model attributes and concatenates `APP_URL` into image fields.

❗ Why this is a problem
- Controller becomes a maintenance bottleneck; adding a new characteristic or filter requires modifying the controller.
- Poor separation of concerns: querying, business rules, and response formatting are mixed so reusing logic for other consumers (console, jobs) is hard.

✅ How it SHOULD have been done
- Responsibilities separated
  - Filtering → `PackageQueryFilter` with small filter classes (app/Filters/Package/*Filter.php)
  - Characteristic handling → `CharacteristicHandlerRegistry` with implementations in app/Handlers/Characteristics/*Handler.php
  - Presentation → API Resource classes (app/Http/Resources/PackageResource.php) or Presenters that format image URLs using injected `ImageUrlResolver`.
- File placements
  - Filters: app/Queries/PackageQuery/ or app/Filters/Package/
  - Handlers: app/Handlers/Characteristics/
  - Resource: app/Http/Resources/PackageResource.php

Mistake 3 — Validation inside Livewire and controllers, duplicated
❌ What exists currently
- Livewire components contain `rules()` methods; controllers use inline `Validator::make()` in places.

❗ Why this is a problem
- Duplication of validation rules across UI and API leads to drift.
- Hard to centralize authorization logic.

✅ How it SHOULD have been done
- Use Form Requests for HTTP controllers: app/Http/Requests/*
- For Livewire: either use the same Request validators (shared validation objects) or create small reusable `Validation` classes in app/Validation/* that both controllers and Livewire can call.

Mistake 4 — Image/file operations spread across components
❌ What exists currently
- Example: `app/Livewire/Admin/Accommodation/Accommodations.php` calls `ImageUploadHelper::upload()` and `ImageUploadHelper::delete()` directly, and also manipulates image DB records inline.

❗ Why this is a problem
- Changing storage strategy or image processing requires touching many components.
- Hard to track transactional boundaries when file ops fail after DB writes.

✅ How it SHOULD have been done
- Centralize into `ImageService` behind `ImageUploaderInterface`; repository transaction boundaries ensure DB and file ops succeed together (or roll back).
- File placement: app/Services/ImageService.php and app/Contracts/ImageUploaderInterface.php

Mistake 5 — Direct Eloquent usage across layers (tight coupling)
❌ What exists currently
- Components and controllers directly call `Model::create()`, `whereRaw()`, etc.

❗ Why this is a problem
- Tightly couples UI to DB schema; swapping persistence or mocking for tests is hard.
- Business logic duplicated across components when similar queries are needed.

✅ How it SHOULD have been done
- Introduce repositories: e.g., app/Repositories/PackageRepository.php and app/Repositories/Contracts/PackageRepositoryInterface.php.
- Services should call repositories; Livewire and controllers should depend on services or interfaces.

Mistake 6 — Conditional switch logic for characteristics
❌ What exists currently
- `getPackagesDataByTitle()` uses a big switch to route characteristic ids to private methods.

❗ Why this is a problem
- Adding a new characteristic requires editing controller and adding a private method — violates OCP.

✅ How it SHOULD have been done
- Implement a `CharacteristicHandlerInterface` and register handlers in a registry or container. Controller simply calls the registry to handle the characteristic id.
- File placement: app/Handlers/Characteristics/*Handler.php and app/Handlers/CharacteristicHandlerRegistry.php

Mistake 7 — Lack of transaction boundaries and error handling in multi-step writes
❌ What exists currently
- Example: `PackageList::store()` uploads images, creates Package, creates related SafariesType rows, and then redirects without an explicit DB transaction.

❗ Why this is a problem
- If file upload succeeds but DB save fails, or vice versa, the system can become inconsistent.

✅ How it SHOULD have been done
- Services should wrap multi-step write flows in DB transactions (use DB::transaction) and use the ImageService to delay committing file operations until transaction success or use compensating operations.

Mistake 8 — Livewire component mixing chat + seat logic (Shared Safari Detail)
❌ What existed
- `app/Livewire/Front/SharedSafari/Detail.php` handled join/leave, seat allotment, wishlist toggling, and reporting inline alongside UI state. A recent merge left the component without `loadJoinSharedSafari()` and with a corrupted `ShowChatBox()` that attempted seat allotment, breaking chat display and join tracking.
❗ Why this is a problem
- Violates SRP and makes reuse impossible; UI failures hide business bugs (join state not refreshed, seat allotment logic duplicated). The corruption showed how tightly coupled logic increases regression risk.
✅ What was done now
- Extracted the workflows into `app/Services/SharedSafariDetailService.php` (join/leave, seat allotment, wishlist, report) and restored clean UI-only methods (`loadJoinSharedSafari`, `ShowChatBox`, `showAllotSlot`, `submitAllotedSeat`) in the component. Business rules now live in the service; the component controls state and dispatch only.

Mistake 9 — Listing query logic embedded in Livewire (Safari Package)
❌ What existed
- `app/Livewire/Front/SafariPackage/Listing.php` handled filter translation, query building, and pagination inside the component.
❗ Why this is a problem
- Violates SRP and DIP; querying by chaining Eloquent in the UI prevents reuse and makes unit testing of filter logic awkward.
✅ What was done now
- Introduced `app/Services/SafariPackageListingService.php` to resolve filter inputs (names → IDs, ranges → bounds) and build the package paginator. The component now delegates to the service, keeping UI concerns (events, state) separate from query/business rules.

Mistake 10 — Detail business logic inside Livewire (Safari Package)
❌ What existed
- `app/Livewire/Front/SafariPackage/Detail.php` wrote wishlist, enquiry, discussions, and reports directly, mixing UI state with persistence.
❗ Why this is a problem
- Violates SRP/DIP; hard to unit-test workflows (enquiry IP capture, report creation) and to reuse logic outside the component.
✅ What was done now
- Added `app/Services/SafariPackageDetailService.php` to handle wishlist toggling, enquiry creation, discussion save, and reporting. The component now delegates while keeping validation and UI state, making business logic reusable and testable.

End of Mistakes Analysis.
