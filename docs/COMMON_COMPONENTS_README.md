# Common Components Refactoring Guide

## 📖 Overview

This document explains the comprehensive refactoring of Common Components in the SafariMeet project. These components are shared between **ShareSafari** (type=1) and **Package** (type=2) entities, providing reusable content management functionality.

---

## 🎯 What Has Been Done

### 1. Created Unified Service Layer

**File:** `app/Services/AdminCommonContentService.php`

This service consolidates all business logic for common content operations across both ShareSafari and Package entities.

#### Service Features:

✅ **Type-Based Model Resolution**
- Automatically handles both ShareSafari (type=1) and Package (type=2)
- Returns correct model instance and column names based on type

✅ **Things to Carry Management**
- Get available things to carry options
- List assigned items
- Create/Update items with titles and descriptions
- Delete items

✅ **Features Management (Inclusions/Exclusions)**
- Get feature options (filtered by type: 1=Inclusions, 2=Exclusions)
- List assigned features with icons
- Create/Update features
- Delete features

✅ **FAQs Management**
- Get FAQ options for parks
- List park FAQs with questions/answers
- Create/Update FAQs
- Delete FAQs

✅ **Itinerary Management**
- Calculate itinerary days based on entity dates
- Get day-wise itinerary data
- Create/Update itinerary with activities
- Delete itinerary items
- Handle activity ordering

---

### 2. Created Form Request Validation Classes

**Location:** `app/Http/Requests/Admin/Common/`

Extracted validation logic into dedicated Form Request classes following Laravel best practices.

| File | Purpose | Key Validation |
|------|---------|----------------|
| `StoreThingsToCarryRequest.php` | Things to Carry validation | `formItems` array or `featurethingstocarry` selection |
| `StoreInclusionExclusionRequest.php` | Inclusions/Exclusions validation | `items` array with icon and title |
| `StoreFaqRequest.php` | FAQs validation | `questions` array with question/answer |
| `StoreItineraryRequest.php` | Itinerary validation | `heading`, `activity` array, `activityday` |

#### Benefits:
- ✅ Centralized validation logic
- ✅ Reusable across components
- ✅ Better separation of concerns
- ✅ Custom error messages

---

### 3. Refactored Common Components

All components now delegate business logic to `AdminCommonContentService`, keeping only UI state and interaction logic.

#### Refactored Components:

1. **ThingsToCarry.php** ✅
   - Manages things to carry items
   - Supports both form items and selection from existing items
   - Uses service for all CRUD operations

2. **FAQS.php** ✅
   - Manages FAQ items for parks
   - Question/answer management
   - Park FAQ association

3. **InclusionExclusionsComponent.php** ✅
   - Manages inclusions (type=1) and exclusions (type=2)
   - Icon and title management
   - Feature assignment

4. **Itinerary.php** ✅
   - Day-by-day itinerary management
   - Activity CRUD operations
   - Order management

---

## 🏗️ Architecture Pattern

```
┌──────────────────────────────┐
│  Livewire Component          │
│  (UI State & Interaction)    │
│  - $showForm                 │
│  - $formItems                │
│  - toggleForm()              │
│  - addFormItem()             │
└──────────┬───────────────────┘
           │ delegates business logic
           ▼
┌──────────────────────────────┐
│  AdminCommonContentService   │
│  (Business Logic)            │
│  - resolveModel()            │
│  - getThingsToCarryList()    │
│  - storeThingsToCarry()      │
│  - deleteThingToCarry()      │
└──────────┬───────────────────┘
           │ uses
           ▼
┌──────────────────────────────┐
│  Models                      │
│  - ShareSafari               │
│  - Package                   │
│  - FeatureThingsToCarrySafari│
│  - ThingsToCarry             │
│  - Feature                   │
│  - ParkFaq                   │
│  - ItineraryPackage          │
└──────────────────────────────┘
```

---

## 📚 How to Use Common Components

### Example 1: Things to Carry Component

#### In Your Blade View:

```blade
<!-- For ShareSafari (type=1) -->
<livewire:admin.common.things-to-carry 
    :type="1" 
    :id="$safari->id" 
/>

<!-- For Package (type=2) -->
<livewire:admin.common.things-to-carry 
    :type="2" 
    :id="$package->id" 
/>
```

#### Component Usage:

