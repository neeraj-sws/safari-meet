# Common Components - Quick Reference Card

## 🎯 Essential Information

### Service Name
```php
AdminCommonContentService
```

### Location
```
app/Services/AdminCommonContentService.php
```

### Type Parameter
- **type=1** → ShareSafari
- **type=2** → Package

---

## 📝 Usage Template

### Blade View
```blade
<livewire:admin.common.COMPONENT-NAME 
    :type="1" 
    :id="$safari->id" 
/>
```

### Component Structure
```php
use App\Services\AdminCommonContentService;

public function mount($type, $id, AdminCommonContentService $service)
{
    $this->modelTable = $service->resolveModel($type, $id);
    $this->type = $type;
}

public function render(AdminCommonContentService $service)
{
    $this->data = $service->getData($this->type, $this->modelTable->id);
    return view('livewire.admin.common.component');
}

public function store(AdminCommonContentService $service)
{
    $this->validate();
    $service->storeData($this->type, $this->modelTable->id, $this->formData);
    $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Saved!']);
}
```

---

## 🔧 Service Methods

### Model Resolution
```php
$model = $service->resolveModel($type, $id);
// Returns: ShareSafari or Package

$columnName = $service->getColumnName($type);
// Returns: 'share_safari_id' or 'package_id'
```

### Things to Carry
```php
$service->getThingsToCarryOptions();
$service->getThingsToCarryList($type, $modelId);
$service->getThingToCarryDetails($id);
$service->storeThingsToCarry($type, $modelId, $formItems, $featureId = null);
$service->deleteThingToCarry($type, $id);
```

### Features (Inclusions/Exclusions)
```php
$service->getFeatureOptions($featureType); // 1=Inclusions, 2=Exclusions
$service->getFeatures($type, $modelId, $featureType);
$service->getFeatureDetails($id);
$service->storeFeatures($type, $modelId, $items, $featureType);
$service->deleteFeature($type, $id);
```

### FAQs
```php
$service->getFaqOptions($parkId);
$service->getParkFaqs($parkId);
$service->storeFaqs($parkId, $questions, $faqId = null);
$service->deleteFaq($id);
```

### Itinerary
```php
$service->calculateItineraryDays($type, $model);
$service->getItineraryDayWiseData($type, $modelId);
$service->getItineraryByDay($type, $modelId, $day);
$service->storeItinerary($type, $modelId, $data);
$service->deleteItinerary($type, $id);
```

---

## ✅ Validation

### Form Requests Location
```
app/Http/Requests/Admin/Common/
```

### Available Validators
```php
StoreThingsToCarryRequest      // formItems or featurethingstocarry
StoreInclusionExclusionRequest // items array with icon/title
StoreFaqRequest                // questions array
StoreItineraryRequest          // heading, activity, activityday
```

### Usage
```php
// In Component
protected function rules()
{
    return [
        'field' => 'required|string|max:255',
    ];
}

// Or use Form Request
public function store(StoreThingsToCarryRequest $request, AdminCommonContentService $service)
{
    // Already validated
    $service->storeThingsToCarry(...);
}
```

---

## 🎨 Components

### Available Components
```
app/Livewire/Admin/Common/
├── ThingsToCarry.php
├── FAQS.php
├── InclusionExclusionsComponent.php
└── Itinerary.php
```

### Component Props
```php
// Required
:type="1|2"     // 1=ShareSafari, 2=Package
:id="$modelId"  // Entity ID

// Optional (for specific components)
:featureType="1|2"  // For InclusionExclusionsComponent
                    // 1=Inclusions, 2=Exclusions
```

---

## 🔍 Common Patterns

### Add Form Item
```php
public $formItems = [];

public function addFormItem()
{
    $this->formItems[] = ['title' => '', 'description' => ''];
}
```

### Remove Form Item
```php
public function removeFormItem($index)
{
    unset($this->formItems[$index]);
    $this->formItems = array_values($this->formItems);
}
```

### Toggle Form
```php
public $showForm = false;

public function toggleForm()
{
    $this->showForm = !$this->showForm;
    if (!$this->showForm) {
        $this->reset('formItems');
    }
}
```

### Success Notification
```php
$this->dispatch('swal:toast', [
    'type' => 'success',
    'message' => 'Saved successfully.'
]);
```

### Error Notification
```php
$this->dispatch('swal:toast', [
    'type' => 'error',
    'message' => 'Something went wrong.'
]);
```

---

## 🛠️ Troubleshooting

