# Workflow Example Implementation

Complete, working examples for implementing the workflow in your application.

## Example 1: Basic Usage in Controller

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShareSafari;
use App\Services\Workflows\SafariCreationWorkflow;
use Illuminate\Http\Request;

class SafariController extends Controller
{
    private SafariCreationWorkflow $workflow;

    public function __construct(SafariCreationWorkflow $workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * Store basic safari information (Step 1)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'park_id' => 'required|exists:parks,park_id',
            'day' => 'required|integer|min:1',
            'night' => 'required|integer|min:0',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0|gte:min_price',
        ]);

        // Create safari using workflow (Step 1)
        $safari = $this->workflow->createBasicSafari($validated);

        return redirect()
            ->route('admin.safari.detail', $safari->id)
            ->with('message', 'Safari created! Now add details to continue.');
    }

    /**
     * Show detail page (Step 2)
     */
    public function detail($id)
    {
        $safari = ShareSafari::findOrFail($id);
        
        // Check workflow step
        $step = $this->workflow->getCurrentStep($safari);
        
        if ($step === 1) {
            return back()->with('error', 'Complete basic information first!');
        }

        // Get progress for display
        $progress = $this->workflow->getProgress($safari);
        $checklist = $this->workflow->getDetailsChecklist($safari);

        return view('admin.safari.detail', compact('safari', 'progress', 'checklist'));
    }

    /**
     * Update safari details (Step 2 - continued)
     */
    public function updateDetails(Request $request, $id)
    {
        $safari = ShareSafari::findOrFail($id);

        $validated = $request->validate([
            'display_image' => 'nullable|image|max:5000',
            'short_description' => 'nullable|string|max:500',
            'full_description' => 'nullable|string',
        ]);

        $safari->update($validated);

        // Update related details
        if ($request->has('inclusions')) {
            $safari->features()->sync($request->inclusions);
        }

        if ($request->has('itinerary')) {
            // Update itinerary
        }

        return back()->with('message', 'Details updated successfully!');
    }

    /**
     * Complete safari creation (Step 3)
     */
    public function complete($id)
    {
        $safari = ShareSafari::findOrFail($id);

        // Validate that all details are complete
        if (!$this->workflow->areDetailsComplete($safari)) {
            $checklist = $this->workflow->getDetailsChecklist($safari);
            return back()
                ->with('error', 'Cannot complete. Missing required details.')
                ->with('missing', $checklist);
        }

        // Mark as complete (fires event)
        $this->workflow->markAsComplete($safari);

        return redirect()
            ->route('admin.safari.show', $safari->id)
            ->with('success', 'Safari creation complete! Awaiting admin approval.');
    }

    /**
     * Show status
     */
    public function show($id)
    {
        $safari = ShareSafari::findOrFail($id);
        $step = $this->workflow->getCurrentStep($safari);
        $progress = $this->workflow->getProgress($safari);
        $message = $this->workflow->getStatusMessage($safari);

        return view('admin.safari.show', compact('safari', 'step', 'progress', 'message'));
    }
}
```

## Example 2: Livewire Component Implementation

```php
<?php

namespace App\Livewire\Admin\ShareSafari;

use App\Models\ShareSafari;
use App\Services\Workflows\SafariCreationWorkflow;
use Livewire\Component;
use Livewire\WithFileUploads;

class SafariForm extends Component
{
    use WithFileUploads;

    public SafariCreationWorkflow $workflow;
    public ShareSafari $safari;
    public $currentStep = 1;
    public $progress = 0;

    // Step 1 properties
    public $title = '';
    public $park_id = '';
    public $day = 1;
    public $night = 0;
    public $min_price = '';
    public $max_price = '';

