# Workflow Quick Reference

## TL;DR - Copy-Paste Solutions

### 1. Use Workflow in Livewire Component

```php
<?php
namespace App\Livewire\Admin;

use App\Services\Workflows\SafariCreationWorkflow;

class ShareSafariCrud extends Component
{
    public function detail($id, SafariCreationWorkflow $workflow)
    {
        $safari = ShareSafari::find($id);
        $step = $workflow->getCurrentStep($safari);
        
        if ($step === 1) {
            return error('Complete basic info first');
        }
    }
    
    public function complete($id, SafariCreationWorkflow $workflow)
    {
        $safari = ShareSafari::find($id);
        
        if (!$workflow->areDetailsComplete($safari)) {
            $missing = $workflow->getDetailsChecklist($safari);
            return error('Complete missing details', $missing);
        }
        
        $workflow->markAsComplete($safari);
        return success('Safari creation complete!');
    }
}
```

### 2. Show Progress in Blade

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
```

### 3. Register Event Listener

In `app/Providers/EventServiceProvider.php`:

```php
protected $listen = [
    \App\Events\SafariCreationCompleted::class => [
        \App\Listeners\NotifyAdminSafariCreated::class,
    ],
];
```

### 4. Create Mail Notification

```php
<?php
namespace App\Mail;

use Illuminate\Mail\Mailable;

class NewSafariCreatedMail extends Mailable
{
    public function __construct(public $safari) {}

    public function build()
    {
        return $this->subject('New Safari Created')
            ->view('emails.safari-created')
            ->with(['safari' => $this->safari]);
    }
}
```

## Common Methods Reference

### Get Current Step
```php
$step = $workflow->getCurrentStep($safari);
// Returns: 1, 2, or 3
```

### Check If Complete
```php
if ($workflow->areDetailsComplete($safari)) {
    // All required details filled
}
```

### Get Progress Percentage
```php
$percent = $workflow->getProgress($safari);
// Returns: 0-100
```

### Get What's Missing
```php
$checklist = $workflow->getDetailsChecklist($safari);
// Returns array of [field => true/false]
```

### Get Status Message
```php
$message = $workflow->getStatusMessage($safari);
// Returns user-friendly string
```

### Mark As Complete
```php
if ($workflow->markAsComplete($safari)) {
    // Success! Event dispatched
} else {
    // Failed - details incomplete
}
```

## Workflow Steps Explained

```
STEP 1: BASIC INFO (User creates entry)
├─ Required: Title, Park, Date, Price
└─ Result: Entity created with is_*_complete = false

STEP 2: DETAILS (User fills details)
├─ Required: Image + (Inclusions OR Itinerary)
├─ Progress: Show % complete
└─ Result: Details populated

STEP 3: COMPLETION (User completes)
├─ Check: Are details complete?
├─ Action: Mark is_*_complete = true
├─ Event: SafariCreationCompleted event fired
└─ Result: Awaiting admin approval
```

## Validation Checklist

For **Safari**:
- ✅ display_image (required)
- ✅ inclusions (recommended)
- ✅ itinerary (recommended)
- ✅ things_to_carry (optional)

For **Package**:
- ✅ display_image (required)
- ✅ inclusions (recommended)
- ✅ itinerary (recommended)
- ✅ things_to_carry (optional)

## File Locations

```
📁 Services
└─ 📁 Workflows
   ├─ SafariCreationWorkflow.php
   └─ PackageCreationWorkflow.php

📁 Events
├─ SafariCreationCompleted.php
└─ PackageCreationCompleted.php

📁 Listeners
├─ NotifyAdminSafariCreated.php
└─ NotifyAdminPackageCreated.php

📁 Views/Components
└─ workflow-progress.blade.php