```php
// app/Livewire/Admin/Common/ThingsToCarry.php

use App\Services\AdminCommonContentService;

public function mount($type, $id, AdminCommonContentService $service)
{
    // Service resolves correct model (ShareSafari or Package)
    $this->modelTable = $service->resolveModel($type, $id);
    $this->type = $type;
    
    // Get available things to carry options
    $this->thingsToCarries = $service->getThingsToCarryOptions();
}

public function render(AdminCommonContentService $service)
{
    // Get assigned things to carry list
    $this->thingsToCarryList = $service->getThingsToCarryList($this->type, $this->modelTable->id);
    return view('livewire.admin.common.things-to-carry');
}

public function store(AdminCommonContentService $service)
{
    $this->validate($this->rules());
    
    // Service handles all business logic
    $service->storeThingsToCarry($this->type, $this->modelTable->id, $this->formItems);
    
    $this->toggleForm();
    $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Saved successfully.']);
}

public function delete($id, AdminCommonContentService $service)
{
    $service->deleteThingToCarry($this->type, $id);
    $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Deleted successfully.']);
}
```

---

### Example 2: Inclusions/Exclusions Component

```php
// app/Livewire/Admin/Common/InclusionExclusionsComponent.php

public function mount($type, $id, $featureType, AdminCommonContentService $service)
{
    $this->modelTable = $service->resolveModel($type, $id);
    $this->type = $type;
    $this->featureType = $featureType; // 1=Inclusions, 2=Exclusions
    
    // Get features filtered by type
    $this->features = $service->getFeatureOptions($featureType);
}

public function render(AdminCommonContentService $service)
{
    $this->featureList = $service->getFeatures($this->type, $this->modelTable->id, $this->featureType);
    return view('livewire.admin.common.inclusion-exclusions-component');
}

public function store(AdminCommonContentService $service)
{
    $this->validate($this->rules());
    
    $service->storeFeatures($this->type, $this->modelTable->id, $this->items, $this->featureType);
    
    $this->toggleForm();
    $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Saved successfully.']);
}
```

---

### Example 3: Itinerary Component

```php
// app/Livewire/Admin/Common/Itinerary.php

public function mount($type, $id, AdminCommonContentService $service)
{
    $this->modelTable = $service->resolveModel($type, $id);
    $this->type = $type;
    
    // Calculate available itinerary days
    $this->totalDays = $service->calculateItineraryDays($this->type, $this->modelTable);
}

public function render(AdminCommonContentService $service)
{
    // Get itinerary organized by day
    $this->itineraryData = $service->getItineraryDayWiseData($this->type, $this->modelTable->id);
    return view('livewire.admin.common.itinerary');
}

public function store(AdminCommonContentService $service)
{
    $this->validate($this->rules());
    
    $service->storeItinerary($this->type, $this->modelTable->id, [
        'heading' => $this->heading,
        'activity' => $this->activity,
        'activityday' => $this->activityday,
    ]);
    
    $this->resetForm();
    $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Itinerary saved successfully.']);
}
```

---

## 🔧 Service API Reference

### AdminCommonContentService Methods

#### Model Resolution

```php
/**
 * Resolve model based on type (1=ShareSafari, 2=Package)
 */
public function resolveModel(int $type, int $id): ShareSafari|Package

/**
 * Get column name for foreign key (share_safari_id or package_id)
 */
public function getColumnName(int $type): string
```

#### Things to Carry

```php
/**
 * Get all available things to carry options
 */
public function getThingsToCarryOptions(): Collection

/**
 * Get assigned things to carry list for entity
 */
public function getThingsToCarryList(int $type, int $modelId): Collection

/**
 * Get specific thing to carry details
 */
public function getThingToCarryDetails(int $id): ?ThingsToCarry

/**
 * Store things to carry items (bulk or selection)
 */
public function storeThingsToCarry(int $type, int $modelId, array $formItems, ?int $featureId = null): void

/**
 * Delete thing to carry item
 */
public function deleteThingToCarry(int $type, int $id): void
```

#### Features (Inclusions/Exclusions)