    // Step 2 properties
    public $display_image;
    public $short_description = '';
    public $inclusions = [];
    public $itinerary = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'park_id' => 'required|exists:parks,park_id',
        'day' => 'required|integer|min:1',
        'night' => 'required|integer|min:0',
        'min_price' => 'required|numeric|min:0',
        'max_price' => 'required|numeric|gte:min_price',
        'display_image' => 'nullable|image|max:5000',
    ];

    public function mount(SafariCreationWorkflow $workflow)
    {
        $this->workflow = $workflow;
        
        if (isset($this->safari) && $this->safari->exists) {
            $this->currentStep = $this->workflow->getCurrentStep($this->safari);
            $this->progress = $this->workflow->getProgress($this->safari);
            
            // Load existing data
            $this->title = $this->safari->title;
            $this->park_id = $this->safari->park_id;
        }
    }

    /**
     * Step 1: Save basic information
     */
    public function saveBasicInfo()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'park_id' => 'required|exists:parks,park_id',
            'day' => 'required|integer|min:1',
            'night' => 'required|integer|min:0',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|gte:min_price',
        ]);

        // Create or update safari
        if (!isset($this->safari) || !$this->safari->exists) {
            $this->safari = $this->workflow->createBasicSafari($validated);
        } else {
            $this->safari->update($validated);
        }

        $this->currentStep = 2;
        $this->progress = 33;
        
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Basic information saved! Now add details.'
        ]);
    }

    /**
     * Step 2: Save details
     */
    public function saveDetails()
    {
        $validated = $this->validate([
            'display_image' => 'nullable|image|max:5000',
            'short_description' => 'nullable|string|max:500',
        ]);

        if ($this->display_image) {
            $path = $this->display_image->store('safaris', 'public');
            $validated['display_image'] = $path;
        }

        $this->safari->update($validated);

        // Save inclusions
        if (!empty($this->inclusions)) {
            $this->safari->features()->sync($this->inclusions);
        }

        $this->currentStep = 3;
        $this->progress = 66;

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Details saved! Ready to complete.'
        ]);
    }

    /**
     * Step 3: Complete creation
     */
    public function completeCreation()
    {
        // Validate all details are complete
        if (!$this->workflow->areDetailsComplete($this->safari)) {
            $checklist = $this->workflow->getDetailsChecklist($this->safari);
            
            $missing = array_filter($checklist, fn($v) => !$v);
            $missingText = implode(', ', array_keys($missing));

            $this->dispatch('toast', [
                'type' => 'error',
                'message' => "Missing: $missingText"
            ]);
            return;
        }

        // Mark as complete
        $this->workflow->markAsComplete($this->safari);

        $this->currentStep = 3;
        $this->progress = 100;

        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Safari creation complete! Awaiting approval.'
        ]);

        // Redirect after 2 seconds
        $this->dispatch('redirect', route('admin.safari.list'));
    }

    /**
     * Go back to previous step
     */
    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    /**
     * Skip optional fields
     */
    public function skip()
    {
        if ($this->currentStep === 2) {
            $this->currentStep = 3;
            $this->progress = 66;
        }
    }

    public function render()
    {
        return view('livewire.admin.safari.form', [
            'step' => $this->currentStep,
            'progress' => $this->progress,
            'statusMessage' => $this->workflow->getStatusMessage($this->safari ?? new ShareSafari()),
        ]);
    }
}
```

## Example 3: Blade Template Implementation

```blade
<!-- resources/views/admin/safari/form.blade.php -->
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <!-- Progress Display -->
            <x-workflow-progress 
                :step="$step" 
                :progress="$progress"
                :status-message="$statusMessage"
            />

            <!-- Safari Form -->
            <div class="card mt-4">
                <div class="card-body">
                    <!-- Step 1: Basic Information -->
                    @if ($step === 1)
                        <h3 class="card-title mb-4">
                            <i class="fas fa-edit"></i> Basic Information
                        </h3>

                        <form wire:submit="saveBasicInfo">
                            <div class="mb-3">
                                <label for="title" class="form-label">Safari Title *</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('title') is-invalid @enderror"
                                    id="title"
                                    wire:model="title"
                                    placeholder="Enter safari title"
                                    required
                                />
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="park_id" class="form-label">Park *</label>
                                        <select 
                                            class="form-select @error('park_id') is-invalid @enderror"
                                            id="park_id"
                                            wire:model="park_id"
                                            required
                                        >
                                            <option value="">Select Park</option>
                                            @foreach($parks as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error('park_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="day" class="form-label">Days *</label>
                                        <input 
                                            type="number" 
                                            class="form-control @error('day') is-invalid @enderror"
                                            id="day"
                                            wire:model="day"
                                            min="1"
                                            required
                                        />
                                        @error('day')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="night" class="form-label">Nights *</label>
                                        <input 
                                            type="number" 
                                            class="form-control @error('night') is-invalid @enderror"
                                            id="night"
                                            wire:model="night"
                                            min="0"
                                            required
                                        />
                                        @error('night')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="min_price" class="form-label">Min Price *</label>
                                        <input 
                                            type="number" 
                                            class="form-control @error('min_price') is-invalid @enderror"
                                            id="min_price"
                                            wire:model="min_price"
                                            step="0.01"
                                            min="0"
                                            required
                                        />
                                        @error('min_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="max_price" class="form-label">Max Price *</label>
                                <input 
                                    type="number" 
                                    class="form-control @error('max_price') is-invalid @enderror"
                                    id="max_price"
                                    wire:model="max_price"
                                    step="0.01"
                                    min="0"
                                    required
                                />
                                @error('max_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    Continue to Details
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Step 2: Details -->
                    @if ($step === 2)
                        <h3 class="card-title mb-4">
                            <i class="fas fa-images"></i> Add Details & Media
                        </h3>

                        <form wire:submit="saveDetails">
                            <div class="mb-3">
                                <label for="display_image" class="form-label">Display Image</label>
                                <input 
                                    type="file" 
                                    class="form-control @error('display_image') is-invalid @enderror"
                                    id="display_image"
                                    wire:model="display_image"
                                    accept="image/*"
                                />
                                @error('display_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Description</label>
                                <textarea 
                                    class="form-control"
                                    id="short_description"
                                    wire:model="short_description"
                                    rows="4"
                                ></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Inclusions</label>
                                <!-- Checkboxes for inclusions -->
                                @foreach($inclusions as $id => $name)
                                    <div class="form-check">
                                        <input 
                                            type="checkbox" 
                                            class="form-check-input"
                                            id="inclusion_{{ $id }}"
                                            wire:model="inclusions"
                                            value="{{ $id }}"
                                        />
                                        <label class="form-check-label" for="inclusion_{{ $id }}">
                                            {{ $name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-secondary" wire:click="previousStep">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-right me-2"></i>
                                    Continue
                                </button>
                                <button type="button" class="btn btn-outline-secondary" wire:click="skip">
                                    Skip (Optional)
                                </button>
                            </div>
                        </form>
                    @endif

                    <!-- Step 3: Review & Complete -->
                    @if ($step === 3)
                        <h3 class="card-title mb-4">
                            <i class="fas fa-check-circle"></i> Review & Complete
                        </h3>

                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            Review your safari information below. Click Complete to finalize.
                        </div>

                        <!-- Safari Summary -->
                        <div class="card mb-4 bg-light">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Title:</strong> {{ $safari->title ?? $title }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Park:</strong> {{ $safari->park->name ?? '-' }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Duration:</strong> 
                                        {{ $safari->day ?? $day }} days / {{ $safari->night ?? $night }} nights
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Price Range:</strong> 
                                        ₹{{ $safari->min_price_pp ?? $min_price }} - ₹{{ $safari->max_price_pp ?? $max_price }}
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Status:</strong> 
                                        <span class="badge bg-warning">Pending Approval</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" wire:click="previousStep">
                                <i class="fas fa-arrow-left me-2"></i>
                                Back
                            </button>
                            <button type="button" class="btn btn-success" wire:click="completeCreation">
                                <i class="fas fa-check me-2"></i>
                                Complete Safari Creation
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
```

## Example 4: Event Listener Implementation

```php
<?php

namespace App\Listeners;

use App\Events\SafariCreationCompleted;
use App\Mail\NewSafariCreatedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotifyAdminSafariCreated implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the job may be attempted
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job
     */
    public int $backoff = 60;

    /**
     * Handle the event
     */
    public function handle(SafariCreationCompleted $event): void
    {
        $safari = $event->safari;

        try {
            // Get admin user(s)
            $admins = User::where('role', 'admin')
                ->where('notify_on_creation', true)
                ->get();

            // Send email to each admin
            foreach ($admins as $admin) {
                Mail::to($admin->email)
                    ->queue(new NewSafariCreatedMail($safari, $safari->creator));
            }

            // Log the completion
            Log::info('Safari creation completed and admin notified', [
                'safari_id' => $safari->id,
                'safari_title' => $safari->title,
                'created_by' => $safari->created_by,
                'admins_notified' => $admins->count(),
            ]);

            // Record activity
            if (function_exists('activity')) {
                activity('safari_creation_completed')
                    ->causedBy($safari->creator)
                    ->performedOn($safari)
                    ->withProperties([
                        'title' => $safari->title,
                        'park' => $safari->park->name,
                    ])
                    ->log('Safari creation workflow completed');
            }

        } catch (\Exception $e) {
            Log::error('Error in safari creation notification', [
                'safari_id' => $safari->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Rethrow for queue to handle retry
            throw $e;
        }
    }

    /**
     * Handle job failure
     */
    public function failed(SafariCreationCompleted $event, \Throwable $exception): void
    {
        Log::error('Safari creation notification failed after retries', [
            'safari_id' => $event->safari->id,
            'error' => $exception->getMessage(),
        ]);

        // Send fallback notification
        Mail::raw('Safari creation notification failed', function($message) {
            $message->to(config('app.admin_email'))
                ->subject('Alert: Safari Creation Notification Failed');
        });
    }
}
```

## Example 5: Test Implementation

```php
<?php

namespace Tests\Feature;

use App\Events\SafariCreationCompleted;
use App\Models\ShareSafari;
use App\Services\Workflows\SafariCreationWorkflow;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SafariCreationWorkflowTest extends TestCase
{
    private SafariCreationWorkflow $workflow;

    protected function setUp(): void
    {
        parent::setUp();
        $this->workflow = new SafariCreationWorkflow();
    }

    /**
     * Test creating a safari with basic information
     */
    public function test_user_can_create_safari_with_basic_info()
    {
        $data = [
            'title' => 'African Safari Adventure',
            'park_id' => 1,
            'day' => 3,
            'night' => 2,
            'min_price' => 5000,
            'max_price' => 10000,
        ];

        $safari = $this->workflow->createBasicSafari($data);

        $this->assertDatabaseHas('share_safaris', [
            'id' => $safari->id,
            'title' => 'African Safari Adventure',
            'is_create_safari_complete' => false,
        ]);
    }

    /**
     * Test workflow step progression
     */
    public function test_workflow_step_progression()
    {
        // Create basic safari
        $safari = ShareSafari::factory()
            ->create(['is_create_safari_complete' => false]);

        // Should be step 1
        $this->assertEquals(1, $this->workflow->getCurrentStep($safari));

        // Add image
        $safari->update(['display_image' => 'test.jpg']);

        // Should be step 2
        $this->assertEquals(2, $this->workflow->getCurrentStep($safari));

        // Mark complete
        $this->workflow->markAsComplete($safari);

        // Should be step 3
        $this->assertTrue($safari->fresh()->is_create_safari_complete);
    }

    /**
     * Test event is dispatched on completion
     */
    public function test_completion_event_is_dispatched()
    {
        Event::fake();

        $safari = ShareSafari::factory()
            ->create(['display_image' => 'test.jpg']);

        $this->workflow->markAsComplete($safari);

        Event::assertDispatched(SafariCreationCompleted::class);
    }

    /**
     * Test progress calculation
     */
    public function test_progress_calculation()
    {
        $safari = ShareSafari::factory()
            ->create(['is_create_safari_complete' => false]);

        $progress = $this->workflow->getProgress($safari);
        
        // Initial progress should be ~33%
        $this->assertGreaterThanOrEqual(33, $progress);
    }

    /**
     * Test validation checklist
     */
    public function test_details_checklist()
    {
        $safari = ShareSafari::factory()
            ->create(['display_image' => null]);

        $checklist = $this->workflow->getDetailsChecklist($safari);

        $this->assertFalse($checklist['display_image']);
    }
}
```

---

These examples provide complete, working implementations ready for your application. Adapt them to your specific needs and database structure.
