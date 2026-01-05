STEP-BY-STEP IMPROVEMENT PLAN — safarimeet

Purpose
- A safe, non-breaking roadmap to incrementally apply SOLID practices.

Phase 0 — Safety and tests (1–2 weeks)
- Add end-to-end feature tests for critical user journeys: package listing, package creation, enquiries listing.
- Add integration tests for API endpoints used by mobile/clients.
- Rationale: tests provide safety net for refactors.

Phase 1 — Read-only extraction (1–2 weeks)
- Create concrete repositories for read operations:
  - `PackageRepository::paginateForListing($filters, $perPage)`
  - `EnquiryRepository::paginateAdmin($filters)`
- Replace direct query usages in Livewire `render()` for listings to call repos.
- Keep repository backed by Eloquent — behavior parity.

Phase 2 — Introduce ImageService and SlugService (1 week)
- Implement `ImageService` behind `ImageUploaderInterface`.
- Implement `SlugService::uniqueSlug(ModelClass, $value)`.
- Refactor Livewire listing components to call `ImageService` when reading image metadata (not upload) to normalize URLs.

Phase 3 — Move create/update flows into Services (2–3 weeks)
- For each heavy create flow (PackageList::store, CreateSafari::store, Accommodations::store):
  - Create Service (e.g., `PackageService::createFromArray($data)`)
  - Move image upload calls to `ImageService` and package creation to `PackageRepository`
  - Keep Livewire component calling service; do not change routes or responses.

Phase 4 — Share validation (1–2 weeks)
- Introduce Form Requests for controllers.
- For Livewire, refactor `rules()` to use shared validation classes or DTO creators.

Phase 5 — Introduce Interfaces and provider bindings (1 week)
- Add repository and service interfaces and bind them in a `RepositoryServiceProvider`.
- Refactor services and components to depend on interfaces via constructor injection (or `app()` resolution as fallback).

Phase 6 — Replace controller conditional logic with handlers (2 weeks)
- Implement `CharacteristicHandlerInterface` and registry; add handlers for existing characteristics.
- Replace big switch in `SafariPackageController::getPackagesDataByTitle()` with registry call.

Phase 7 — Hardening and transactions (ongoing)
- Ensure multi-step write operations use DB transactions in Services.
- Implement compensating file deletion on failure or use two-phase commit approach where necessary.

Phase 8 — Cleanup and documentation (ongoing)
- Add docs in `docs/` (this work), add coding guidelines to repo README or CONTRIBUTING.md.
- Train team on new patterns and enforce via PR reviews.

Rollback strategy
- Every phase must include tests that prove parity.
- Use feature-flagging or branch-deploy to verify behavior before wide rollout.

End of improvement plan.