```php
/**
 * Get features filtered by type (1=Inclusions, 2=Exclusions)
 */
public function getFeatureOptions(int $featureType): Collection

/**
 * Get assigned features for entity
 */
public function getFeatures(int $type, int $modelId, int $featureType): Collection

/**
 * Get specific feature details
 */
public function getFeatureDetails(int $id): ?Feature

/**
 * Store features (bulk)
 */
public function storeFeatures(int $type, int $modelId, array $items, int $featureType): void

/**
 * Delete feature
 */
public function deleteFeature(int $type, int $id): void
```

#### FAQs

```php
/**
 * Get FAQ options for park
 */
public function getFaqOptions(int $parkId): Collection

/**
 * Get assigned park FAQs
 */
public function getParkFaqs(int $parkId): Collection

/**
 * Store FAQs for park
 */
public function storeFaqs(int $parkId, array $questions, ?int $faqId = null): void

/**
 * Delete park FAQ
 */
public function deleteFaq(int $id): void
```

#### Itinerary

```php
/**
 * Calculate itinerary days from entity dates
 */
public function calculateItineraryDays(int $type, ShareSafari|Package $model): int

/**
 * Get itinerary data organized by day
 */
public function getItineraryDayWiseData(int $type, int $modelId): Collection

/**
 * Get itinerary for specific day
 */
public function getItineraryByDay(int $type, int $modelId, int $day): Collection

/**
 * Store itinerary with activities
 */
public function storeItinerary(int $type, int $modelId, array $data): void

/**
 * Delete itinerary item
 */
public function deleteItinerary(int $type, int $id): void
```

---

## 📋 Validation Rules

### Things to Carry Request

```php
// app/Http/Requests/Admin/Common/StoreThingsToCarryRequest.php

public function rules(): array
{
    $hasFormItems = !empty($this->input('formItems'));
    
    return $hasFormItems
        ? [
            'formItems' => 'required|array|min:1',
            'formItems.*.title' => 'required|string|max:255',
            'formItems.*.description' => 'nullable|string',
        ]
        : [
            'featurethingstocarry' => 'required|exists:things_to_carries,id',
        ];
}
```

### Inclusions/Exclusions Request

```php
// app/Http/Requests/Admin/Common/StoreInclusionExclusionRequest.php

public function rules(): array
{
    return [
        'items' => 'required|array|min:1',
        'items.*.icon' => 'required|string|max:255',
        'items.*.title' => 'required|string|max:255',
    ];
}
```

### FAQ Request

```php
// app/Http/Requests/Admin/Common/StoreFaqRequest.php

public function rules(): array
{
    $allQuestionsEmpty = collect($this->input('questions', []))
        ->every(fn($q) => empty($q['question']) && empty($q['answer']));
    
    return [
        'faq_id' => $allQuestionsEmpty ? 'required|exists:faqs,id' : 'nullable',
        'questions' => 'required|array|min:1',
        'questions.*.question' => 'required|string',
        'questions.*.answer' => 'required|string',
    ];
}
```

### Itinerary Request

```php
// app/Http/Requests/Admin/Common/StoreItineraryRequest.php

public function rules(): array
{
    return [
        'heading' => 'required|string|max:255',
        'activity' => 'required|array|min:1',
        'activity.*.activity' => 'required|string',
        'activityday' => 'required|integer|min:1',
    ];
}
```

---

## 🚀 How to Add New Common Component

### Step 1: Create Livewire Component

```bash
php artisan make:livewire Admin/Common/MyNewComponent
```

### Step 2: Add Service Methods

```php
// app/Services/AdminCommonContentService.php

public function getMyData(int $type, int $modelId): Collection
{
    $columnName = $this->getColumnName($type);
    
    return MyModel::where($columnName, $modelId)->get();
}

public function storeMyData(int $type, int $modelId, array $data): void
{
    $columnName = $this->getColumnName($type);
    
    MyModel::create([
        $columnName => $modelId,
        'field' => $data['field'],
    ]);
}

public function deleteMyData(int $type, int $id): void
{
    MyModel::where('id', $id)->delete();
}
```

### Step 3: Create Form Request (Optional)

```bash
php artisan make:request Admin/Common/StoreMyDataRequest
```

```php
<?php

namespace App\Http\Requests\Admin\Common;

use Illuminate\Foundation\Http\FormRequest;

class StoreMyDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'field' => 'required|string|max:255',
        ];
    }
    
    public function messages(): array
    {
        return [
            'field.required' => 'The field is required.',
        ];
    }
}
```

