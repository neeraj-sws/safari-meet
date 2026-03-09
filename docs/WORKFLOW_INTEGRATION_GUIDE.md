# Workflow Integration Checklist & Setup Guide

## Pre-Integration Requirements

✅ Laravel 11+  
✅ Livewire 3+  
✅ Database with ShareSafari and Package tables  
✅ Mail driver configured  

## Step-by-Step Integration

### Phase 1: Core Registration (30 minutes)

#### 1.1 Register Event Listeners

**File**: `app/Providers/EventServiceProvider.php`

```php
<?php

namespace App\Providers;

use App\Events\SafariCreationCompleted;
use App\Events\PackageCreationCompleted;
use App\Listeners\NotifyAdminSafariCreated;
use App\Listeners\NotifyAdminPackageCreated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        SafariCreationCompleted::class => [
            NotifyAdminSafariCreated::class,
        ],
        PackageCreationCompleted::class => [
            NotifyAdminPackageCreated::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
```

#### 1.2 Verify Workflow Services Exist

Check these files exist:
- ✅ `app/Services/Workflows/SafariCreationWorkflow.php`
- ✅ `app/Services/Workflows/PackageCreationWorkflow.php`

If missing, create them (see Workflow Implementation Summary).

#### 1.3 Verify Event Classes Exist

Check these files exist:
- ✅ `app/Events/SafariCreationCompleted.php`
- ✅ `app/Events/PackageCreationCompleted.php`

#### 1.4 Verify Listener Classes Exist

Check these files exist:
- ✅ `app/Listeners/NotifyAdminSafariCreated.php`
- ✅ `app/Listeners/NotifyAdminPackageCreated.php`

### Phase 2: Mail Notifications (20 minutes)

#### 2.1 Create Safari Mail Class

**File**: `app/Mail/NewSafariCreatedMail.php`

```php
<?php

namespace App\Mail;

use App\Models\ShareSafari;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewSafariCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public ShareSafari $safari,
        public $user = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Safari Created: {$this->safari->title}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.safari-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
```

#### 2.2 Create Package Mail Class

**File**: `app/Mail/NewPackageCreatedMail.php`

```php
<?php

namespace App\Mail;

use App\Models\Package;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewPackageCreatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Package $package,
        public $user = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Package Created: {$this->package->title}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.package-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
```

#### 2.3 Create Mail Views

**File**: `resources/views/emails/safari-created.blade.php`

```blade
<x-mail::message>
# New Safari Created

A new Safari has been created and needs your review.

<x-mail::panel>
**Safari Title:** {{ $safari->title }}

**Park:** {{ $safari->park->name ?? 'N/A' }}

**Price Range:** ₹{{ $safari->min_price_pp }} - ₹{{ $safari->max_price_pp }}

**Duration:** {{ $safari->day }} Days, {{ $safari->night }} Nights

**Created By:** {{ $safari->creator->name ?? 'Unknown' }}

**Created At:** {{ $safari->created_at->format('Y-m-d H:i:s') }}
</x-mail::panel>

<x-mail::button :url="route('admin.sharedsafari.addsafari') . '?edit=' . $safari->id">
Review Safari
</x-mail::button>

Thanks,
{{ config('app.name') }}
</x-mail::message>
```

**File**: `resources/views/emails/package-created.blade.php`

```blade
<x-mail::message>
# New Package Created

A new Package has been created and needs your review.

<x-mail::panel>
**Package Title:** {{ $package->title }}

**Park:** {{ $package->park->name ?? 'N/A' }}

**Price Range:** ₹{{ $package->min_price }} - ₹{{ $package->max_price }}

**Created By:** {{ $package->creator->name ?? 'Unknown' }}

**Created At:** {{ $package->created_at->format('Y-m-d H:i:s') }}
</x-mail::panel>

<x-mail::button :url="route('admin.package.list')">
Review Package
</x-mail::button>

Thanks,
{{ config('app.name') }}
</x-mail::message>
```

