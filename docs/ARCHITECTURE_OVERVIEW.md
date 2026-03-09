ARCHITECTURE OVERVIEW — safarimeet

Purpose
- Document where responsibilities currently live and how requests flow from UI to DB in this codebase.

1) Top-level folders of interest
- Controllers: app/Http/Controllers and app/Http/Controllers/Api/*
  - Example: app/Http/Controllers/Api/Common/SafariPackage/SafariPackageController.php
- Livewire components: app/Livewire (≈237 components)
  - Heavy examples: app/Livewire/Front/SharedSafari/Organize/CreateSafari.php (≈908 lines), app/Livewire/TravelAgent/Package/PackageList.php, app/Livewire/Admin/Accommodation/Accommodations.php
- Models: app/Models (Package.php, SafariEnquiry.php, Accommodation.php, SafariAccommodation.php, etc.)
- Helpers: app/Helpers (ImageUploadHelper.php, ImageHelper.php, UserHelper.php)

2) Where logic currently lives (actual pattern)
- Livewire components are the primary place where: validation, Eloquent queries (create, update, delete), file uploads, slug generation, redirect and UI dispatch logic, and some mail dispatch occur. Example: `PackageList::store()` handles validation, image upload via ImageUploadHelper, slug uniqueness logic, direct Package::create() and then redirects.
- API controllers perform request parsing, filtering, and heavy result shaping. Example: `SafariPackageController::getsafariPackage()` contains many request-based `if` conditions and switch statements to build the query and shapes image URLs.
- Models define relationships and occasionally small helpers (getIdAttribute), but do not encapsulate orchestration or complex queries.
- Helpers contain cross-cutting utilities (image upload/delete and user IP detection) and are called directly from components/controllers.

3) Typical request flow (concrete example — package create via UI)
- UI (Blade / Livewire) -> Livewire component `PackageList` (collects input, validates via `rules()`) -> image uploaded using `ImageUploadHelper::upload()` -> `Package::create()` executed in component -> creation of related records (`SafariesType::create()`, etc.) -> component redirects to details route and dispatches toast events.

4) Observed anti-patterns
- Orchestration done in UI layer (Livewire). There is little separation between validation, domain rules, persistence, and infrastructure concerns (file storage, mail).
- Controllers often act as combined filter + formatter rather than delegating to a query/filter layer and transformer.

5) Quick map of responsibilities (current)
- Validation: Livewire components `rules()` methods and sometimes inline `Validator` in controllers.
- Business rules: inside Livewire components and controllers (price checks, seat logic, slug generation).
- Persistence: direct Eloquent usage across components/controllers (`Model::create`, `Model::update`, `whereRaw` filters).
- File ops: `ImageUploadHelper` called directly by components.
- Presentation shaping: controllers mutate models into arrays and append APP_URL for images.

6) Files to inspect first for architecture work
- app/Livewire/Front/SharedSafari/Organize/CreateSafari.php
- app/Livewire/TravelAgent/Package/PackageList.php
- app/Livewire/Admin/Accommodation/Accommodations.php
- app/Http/Controllers/Api/Common/SafariPackage/SafariPackageController.php
- app/Helpers/ImageUploadHelper.php

7) Recent refinement — Shared Safari Detail
- UI component: app/Livewire/Front/SharedSafari/Detail.php now delegates join/leave, seat allotment, wishlist toggle, and discussion reporting to app/Services/SharedSafariDetailService.php. The component keeps UI state (modals, pagination, Livewire dispatch) while the service owns business workflows (notifications, mail, seat math). This reduces coupling in the front flow without changing UI behavior.

8) Recent refinement — Safari Package Listing
- UI component: app/Livewire/Front/SafariPackage/Listing.php now defers filter resolution and listing queries to app/Services/SafariPackageListingService.php. Livewire tracks user state and events; the service translates filter inputs to IDs and builds the package paginator. This isolates business/query logic for reuse and testing while keeping front flow intact.

9) Recent refinement — Safari Package Detail
- UI component: app/Livewire/Front/SafariPackage/Detail.php now delegates wishlist toggling, enquiry creation, discussion save, and comment reporting to app/Services/SafariPackageDetailService.php. Livewire keeps UI state (modals, validation, dispatch), while the service owns DB writes and reusable workflows, improving SRP and testability for the detail flow.

10) Recent refinement — Park Listing
- UI component: app/Livewire/Front/Park/Listing.php now defers filter option resolution and park query building to app/Services/ParkListingService.php. Livewire tracks UI state (selected filters, pagination, dispatch events); the service resolves dropdown options, builds filtered queries, and returns park collections. This isolates business/query logic for reuse and testing while keeping the UI flow intact.

11) Recent refinement — Park Detail
- UI component: app/Livewire/Front/Park/Detail.php now delegates enquiry creation and email dispatch to app/Services/ParkDetailService.php. Livewire keeps UI state (tabs, modals, form validation); the service owns DB writes (Enquiry model), IP capture, and mail workflows (user confirmation + admin notification). This improves SRP and makes enquiry logic testable and reusable across park flows.

12) Recent refinement — Admin Create Shared Safari
- UI component: app/Livewire/Admin/ShareSafari/Add/AddSharedSafariComponent.php now delegates business workflows to app/Services/AdminSharedSafariService.php. The component retains form fields, validation rules, and UI state (modals, dropdown population); the service owns price validation logic (8% max range), slug generation, image upload/delete, ShareSafari model creation/update, SafariesType relationship management, and notification dispatch. This isolates admin-side business logic for testing and reuse while keeping Livewire focused on form interaction.

End of overview.


13) Recent refinement — Admin Shared Safari Listing
- UI component: app/Livewire/Admin/ShareSafari/ShareSafariCrud.php now delegates query building, filtering, and status management to app/Services/AdminSharedSafariListingService.php. The component handles UI state (filter selections, pagination, modal visibility); the service owns organizer counting, filtered queries (search, park, purpose, category, approval status), status toggles (status/popular/trending/top_rated), approval workflow (updateApprovalStatus with admin notification dispatch). This isolates admin listing business logic for testing and reuse while keeping the CRUD component focused on UI interaction.

14) Recent refinement — Admin Shared Safari Detail
- UI component: app/Livewire/Admin/ShareSafari/ShareSafariDetail.php now delegates tab management and characteristic data initialization to app/Services/AdminSharedSafariDetailService.php. The component handles UI state (active tab display, modals, form fields); the service owns safari lookup (getSafariByUuid), characteristic tab retrieval (getCharacteristics), detail data mapping (getCharacteristicDetailData), active tab resolution (resolveActiveTab), and characteristic detail creation (ensureCharacteristicDetail, getOrCreateCharacteristicDetail with firstOrCreate pattern). This isolates admin detail tab business logic for testing and reuse while keeping Livewire focused on tab UI management.

End of overview.


15) Recent refinement - Admin Shared Safari Detail Tabs (Details folder)
- UI components in app/Livewire/Admin/ShareSafari/Details/ (CommonTabs.php, FAQComponent.php, Inclusions.php, ThingsToCarry.php, Discussion.php, PersonalChat.php) now delegate business logic to app/Services/AdminSharedSafariDetailTabService.php. Components keep UI state (form fields, active tabs, validation); the service owns:
  * Status toggling (toggleDetailTabStatus) - shared across all detail tab components
  * Dynamic tab content management (getTabTitle, getExistingDynamicTab, storeDynamicTabContent) - used by CommonTabs
  * Conversation management (loadAdminConversations, getOrCreateConversation) - used by PersonalChat
  * Chat messaging (loadChatMessages, sendChatMessage) - used by PersonalChat
  This unifies detail tab business logic, eliminates code duplication (status toggle was repeated 6 times), and improves testability across all detail tabs.

16) Recent refinement - Common Components (Shared between ShareSafari and Package)
- UI components in app/Livewire/Admin/Common/ (ThingsToCarry.php, FAQS.php, InclusionExclusionsComponent.php, Itinerary.php) now delegate all business logic to app/Services/AdminCommonContentService.php. These reusable components work with both ShareSafari (type=1) and Package (type=2) entities. Components keep UI state (form fields, modal visibility, validation); the service owns:
  * Model resolution (resolveModel, getColumnName) - type-based polymorphism for ShareSafari vs Package
  * Things to Carry operations (getThingsToCarryOptions, getThingsToCarryList, storeThingsToCarry, deleteThingToCarry)
  * Features operations (getFeatureOptions, getFeatures, storeFeatures, deleteFeature) - handles both inclusions and exclusions
  * FAQ operations (getFaqOptions, getParkFaqs, storeFaqs, deleteFaq) - park-specific FAQ management
  * Itinerary operations (calculateItineraryDays, getItineraryDayWiseData, storeItinerary, deleteItinerary) - day-wise activity management
- Validation extracted to Form Request classes in app/Http/Requests/Admin/Common/ (StoreThingsToCarryRequest.php, StoreInclusionExclusionRequest.php, StoreFaqRequest.php, StoreItineraryRequest.php)
- This pattern eliminates duplicate logic across entity types, establishes reusable components with unified service layer, and improves testability for common content operations. See COMMON_COMPONENTS_README.md for comprehensive usage guide.

End of overview.