### Issue: Model not found
```
Check type parameter (1 or 2) matches entity
```

### Issue: Validation fails
```
Check rules() method or Form Request validation
```

### Issue: Wrong column used
```
Verify getColumnName() returns correct FK name
```

### Issue: Data not showing
```
Check render() calls service method
Check blade view loops through correct property
```

---

## 📚 File Locations

| File Type | Location |
|-----------|----------|
| Service | `app/Services/AdminCommonContentService.php` |
| Components | `app/Livewire/Admin/Common/*.php` |
| Requests | `app/Http/Requests/Admin/Common/*.php` |
| Views | `resources/views/livewire/admin/common/*.blade.php` |
| Models | `app/Models/*.php` |

---

## 🚀 Quick Start Checklist

- [ ] Identify entity type (1=ShareSafari, 2=Package)
- [ ] Include component in blade view with type and id
- [ ] Component injects AdminCommonContentService
- [ ] Component calls service methods
- [ ] Service resolves model and performs operations
- [ ] Component handles UI state and notifications

---

## 💡 Best Practices

1. **Always inject service in method signature**
   ```php
   public function store(AdminCommonContentService $service)
   ```

2. **Keep validation in component**
   ```php
   $this->validate($this->rules());
   ```

3. **Delegate business logic to service**
   ```php
   $service->storeData(...);
   ```

4. **Handle UI feedback in component**
   ```php
   $this->dispatch('swal:toast', [...]);
   ```

5. **Reset form state after save**
   ```php
   $this->reset('formItems', 'showForm');
   ```

---

## 🔗 Related Documentation

- **COMMON_COMPONENTS_README.md** - Complete guide
- **COMMON_COMPONENTS_VISUAL_GUIDE.md** - Visual flows
- **COMMON_COMPONENTS_SUMMARY.md** - Executive summary
- **ARCHITECTURE_OVERVIEW.md** - Architecture patterns

---

## ⚡ Keyboard Shortcuts (Quick Copy-Paste)

### New Component Template
```php
<?php

namespace App\Livewire\Admin\Common;

use App\Services\AdminCommonContentService;
use Livewire\Component;

class MyComponent extends Component
{
    public $type;
    public $modelTable;
    public $data;
    public $showForm = false;
    
    public function mount($type, $id, AdminCommonContentService $service)
    {
        $this->modelTable = $service->resolveModel($type, $id);
        $this->type = $type;
    }
    
    public function render(AdminCommonContentService $service)
    {
        $this->data = $service->getData($this->type, $this->modelTable->id);
        return view('livewire.admin.common.my-component');
    }
    
    protected function rules()
    {
        return ['field' => 'required'];
    }
    
    public function store(AdminCommonContentService $service)
    {
        $this->validate();
        $service->storeData($this->type, $this->modelTable->id, ['field' => $this->field]);
        $this->dispatch('swal:toast', ['type' => 'success', 'message' => 'Saved!']);
    }
}
```

### Service Method Template
```php
public function getData(int $type, int $modelId): Collection
{
    $columnName = $this->getColumnName($type);
    
    return Model::where($columnName, $modelId)
        ->with('relations')
        ->get();
}

public function storeData(int $type, int $modelId, array $data): void
{
    $columnName = $this->getColumnName($type);
    
    Model::create([
        $columnName => $modelId,
        'field' => $data['field'],
    ]);
}

public function deleteData(int $type, int $id): void
{
    Model::where('id', $id)->delete();
}
```

### Blade Template
```blade
<div>
    @if($showForm)
        <form wire:submit.prevent="store">
            <input type="text" wire:model="field" />
            <button type="submit">Save</button>
        </form>
    @else
        <button wire:click="toggleForm">Add New</button>
    @endif
    
    @foreach($data as $item)
        <div>
            {{ $item->field }}
            <button wire:click="delete({{ $item->id }})">Delete</button>
        </div>
    @endforeach
</div>
```

---

## 📞 Quick Help

**Q: How do I know which type to use?**  
A: type=1 for ShareSafari, type=2 for Package

**Q: Where do I put validation?**  
A: In component's rules() method or Form Request

**Q: Can I add new entity type?**  
A: Yes, update resolveModel() and getColumnName() in service

**Q: How do I test service methods?**  
A: Create unit tests in tests/Unit/Services/

**Q: Component not updating?**  
A: Check Livewire public properties and wire: directives

---

**🎯 Keep this card handy for quick reference!**

---

**Version:** 1.0  
**Last Updated:** January 4, 2026  
**Status:** Production Ready