### Step 4: Implement Component

```php
<?php

namespace App\Livewire\Admin\Common;

use App\Services\AdminCommonContentService;
use Livewire\Component;

class MyNewComponent extends Component
{
    public $type;
    public $modelTable;
    public $myData;
    public $showForm = false;
    public $field = '';
    
    public function mount($type, $id, AdminCommonContentService $service)
    {
        $this->modelTable = $service->resolveModel($type, $id);
        $this->type = $type;
    }
    
    public function render(AdminCommonContentService $service)
    {
        $this->myData = $service->getMyData($this->type, $this->modelTable->id);
        return view('livewire.admin.common.my-new-component');
    }
    
    protected function rules()
    {
        return [
            'field' => 'required|string|max:255',
        ];
    }
    
    public function store(AdminCommonContentService $service)
    {
        $this->validate();
        
        $service->storeMyData($this->type, $this->modelTable->id, [
            'field' => $this->field,
        ]);
        
        $this->reset('field', 'showForm');
        $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Saved successfully.']);
    }
    
    public function delete($id, AdminCommonContentService $service)
    {
        $service->deleteMyData($this->type, $id);
        $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Deleted successfully.']);
    }
    
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }
}
```

### Step 5: Use in Blade View

```blade
<!-- In ShareSafari detail view -->
<livewire:admin.common.my-new-component :type="1" :id="$safari->id" />

<!-- In Package detail view -->
<livewire:admin.common.my-new-component :type="2" :id="$package->id" />
```

---

## 📂 File Structure

```
app/
├── Http/
│   └── Requests/
│       └── Admin/
│           └── Common/
│               ├── StoreThingsToCarryRequest.php
│               ├── StoreInclusionExclusionRequest.php
│               ├── StoreFaqRequest.php
│               └── StoreItineraryRequest.php
├── Livewire/
│   └── Admin/
│       └── Common/
│           ├── ThingsToCarry.php
│           ├── FAQS.php
│           ├── InclusionExclusionsComponent.php
│           ├── Itinerary.php
│           ├── DynamicTabs.php
│           ├── SafariDiscussion.php
│           └── [15+ more components]
├── Services/
│   └── AdminCommonContentService.php
└── Models/
    ├── ShareSafari.php
    ├── Package.php
    ├── ThingsToCarry.php
    ├── FeatureThingsToCarrySafari.php
    ├── Feature.php
    ├── FeaturePackageSafari.php
    ├── ParkFaq.php
    ├── Faq.php
    ├── ItineraryPackage.php
    └── ItineraryPackageActivity.php
```

---

## ✅ Benefits of This Approach

### 1. Code Reusability
- ✅ One service handles both ShareSafari and Package
- ✅ Components can be used anywhere with just `type` and `id` props
- ✅ No code duplication between similar operations

### 2. Maintainability
- ✅ Business logic centralized in service
- ✅ Easy to update logic in one place
- ✅ Clear separation of concerns

### 3. Testability
- ✅ Service methods can be unit tested independently
- ✅ Components focus on UI interaction testing
- ✅ Mock service in component tests

### 4. Consistency
- ✅ Same pattern across all common components
- ✅ Predictable method signatures
- ✅ Standardized validation approach

### 5. Scalability
- ✅ Easy to add new common components
- ✅ Service can be extended without breaking existing code
- ✅ Clear guidelines for future developers

---

## 🔍 Common Patterns

### Pattern 1: Type-Based Resolution

```php
// Service automatically handles type
$model = $service->resolveModel($type, $id);

// Returns ShareSafari if type=1, Package if type=2
// No need for if/else in components
```

### Pattern 2: Column Name Resolution

```php
// Get correct foreign key column name
$columnName = $service->getColumnName($type);

// Returns 'share_safari_id' if type=1
// Returns 'package_id' if type=2
```

### Pattern 3: Dynamic Form Items

```php
// Component
public $formItems = [];

public function addFormItem()
{
    $this->formItems[] = ['title' => '', 'description' => ''];
}

public function removeFormItem($index)
{
    unset($this->formItems[$index]);
    $this->formItems = array_values($this->formItems);
}

// Service handles bulk insert
$service->storeThingsToCarry($type, $modelId, $this->formItems);
```

---

## ⚠️ Important Notes

### 1. Type Parameter