### Phase 3: UI Components (25 minutes)

#### 3.1 Verify Workflow Progress Component

Check that this file exists:
- ✅ `resources/views/components/workflow-progress.blade.php`

#### 3.2 Update ShareSafari Index View

**File**: `resources/views/livewire/admin/share-safari/index.blade.php`

Add this after the filter section:

```blade
@if(isset($safari) && isset($workflow))
    @php
        $step = $workflow->getCurrentStep($safari);
        $progress = $workflow->getProgress($safari);
        $message = $workflow->getStatusMessage($safari);
    @endphp
    
    <x-workflow-progress 
        :step="$step" 
        :progress="$progress"
        :status-message="$message"
    />
@endif
```

#### 3.3 Update Detail Page

**File**: `resources/views/livewire/admin/share-safari/detail.blade.php`

Add workflow progress at top:

```blade
@php
    use App\Services\Workflows\SafariCreationWorkflow;
    $workflow = app(SafariCreationWorkflow::class);
    if(isset($safari)) {
        $step = $workflow->getCurrentStep($safari);
        $progress = $workflow->getProgress($safari);
        $message = $workflow->getStatusMessage($safari);
    }
@endphp

@if(isset($step))
    <x-workflow-progress 
        :step="$step" 
        :progress="$progress"
        :status-message="$message"
    />
@endif

<!-- Rest of detail page -->
```

### Phase 4: Component Integration (30 minutes)

#### 4.1 Update ShareSafariCrud Component

**File**: `app/Livewire/Admin/ShareSafari/ShareSafariCrud.php`

Verify these changes are in place:

```php
use App\Services\Workflows\SafariCreationWorkflow;

// In detail method:
public function detail($id, SafariCreationWorkflow $workflow)
{
    $safari = ShareSafari::find($id);
    
    if (!$safari) {
        $this->dispatch('swal:toast', [
            'type' => 'error',
            'title' => 'Error',
            'message' => 'Safari not found!'
        ]);
        return;
    }

    $this->ids = $id;
    $this->details = 1;
    
    $currentStep = $workflow->getCurrentStep($safari);
    
    if ($currentStep === 1) {
        $this->dispatch('swal:toast', [
            'type' => 'warning',
            'title' => 'Complete Step 1',
            'message' => 'Please complete basic information first!'
        ]);
        return;
    }
}

// Add new method for completion:
public function markComplete($id, SafariCreationWorkflow $workflow)
{
    $safari = ShareSafari::find($id);
    
    if (!$safari) {
        $this->dispatch('swal:toast', [
            'type' => 'error',
            'message' => 'Safari not found!'
        ]);
        return;
    }

    if (!$workflow->areDetailsComplete($safari)) {
        $checklist = $workflow->getDetailsChecklist($safari);
        $this->dispatch('swal:toast', [
            'type' => 'warning',
            'message' => 'Complete missing details before marking complete'
        ]);
        return;
    }

    if ($workflow->markAsComplete($safari)) {
        $this->dispatch('swal:toast', [
            'type' => 'success',
            'message' => 'Safari creation complete! Awaiting approval.'
        ]);
    }
}
```

#### 4.2 Create Package CRUD Component (if not exists)

**File**: `app/Livewire/Admin/Package/PackageCrud.php`

```php
<?php

namespace App\Livewire\Admin\Package;

use App\Models\Package;
use App\Services\Workflows\PackageCreationWorkflow;
use Livewire\Component;

class PackageCrud extends Component
{
    public function markComplete($id, PackageCreationWorkflow $workflow)
    {
        $package = Package::find($id);
        
        if (!$package) {
            $this->dispatch('swal:toast', [
                'type' => 'error',
                'message' => 'Package not found!'
            ]);
            return;
        }

        if (!$workflow->areDetailsComplete($package)) {
            $this->dispatch('swal:toast', [
                'type' => 'warning',
                'message' => 'Complete missing details'
            ]);
            return;
        }

        if ($workflow->markAsComplete($package)) {
            $this->dispatch('swal:toast', [
                'type' => 'success',
                'message' => 'Package creation complete!'
            ]);
        }
    }
}
```