📁 Documentation
└─ WORKFLOW_IMPLEMENTATION_GUIDE.md
```

## Common Errors & Solutions

| Error | Solution |
|-------|----------|
| `Class not found: SafariCreationWorkflow` | Add `use App\Services\Workflows\SafariCreationWorkflow;` |
| `Method undefined: getCurrentStep` | Check method name spelling |
| `Event not firing` | Register in EventServiceProvider |
| `Step always returns 1` | Check if relationships exist in database |
| `Progress stuck at 33%` | Verify details data is being saved |

## SOLID Principles Breakdown

| Principle | What It Means | How We Apply It |
|-----------|---------------|-----------------|
| **SRP** | One reason to change | Each service handles one workflow |
| **OCP** | Open to extend, closed to modify | Add steps without changing code |
| **LSP** | Subtypes are substitutable | Safari & Package workflows identical interface |
| **ISP** | Don't force unused methods | Each method has specific purpose |
| **DIP** | Depend on abstractions | Components use service, not concrete logic |

## Testing Examples

```php
// Test: Create safari with workflow
public function test_create_safari_sets_complete_false()
{
    $workflow = new SafariCreationWorkflow();
    $safari = $workflow->createBasicSafari($data);
    $this->assertFalse($safari->is_safari_complete);
}

// Test: Get step for incomplete safari
public function test_get_current_step_returns_1()
{
    $safari = SafariFactory::createIncomplete();
    $workflow = new SafariCreationWorkflow();
    $this->assertEquals(1, $workflow->getCurrentStep($safari));
}

// Test: Can't complete without details
public function test_cannot_complete_without_details()
{
    $safari = SafariFactory::createBasicOnly();
    $workflow = new SafariCreationWorkflow();
    $this->assertFalse($workflow->markAsComplete($safari));
}
```

## Component Integration Checklist

- [ ] Import SafariCreationWorkflow in component
- [ ] Add workflow service to method signature
- [ ] Call `getCurrentStep()` to get current step
- [ ] Call `areDetailsComplete()` before allowing completion
- [ ] Call `getProgress()` and `getStatusMessage()` for UI
- [ ] Display `workflow-progress` component
- [ ] Call `markAsComplete()` on completion
- [ ] Add tests for new workflow logic

## Deployment Checklist

- [ ] Run migrations (if any changes to is_*_complete column)
- [ ] Register event listeners in EventServiceProvider
- [ ] Create mail notification classes
- [ ] Update blade templates
- [ ] Add workflow-progress component to layouts
- [ ] Test full workflow end-to-end
- [ ] Verify emails are sending
- [ ] Check event logs
- [ ] Monitor performance
- [ ] Get user feedback

## Performance Tips

1. **Cache Current Step**: If called frequently, cache the result
   ```php
   $step = Cache::remember("safari.{$id}.step", 3600, function() use ($workflow, $safari) {
       return $workflow->getCurrentStep($safari);
   });
   ```

2. **Lazy Load Details**: Don't load details unless needed
   ```php
   $checklist = $workflow->getDetailsChecklist($safari); // Use wisely
   ```

3. **Batch Complete**: Process multiple completions in queue
   ```php
   // Use ShouldQueue in listener
   ```

## Support & Debugging

### Enable Debugging:
```php
// In .env
APP_DEBUG=true
LOG_CHANNEL=stack

// In config/logging.php
'channels' => [
    'activity' => [
        'driver' => 'single',
        'path' => storage_path('logs/activity.log'),
    ],
],
```

### View Logs:
```bash
tail -f storage/logs/laravel.log
tail -f storage/logs/activity.log
```

### Check Events:
```php
// Temporarily log events for debugging
Event::listen(\App\Events\SafariCreationCompleted::class, function($event) {
    Log::info('Safari completed', $event->safari->toArray());
});
```

## Resources

- 📖 Full Guide: `docs/WORKFLOW_IMPLEMENTATION_GUIDE.md`
- 📊 Summary: `WORKFLOW_IMPLEMENTATION_SUMMARY.md`
- 💻 Code: `app/Services/Workflows/`
- 📧 Events: `app/Events/`
- 🔔 Listeners: `app/Listeners/`

---

**Last Updated**: December 2024  
**Status**: ✅ Production Ready
