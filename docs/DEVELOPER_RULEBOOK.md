DEVELOPER RULEBOOK — safarimeet

Purpose
- Quick decision guide: Should you create a Request, Service, or Repository? Follow these rules when contributing.

Q: Should I create a Form Request?
- Yes when:
  - The endpoint is an HTTP controller action receiving user input.
  - Validation rules are non-trivial or include authorization logic.
  - Multiple callers (API + web) share the same validation.
- No when:
  - The validation is trivial (single field) and used only in an internal job.

Q: Should I create a Service?
- Yes when:
  - The operation touches multiple models or external integrations (mail, payment, image storage).
  - The flow requires transactions, retries, or background-handling logic.
  - The operation has business rules distinct from persistence.
- No when:
  - It's a single simple CRUD call with no business rules; repository can handle it.

Q: Should I create a Repository?
- Yes when:
  - Query logic is reused by multiple callers (Livewire lists, API controllers, CLI scripts).
  - Query is complex (joins, filters, eager loading decisions).
  - You need a seam for mocking DB access in tests.
- No when:
  - It's a simple `Model::find()` used once from a service; repository adds ceremony without benefit.

Q: When to create an Interface?
- Create if you will have multiple implementations (local S3 switch), or you need to mock in tests.
- Otherwise, prefer concrete classes first; extract interface when two implementations are required.

Q: Livewire-specific rules
- Keep Livewire components thin: validation invocation, input mapping, UI state management, calling services, and handling responses.
- Do not perform file storage, payment processing, or heavy DB transactions in Livewire.

Q: Testing rules
- Write unit tests for Services and Repositories. Use Feature tests to validate Livewire + HTTP behavior during migration.

Q: Naming guidelines
- Services: `PascalService` (PackageService, BookingService)
- Repositories: `SomethingRepository` with matching interfaces under `Repositories/Contracts`
- Requests: `StoreXRequest`, `UpdateXRequest` in app/Http/Requests
- Handlers: `XHandler` inside app/Handlers

End of developer rulebook.
