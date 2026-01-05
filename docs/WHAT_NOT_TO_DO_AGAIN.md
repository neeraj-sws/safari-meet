WHAT NOT TO DO AGAIN — safarimeet (strict rules)

Purpose
- A concise list of habits and anti-patterns found in this repository that must not be repeated.

Rules (each rule: what happened here → why dangerous → replacement habit)

1) Do not write queries in Livewire `render()` that do heavy joins or raw SQL
- What happened: components like `Accommodations::render()` use `when(...)->paginate()` and sometimes `whereRaw`.
- Why dangerous: performance issues, duplicated logic, testing difficulty.
- Replacement: call repository method `->paginateForAdmin($filters)`.

2) Do not mix validation, persistence, file I/O, and notifications in one component
- What happened: `CreateSafari.php` and `PackageList.php` do all of the above.
- Why dangerous: hard to test and maintain; side effects leak into UI layer.
- Replacement: Move validation to Form Request/Validation class, orchestration to Service, file ops to ImageService.

3) Avoid switch/case chains for domain routing in controllers
- What happened: `getPackagesDataByTitle()` big switch.
- Why dangerous: violates OCP and introduces conditional complexity.
- Replacement: handler registry and small handler classes.

4) Do not call helpers statically across the app for infra concerns
- What happened: `ImageUploadHelper::upload()` used directly everywhere.
- Why dangerous: coupling and un-testability.
- Replacement: inject `ImageUploaderInterface` into services.

5) Never leave multi-step write operations without transactions
- What happened: `PackageList::store()` does multiple creates without explicit transaction.
- Why dangerous: partial state on failure.
- Replacement: orchestrate writes in a Service with DB transaction and either delayed or compensated file operations.

6) Do not mutate model attributes for presentation inside controllers
- What happened: controllers prepend `APP_URL` to image fields.
- Why dangerous: mixing presentation with domain; inconsistent formatting.
- Replacement: Presenters/Resources should format fields consistently.

7) Avoid unmanaged `whereRaw` with casting in controllers
- What happened: price/day filters use `whereRaw('CAST(...)')` in controllers.
- Why dangerous: database portability, injection risk.
- Replacement: move such logic to repository with documented SQL or use proper typed columns.

End of rules.