Always pass correct type:
- `type=1` for **ShareSafari**
- `type=2` for **Package**

### 2. Service Injection

Inject service in method signatures:

```php
// ✅ Correct
public function mount($type, $id, AdminCommonContentService $service)

// ❌ Wrong - don't inject in constructor
public function __construct(AdminCommonContentService $service)
```

### 3. Validation Location

Keep validation rules in component:

```php
// Component
protected function rules()
{
    return ['field' => 'required'];
}

// Service assumes data is validated
public function store(array $data)
{
    // No validation here
    Model::create($data);
}
```

### 4. Error Handling

Components handle user-facing errors:

```php
try {
    $service->store($data);
    $this->dispatch('swal:toast', ['type' => 'success']);
} catch (\Exception $e) {
    $this->dispatch('swal:toast', ['type' => 'error', 'message' => $e->getMessage()]);
}
```

---

## 📊 Before vs After Comparison

### Before Refactoring

```php
// ThingsToCarry.php (OLD)
public function mount($type, $id)
{
    // Direct model resolution
    if ($type == 1) {
        $this->modelTable = ShareSafari::findOrFail($id);
    } else {
        $this->modelTable = Package::findOrFail($id);
    }
    
    // Inline query
    $this->thingsToCarries = ThingsToCarry::all();
}

public function render()
{
    // Inline query with complex logic
    if ($this->type == 1) {
        $this->thingsToCarryList = FeatureThingsToCarrySafari::where('share_safari_id', $this->modelTable->id)
            ->with('thingstocarry')
            ->get();
    } else {
        $this->thingsToCarryList = FeatureThingsToCarrySafari::where('package_id', $this->modelTable->id)
            ->with('thingstocarry')
            ->get();
    }
    
    return view('livewire.admin.common.things-to-carry');
}

public function store()
{
    $this->validate();
    
    // Complex inline logic
    if (!empty($this->formItems)) {
        foreach ($this->formItems as $item) {
            $thingsToCarry = ThingsToCarry::create([
                'title' => $item['title'],
                'description' => $item['description'],
            ]);
            
            if ($this->type == 1) {
                FeatureThingsToCarrySafari::create([
                    'share_safari_id' => $this->modelTable->id,
                    'things_to_carry_id' => $thingsToCarry->id,
                ]);
            } else {
                FeatureThingsToCarrySafari::create([
                    'package_id' => $this->modelTable->id,
                    'things_to_carry_id' => $thingsToCarry->id,
                ]);
            }
        }
    }
}
```

### After Refactoring

```php
// ThingsToCarry.php (NEW)
use App\Services\AdminCommonContentService;

public function mount($type, $id, AdminCommonContentService $service)
{
    // Service handles model resolution
    $this->modelTable = $service->resolveModel($type, $id);
    $this->type = $type;
    $this->thingsToCarries = $service->getThingsToCarryOptions();
}

public function render(AdminCommonContentService $service)
{
    // Service handles complex query
    $this->thingsToCarryList = $service->getThingsToCarryList($this->type, $this->modelTable->id);
    return view('livewire.admin.common.things-to-carry');
}

public function store(AdminCommonContentService $service)
{
    $this->validate();
    
    // Service handles all business logic
    $service->storeThingsToCarry($this->type, $this->modelTable->id, $this->formItems);
    
    $this->toggleForm();
    $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Saved successfully.']);
}
```

**Result:**
- ✅ 60% less code in component
- ✅ No if/else type checking in component
- ✅ Business logic testable independently
- ✅ Reusable across all common components

---

## 🧪 Testing Examples

### Service Unit Test

```php
<?php

namespace Tests\Unit\Services;

use App\Services\AdminCommonContentService;
use App\Models\ShareSafari;
use App\Models\Package;
use Tests\TestCase;

class AdminCommonContentServiceTest extends TestCase
{
    public function test_resolves_share_safari_model()
    {
        $safari = ShareSafari::factory()->create();
        $service = new AdminCommonContentService();
        
        $result = $service->resolveModel(1, $safari->id);
        
        $this->assertInstanceOf(ShareSafari::class, $result);
        $this->assertEquals($safari->id, $result->id);
    }
    
    public function test_resolves_package_model()
    {
        $package = Package::factory()->create();
        $service = new AdminCommonContentService();
        
        $result = $service->resolveModel(2, $package->id);
        
        $this->assertInstanceOf(Package::class, $result);
        $this->assertEquals($package->id, $result->id);
    }
    
    public function test_returns_correct_column_name()
    {
        $service = new AdminCommonContentService();
        
        $this->assertEquals('share_safari_id', $service->getColumnName(1));
        $this->assertEquals('package_id', $service->getColumnName(2));
    }
}
```