### Phase 5: Testing (40 minutes)

#### 5.1 Create Unit Test

**File**: `tests/Unit/SafariCreationWorkflowTest.php`

```php
<?php

namespace Tests\Unit;

use App\Models\ShareSafari;
use App\Services\Workflows\SafariCreationWorkflow;
use Tests\TestCase;

class SafariCreationWorkflowTest extends TestCase
{
    private SafariCreationWorkflow $workflow;

    protected function setUp(): void
    {
        parent::setUp();
        $this->workflow = new SafariCreationWorkflow();
    }

    public function test_create_basic_safari()
    {
        $safari = $this->workflow->createBasicSafari([
            'title' => 'Test Safari',
            'park_id' => 1,
            'day' => 2,
            'night' => 1,
            'min_price' => 1000,
            'max_price' => 2000,
        ]);

        $this->assertFalse($safari->is_create_safari_complete);
        $this->assertEquals('Test Safari', $safari->title);
    }

    public function test_get_current_step()
    {
        $safari = ShareSafari::factory()->create();
        $step = $this->workflow->getCurrentStep($safari);
        
        $this->assertIsInt($step);
        $this->assertGreaterThanOrEqual(1, $step);
        $this->assertLessThanOrEqual(3, $step);
    }

    public function test_get_progress_percentage()
    {
        $safari = ShareSafari::factory()->create();
        $progress = $this->workflow->getProgress($safari);
        
        $this->assertIsInt($progress);
        $this->assertGreaterThanOrEqual(0, $progress);
        $this->assertLessThanOrEqual(100, $progress);
    }

    public function test_get_status_message()
    {
        $safari = ShareSafari::factory()->create();
        $message = $this->workflow->getStatusMessage($safari);
        
        $this->assertIsString($message);
        $this->assertNotEmpty($message);
    }
}
```

#### 5.2 Run Tests

```bash
php artisan test tests/Unit/SafariCreationWorkflowTest.php
```

### Phase 6: Configuration (15 minutes)

#### 6.1 Set Admin Email

**File**: `.env`

```env
APP_ADMIN_EMAIL=admin@safarimeet.com
MAIL_FROM_ADDRESS=noreply@safarimeet.com
MAIL_FROM_NAME="SafariMeet"
```

#### 6.2 Configure Queue (Optional but Recommended)

**File**: `.env`

```env
QUEUE_CONNECTION=redis
# or
QUEUE_CONNECTION=database
```

#### 6.3 Start Queue Worker (if using queued listeners)

```bash
php artisan queue:work
```

### Phase 7: Verification (20 minutes)

#### 7.1 Verify Event System

```bash
# Check EventServiceProvider has listeners registered
php artisan tinker
>>> event(new \App\Events\SafariCreationCompleted(\App\Models\ShareSafari::first()))
# Should see: Event fired successfully
```

#### 7.2 Test Safari Creation Flow

1. Create a new safari with basic info
2. Verify status message shows "Complete basic information"
3. Navigate to details page
4. Add display image
5. Verify progress increases to 66%
6. Click "Mark Complete"
7. Check email received
8. Verify logs show event fired

#### 7.3 Check Logs

```bash
tail -f storage/logs/laravel.log
tail -f storage/logs/activity.log
```

#### 7.4 Test Email

```bash
# Use Laravel's Email Fake for testing
php artisan tinker
>>> Mail::fake()
>>> event(new \App\Events\SafariCreationCompleted(\App\Models\ShareSafari::first()))
>>> Mail::assertSent(\App\Mail\NewSafariCreatedMail::class)
```

### Phase 8: Deployment (15 minutes)

#### 8.1 Run Migrations

