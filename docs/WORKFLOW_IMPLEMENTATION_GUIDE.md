# Workflow Implementation Guide

## Overview

The SafariMeet platform now implements a **3-step workflow pattern** for creating Safari and Package entities. This enforces proper data collection and follows SOLID principles for extensibility and maintainability.

## Workflow Steps

### Step 1: Basic Information
- **Location**: Safari/Package creation form
- **Required Fields**: 
  - Title
  - Park/Location
  - Date/Duration
  - Price range
  - Basic description
- **Validation**: Cannot proceed to Step 2 until all fields are filled
- **Next Action**: "Continue to Details" button redirects to details page

### Step 2: Details & Media
- **Location**: Details/Tabs page (ShareSafariDetail component)
- **Required Sections**:
  - Display Image (banner image)
  - Inclusions (what's included)
  - Exclusions (what's not included)
  - Things to Carry (packing list)
  - Itinerary (day-by-day schedule)
  - FAQs (frequently asked questions)
- **Validation**: At least display image + inclusions OR itinerary required
- **Progress Tracking**: Progress bar shows completion percentage
- **Next Action**: "Complete Creation" button finalizes workflow

### Step 3: Completion & Approval
- **Location**: Completion confirmation
- **Actions**:
  - Mark as complete: `is_safari_complete = true`
  - Dispatch `SafariCreationCompleted` event
  - Send admin notification
  - Show completion message to user
- **Next Status**: Awaiting admin approval for publishing

## SOLID Principles Applied

### Single Responsibility Principle (SRP)
Each workflow service has ONE responsibility:
- `SafariCreationWorkflow` - handles ONLY safari workflow logic
- `PackageCreationWorkflow` - handles ONLY package workflow logic
- Components handle ONLY UI/user interaction
- Services handle ONLY business logic

### Open/Closed Principle (OCP)
- Workflow steps are defined in constants (can be extended without modifying methods)
- New steps can be added by:
  1. Adding new constant (e.g., `STEP_APPROVAL = 4`)
  2. Adding new validation in `areDetailsComplete()`
  3. No need to modify existing method signatures

### Liskov Substitution Principle (LSP)
- Both `SafariCreationWorkflow` and `PackageCreationWorkflow` implement identical interfaces
- Can be used interchangeably in code:
  ```php
  public function processWorkflow($workflow, $entity) {
      $step = $workflow->getCurrentStep($entity);
      // Works the same for both Safari and Package
  }
  ```

### Interface Segregation Principle (ISP)
- Workflow services expose only necessary methods
- No client is forced to depend on methods it doesn't use
- Each method has a specific, focused responsibility

### Dependency Inversion Principle (DIP)
- Components depend on `SafariCreationWorkflow` service abstraction
- Not on concrete implementation details
- Can be easily swapped for mock/test implementation

## Service Methods

### SafariCreationWorkflow / PackageCreationWorkflow

#### `createBasic{Entity}(array $data): Entity`
Creates new entity with basic information.

```php
$workflow = new SafariCreationWorkflow();
$safari = $workflow->createBasicSafari([
    'title' => 'Jungle Safari',
    'park_id' => 1,
    'day' => 2,
    'night' => 1,
    'min_price' => 5000,
    'max_price' => 10000,
]);
// Returns: ShareSafari with is_safari_complete = false
```

#### `getCurrentStep(Entity $entity): int`
Returns current workflow step (1, 2, or 3).

```php
$step = $workflow->getCurrentStep($safari);
// Returns: 1 (basic info incomplete)
//          2 (details missing)
//          3 (ready to complete)
```

#### `areDetailsComplete(Entity $entity): bool`
Validates all required details are filled.

```php
if ($workflow->areDetailsComplete($safari)) {
    // All required details present
    // Can proceed to completion
}
```

#### `getDetailsChecklist(Entity $entity): array`
Returns completion status of each detail section.

```php
$checklist = $workflow->getDetailsChecklist($safari);
// Returns:
// [
//     'display_image' => true,
//     'inclusions' => true,
//     'exclusions' => false,
//     'itinerary' => true,
//     'things_to_carry' => false,
// ]
```

#### `getProgress(Entity $entity): int`
Returns completion percentage (0-100).

```php
$percent = $workflow->getProgress($safari);
// Returns: 66 (two-thirds complete)
```

#### `getStatusMessage(Entity $entity): string`
Returns user-facing status message.

```php
$message = $workflow->getStatusMessage($safari);
// Returns: "Add details and media to complete creation"
```

#### `markAsComplete(Entity $entity): bool`
Finalizes workflow and marks entity as complete.

```php
if ($workflow->markAsComplete($safari)) {
    // Safari creation complete
    // Event 'SafariCreationCompleted' dispatched
    // is_safari_complete = true
}
```

## Component Integration

### ShareSafariCrud Component
```php
// In component
public function detail($id, SafariCreationWorkflow $workflow)
{
    $safari = ShareSafari::find($id);
    $currentStep = $workflow->getCurrentStep($safari);
    
    // Enforce step progression
    if ($currentStep === 1) {
        // Cannot skip to details without basic info
        return error_response('Complete basic info first');
    }
    
    // Show details tab
    redirect()->to(route('admin.safari.detail', $safari->id));
}

public function complete($id, SafariCreationWorkflow $workflow)
{
    $safari = ShareSafari::find($id);
    
    // Validate before completion
    if (!$workflow->areDetailsComplete($safari)) {
        $checklist = $workflow->getDetailsChecklist($safari);
        return validation_error('Missing required details', $checklist);
    }
    
    // Mark as complete
    $workflow->markAsComplete($safari);
}
```

### Blade Template Usage
```blade
@php
    $workflow = app(SafariCreationWorkflow::class);
    $step = $workflow->getCurrentStep($safari);
    $progress = $workflow->getProgress($safari);
    $message = $workflow->getStatusMessage($safari);
@endphp

<x-workflow-progress 
    :step="$step"
    :progress="$progress"
    :status-message="$message"
/>

<!-- Conditional Display -->
@if ($step === 1)
    <x-forms.safari-basic-info :safari="$safari" />
    <button wire:click="saveBasicInfo">Next: Details →</button>
    
@elseif ($step === 2)
    <x-forms.safari-details :safari="$safari" />
    <button wire:click="complete">Complete →</button>
    
@elseif ($step === 3)
    <div class="alert alert-success">
        Creation complete! Awaiting admin approval.
    </div>
@endif
```

## Validation & Error Handling

### Step-Based Validation

**Step 1 Validation:**
- Required: title, park_id, day, night, price
- Error: Show modal with "Complete all basic fields"

**Step 2 Validation:**
- Required: display_image + (inclusions OR itinerary)
- Error: Show checklist of missing items
- Progress: Show % complete for motivation

**Step 3 Validation:**
- Check `areDetailsComplete()` returns true
- Dispatch completion event
- Redirect to success page

### Error Messages
```php
// Validation failures
'step_1_incomplete' => 'Please complete basic information first',
'step_2_incomplete' => 'Missing required details. See checklist below.',
'image_required' => 'Display image is required',
'inclusions_or_itinerary' => 'Add either inclusions or itinerary',
'step_skipped' => 'Cannot skip to this step. Follow the workflow.',
```

## Event System

### SafariCreationCompleted Event
Fired when `markAsComplete()` is called successfully.

```php
event(new SafariCreationCompleted($safari));

// Listeners can perform:
// 1. Send admin notification
// 2. Log activity
// 3. Update user statistics
// 4. Trigger approval workflow
```

### Usage in Listeners
```php
class NotifyAdminSafariCreated implements ShouldQueue
{
    public function handle(SafariCreationCompleted $event)
    {
        $safari = $event->safari;
        
        // Send email to admin
        Mail::to(admin_email())
            ->queue(new NewSafariCreatedMail($safari));
        
        // Log activity
        activity('safari_created')
            ->causedBy(Auth::user())
            ->performedOn($safari)
            ->log();
    }
}
```

## Benefits

### For Users
1. **Clear Progress**: See exactly where they are in the creation flow
2. **Guided Process**: Can't accidentally skip important details
3. **Progress Tracking**: Percentage completion shows how much more is needed
4. **Error Clarity**: Specific messages about what's missing

### For Developers
1. **Maintainability**: Business logic separated from UI
2. **Testability**: Can test workflow independently
3. **Extensibility**: Add new steps without modifying existing code
4. **Reusability**: Same pattern works for Safari, Package, and future entities
5. **SOLID Compliance**: Each class has single responsibility

### For Business
1. **Quality Control**: Ensures complete information before publishing
2. **Reduced Support Tickets**: Users complete workflow correctly
3. **Better User Experience**: Clear, guided process
4. **Analytics**: Track where users drop off in workflow
5. **Approval Workflow**: Can add approval gates easily

## Testing

### Unit Tests for Workflow Logic
```php
public function test_create_safari_sets_complete_flag_to_false()
{
    $workflow = new SafariCreationWorkflow();
    $safari = $workflow->createBasicSafari($data);
    $this->assertFalse($safari->is_safari_complete);
}

public function test_get_current_step_returns_1_for_new_safari()
{
    $workflow = new SafariCreationWorkflow();
    $safari = SafariFactory::createIncomplete();
    $this->assertEquals(1, $workflow->getCurrentStep($safari));
}

public function test_mark_as_complete_fails_if_details_incomplete()
{
    $workflow = new SafariCreationWorkflow();
    $safari = SafariFactory::createWithBasicInfoOnly();
    $result = $workflow->markAsComplete($safari);
    $this->assertFalse($result);
}
```

### Feature Tests for Component Integration
```php
public function test_user_cannot_skip_to_details_without_basic_info()
{
    $component = Livewire::test(ShareSafariCrud::class);
    $component->call('detail', 1); // Step 1 incomplete
    $component->assertDispatched('swal:toast');
}

public function test_completion_redirects_after_details_complete()
{
    $safari = SafariFactory::createComplete();
    $component = Livewire::test(ShareSafariCrud::class);
    $component->call('complete', $safari->id);
    $component->assertDispatched('redirect');
}
```

## Future Enhancements

1. **Approval Workflow**: Add Step 4 for admin approval
2. **Revision Workflow**: Allow users to revise after rejection
3. **Multi-Entity Workflow**: Link multiple safaris to a package
4. **Bulk Operations**: Create multiple safaris with shared details
5. **Draft Auto-Save**: Save progress automatically
6. **Workflow Analytics**: Track completion rates and drop-off points
7. **Conditional Steps**: Skip certain steps based on entity type

## Migration Guide

### From Old Flow to New Workflow

**Old Code:**
```php
// No step validation
$safari->update($allDataAtOnce);
$safari->publish();
```

**New Code:**
```php
$workflow = new SafariCreationWorkflow();

// Step 1
$safari = $workflow->createBasicSafari($basicData);

// Step 2
$safari->update($detailsData);

// Step 3
if ($workflow->areDetailsComplete($safari)) {
    $workflow->markAsComplete($safari);
}
```

## Troubleshooting

### User stuck on Step 1
- Check: `are all required fields filled?`
- Check: `is validation passing?`
- Fix: Show field-specific error messages

### User stuck on Step 2
- Check: `getDetailsChecklist()` to see missing items
- Show visual checklist to user
- Highlight missing sections in UI

### Completion not working
- Check: `areDetailsComplete()` validates correctly
- Check: Event listeners are registered
- Check: Database permissions for updating

## File Locations

```
app/
├── Services/
│   └── Workflows/
│       ├── SafariCreationWorkflow.php       (Safari workflow logic)
│       └── PackageCreationWorkflow.php      (Package workflow logic)
├── Livewire/
│   └── Admin/
│       └── ShareSafari/
│           └── ShareSafariCrud.php          (Updated with workflow)
├── Events/
│   ├── SafariCreationCompleted.php          (New event)
│   └── PackageCreationCompleted.php         (New event)
└── Listeners/
    ├── NotifyAdminSafariCreated.php         (New listener)
    └── NotifyAdminPackageCreated.php        (New listener)

resources/
└── views/
    ├── components/
    │   └── workflow-progress.blade.php      (Progress indicator component)
    └── livewire/
        └── admin/
            └── share-safari/
                └── index.blade.php          (Updated with workflow display)
```

## Summary

The workflow implementation provides:
- ✅ 3-step guided creation process
- ✅ SOLID principle compliance
- ✅ Progress tracking and validation
- ✅ User-friendly error messages
- ✅ Extensible architecture
- ✅ Event-driven notifications
- ✅ Reusable for multiple entities

This ensures high-quality data entry while providing excellent user experience and maintainable codebase for future development.