### Component Test

```php
<?php

namespace Tests\Feature\Livewire\Admin\Common;

use App\Livewire\Admin\Common\ThingsToCarry;
use App\Models\ShareSafari;
use Livewire\Livewire;
use Tests\TestCase;

class ThingsToCarryTest extends TestCase
{
    public function test_can_render_component()
    {
        $safari = ShareSafari::factory()->create();
        
        Livewire::test(ThingsToCarry::class, ['type' => 1, 'id' => $safari->id])
            ->assertStatus(200)
            ->assertViewIs('livewire.admin.common.things-to-carry');
    }
    
    public function test_can_store_things_to_carry()
    {
        $safari = ShareSafari::factory()->create();
        
        Livewire::test(ThingsToCarry::class, ['type' => 1, 'id' => $safari->id])
            ->set('formItems', [
                ['title' => 'Sunscreen', 'description' => 'SPF 50+'],
            ])
            ->call('store')
            ->assertHasNoErrors()
            ->assertDispatched('swal:toast');
            
        $this->assertDatabaseHas('things_to_carries', [
            'title' => 'Sunscreen',
        ]);
    }
}
```

---

## ❓ FAQs

### Q: Can I use these components in front-end views?

**A:** These are admin components. For front-end, create separate components or services following the same pattern.

### Q: What if I need to add a new entity type (type=3)?

**A:** Update `resolveModel()` and `getColumnName()` in service:

```php
public function resolveModel(int $type, int $id)
{
    return match($type) {
        1 => ShareSafari::findOrFail($id),
        2 => Package::findOrFail($id),
        3 => YourNewModel::findOrFail($id),
    };
}
```

### Q: Should I create a new service or add to existing?

**A:** Add to `AdminCommonContentService` if logic is shared across entities. Create new service for entity-specific operations.

### Q: How do I handle file uploads in common components?

**A:** Pass file from component to service:

```php
// Component
public function store(AdminCommonContentService $service)
{
    $this->validate();
    $service->storeWithImage($this->type, $this->modelTable->id, $this->data, $this->image);
}

// Service
public function storeWithImage(int $type, int $modelId, array $data, $image): void
{
    if ($image) {
        $data['image_path'] = ImageUploadHelper::upload($image, 'folder');
    }
    // ... save data
}
```

---

## 📞 Related Documentation

- [ARCHITECTURE_OVERVIEW.md](docs/ARCHITECTURE_OVERVIEW.md) - Overall architecture patterns
- [SOLID_APPLIED_TO_MY_PROJECT.md](docs/SOLID_APPLIED_TO_MY_PROJECT.md) - SOLID principles examples
- [REFACTORING_GUIDE.md](REFACTORING_GUIDE.md) - General refactoring guide

---

## 📝 Changelog

### Version 1.0 (January 2026)

✅ Created `AdminCommonContentService.php`
✅ Created 4 Form Request validation classes
✅ Refactored ThingsToCarry component
✅ Refactored FAQS component
✅ Refactored InclusionExclusionsComponent
✅ Refactored Itinerary component
✅ Created comprehensive documentation

---

**Last Updated:** January 4, 2026  
**Author:** Development Team  
**Status:** ✅ Complete

---

## 🎓 Summary for Future Projects

### Key Takeaways:

1. **Create unified service for shared logic** across multiple entities
2. **Use type parameter** to distinguish between entity types
3. **Delegate all business logic** to services
4. **Keep components focused** on UI state and interaction
5. **Extract validation** to Form Request classes
6. **Document patterns** for future developers

### Quick Checklist:

- [ ] Identify common logic across entities
- [ ] Create service with type-based resolution
- [ ] Extract validation to Form Requests
- [ ] Refactor components to use service
- [ ] Test service methods independently
- [ ] Document usage patterns
- [ ] Update architecture documentation

---

**🚀 You're now ready to use and extend Common Components!**
