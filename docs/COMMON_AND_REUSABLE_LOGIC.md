COMMON AND REUSABLE LOGIC — safarimeet

Purpose
- Identify repeated logic in the codebase and recommend where it should live for reuse.

1) Image upload and deletion
- Current duplication
  - `app/Livewire/Admin/Accommodation/Accommodations.php`, `app/Livewire/TravelAgent/Package/PackageList.php`, and many other components call `ImageUploadHelper::upload()` or `ImageUploadHelper::delete()` directly and then update DB records.
- Why centralize
  - Single point to change storage provider or add image processing steps.
- Where common logic should live
  - `ImageService` behind `ImageUploaderInterface` in app/Services and app/Contracts.
- Example usage
  - `ImageService::upload($file, $context)` returns normalized path and metadata.

2) Slug generation and uniqueness
- Current duplication
  - Multiple components create slugs with while-loops checking existence (see `PackageList::store()`).
- Where to centralize
  - `SlugService::uniqueSlug(ModelClass, $value, $column = 'slug')` in app/Services/SlugService.php

3) Filters and query building
- Current duplication
  - `SafariPackageController::getsafariPackage()` builds filters inline; some Livewire listings duplicate similar where/when conditions.
- Where to centralize
  - `PackageQueryFilter` and small filter classes (app/Queries/PackageQuery/*)

4) Response shaping (image URL normalization)
- Current duplication
  - Controllers loop through relations and prepend `APP_URL` to images in many places.
- Where to centralize
  - `ImageUrlResolver` or `Presenter` used by Resources to transform image paths consistently.

5) User IP and device detection
- Current single helper
  - `app/Helpers/UserHelper::UserIPDetails()` is used widely. This is OK but should be behind an interface if used in services for testability.

What should NOT be made common
- Over-generalizing services that combine unrelated concerns (e.g., ImageService + PaymentService merged). Keep cohesion high.
- Generic Repositories that try to be ORM-agnostic for no reason — prefer concrete Eloquent repositories with clear interfaces.

When to introduce shared logic
- Introduce when three or more places duplicate the same behavior.
- Introduce earlier for cross-cutting concerns (images, storage, notifications).

End of common logic doc.
