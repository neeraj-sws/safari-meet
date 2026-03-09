IDEAL PROJECT STRUCTURE — file-wise guidance

Purpose
- Map where new files should live and what each layer is responsible for. Use project terms: Package, SharedSafari, Booking, Accommodation.

1) Requests
- Where: app/Http/Requests/*
- Example files:
  - app/Http/Requests/SharedSafari/StoreSharedSafariRequest.php (validation & authorization)
  - app/Http/Requests/Package/StorePackageRequest.php
- Responsibilities:
  - Validate shape and authorize the caller. Do not write to DB or call services.

2) DTOs
- Where: app/DTOs/*
- Example: app/DTOs/SharedSafari/SharedSafariDto.php
- Responsibilities:
  - Strongly-typed data container used by services.

3) Services
- Where: app/Services/*
- Example services:
  - app/Services/PackageService.php
  - app/Services/BookingService.php
  - app/Services/SharedSafariService.php
  - app/Services/ImageService.php (implements ImageUploaderInterface)
- Responsibilities:
  - Contain business rules and orchestration, call repositories, send notifications via injected NotificationSenderInterface, and wrap write flows in DB transactions.
  - NEVER handle HTTP concerns, Livewire state, or view rendering.

4) Repositories
- Where: app/Repositories/* and app/Repositories/Contracts/*
- Example interfaces:
  - app/Repositories/Contracts/PackageRepositoryInterface.php
  - app/Repositories/Contracts/BookingRepositoryInterface.php
- Implementations:
  - app/Repositories/Eloquent/PackageRepository.php
- Responsibilities:
  - Encapsulate queries, eager loading, scopes, and persistence details.
  - Provide expressive methods like `paginateFiltered($filters)`, `createWithRelations($data)`.

5) Handlers / Filters
- Where: app/Handlers/* and app/Filters/*
- Example: app/Handlers/Characteristics/AccommodationHandler.php
- Responsibilities:
  - Small single-purpose classes handling a single characteristic type or filter; used by controller/regsitry.

6) Presenters / Resources
- Where: app/Http/Resources/* or app/Presenters/*
- Responsibilities:
  - Format model data for API and Livewire views (image URLs, localized strings).

7) Livewire components
- Where: app/Livewire/*
- Responsibilities (allowed): UI state, validation invocation, calling services, handling success/failure, dispatching events.
- Responsibilities (NOT allowed): direct DB queries beyond simple reads, file storage operations, mail sending, complex orchestration.

8) Controllers (API)
- Where: app/Http/Controllers/Api/*
- Responsibilities: accept HTTP requests, validate (Form Request), call Services or Repositories, return Resources.

9) Contracts / Interfaces
- Where: app/Contracts or app/Repositories/Contracts
- Examples: ImageUploaderInterface, PackageRepositoryInterface, NotificationSenderInterface

10) Providers
- Where: app/Providers/
- Responsibilities: bind interfaces to concrete implementations, register handler registry, and register filters.

Why this separation matters (practical benefits)
- Testability: Services and repositories can be unit-tested with mocks.
- Maintainability: Single-responsibility classes reduce the surface area for bugs.
- Extensibility: Add new filters/handlers without editing controllers; swap storage providers without touching components.

End of ideal structure.