```bash
php artisan migrate
```

#### 8.2 Clear Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 8.3 Build Assets (if needed)

```bash
npm run build
```

#### 8.4 Start Services

```bash
# If using queue
php artisan queue:work &

# If using scheduled tasks
php artisan schedule:run &
```

## Post-Integration Checklist

### Before Going Live

- [ ] Event listeners registered in EventServiceProvider
- [ ] Mail classes created and tested
- [ ] Mail views created
- [ ] ShareSafariCrud component updated
- [ ] Workflow progress component in place
- [ ] UI templates updated
- [ ] Unit tests created and passing
- [ ] Queue worker running (if async)
- [ ] Admin email configured
- [ ] All logs checked for errors
- [ ] End-to-end workflow tested
- [ ] Emails verified to be sending
- [ ] Database backup taken

### Monitoring After Deployment

- [ ] Monitor queue for failed jobs
- [ ] Check logs for errors
- [ ] Verify emails being sent
- [ ] Track user feedback
- [ ] Monitor performance metrics
- [ ] Check event dispatch logs

## Troubleshooting Integration Issues

### Email Not Sending

```php
// In EventServiceProvider, check if listener is registered
// Run: php artisan event:list

// Check mail configuration in .env
// Check if mail driver is set (MAIL_DRIVER=smtp, etc.)

// Test mail manually:
php artisan tinker
>>> Mail::raw('Test', function($message) { $message->to('test@example.com'); });
```

### Event Not Firing

```php
// Verify EventServiceProvider has listener mapped
// Verify event class exists at app/Events/
// Verify listener class exists at app/Listeners/

// Debug:
php artisan tinker
>>> event(new \App\Events\SafariCreationCompleted(\App\Models\ShareSafari::first()));
// Should see no errors
```

### Workflow Not Progressing

```php
// Check if model relationships exist in database
php artisan tinker
>>> $safari = \App\Models\ShareSafari::first();
>>> $safari->park()->exists(); // Should be true
>>> $safari->features()->exists(); // Should be true
```

### Progress Always at 0%

```php
// Verify details are being saved to database
php artisan tinker
>>> $safari = \App\Models\ShareSafari::first();
>>> $safari->display_image; // Should have value
>>> $safari->features()->exists(); // Should be true
```

## Performance Optimization Tips

1. **Cache Workflow Results** (if checking frequently):
   ```php
   Cache::remember("safari.{$id}.step", 3600, fn() => $workflow->getCurrentStep($safari));
   ```

2. **Queue Email Notifications**:
   ```php
   // Listeners extend ShouldQueue
   class NotifyAdminSafariCreated implements ShouldQueue
   ```

3. **Index Workflow-Related Columns**:
   ```sql
   ALTER TABLE share_safaris ADD INDEX idx_is_complete (is_create_safari_complete);
   ALTER TABLE packages ADD INDEX idx_is_complete (is_package_complete);
   ```

4. **Use Eager Loading**:
   ```php
   ShareSafari::with('park', 'features')->get();
   ```

## Support & Documentation

- 📖 **Full Guide**: `docs/WORKFLOW_IMPLEMENTATION_GUIDE.md`
- 📊 **Summary**: `WORKFLOW_IMPLEMENTATION_SUMMARY.md`
- ⚡ **Quick Ref**: `docs/WORKFLOW_QUICK_REFERENCE.md`
- 💻 **Services**: `app/Services/Workflows/`
- 📧 **Events**: `app/Events/`
- 🔔 **Listeners**: `app/Listeners/`

## Integration Complete! 🎉

Once all phases are complete, your workflow system is production-ready:

✅ 3-step guided creation  
✅ Progress tracking  
✅ Email notifications  
✅ Event-driven architecture  
✅ SOLID principle compliance  
✅ Fully documented  
✅ Tested and verified  

---

**Last Updated**: December 2024  
**Status**: ✅ Ready for Production Deployment
