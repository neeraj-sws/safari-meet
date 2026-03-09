# Common Components - Visual Flow Guide

## 🎨 Visual Architecture Overview

### High-Level Component Flow

```
┌─────────────────────────────────────────────────────────────┐
│                    BLADE VIEW (Admin UI)                     │
│                                                              │
│  ShareSafari Detail Page         Package Detail Page        │
│  ┌──────────────────┐            ┌──────────────────┐      │
│  │ Things to Carry  │            │ Things to Carry  │      │
│  │ type=1, id=$id   │            │ type=2, id=$id   │      │
│  └──────────────────┘            └──────────────────┘      │
│  ┌──────────────────┐            ┌──────────────────┐      │
│  │ Inclusions       │            │ Inclusions       │      │
│  │ type=1, id=$id   │            │ type=2, id=$id   │      │
│  └──────────────────┘            └──────────────────┘      │
│  ┌──────────────────┐            ┌──────────────────┐      │
│  │ FAQs             │            │ FAQs             │      │
│  │ type=1, id=$id   │            │ type=2, id=$id   │      │
│  └──────────────────┘            └──────────────────┘      │
│  ┌──────────────────┐            ┌──────────────────┐      │
│  │ Itinerary        │            │ Itinerary        │      │
│  │ type=1, id=$id   │            │ type=2, id=$id   │      │
│  └──────────────────┘            └──────────────────┘      │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│           LIVEWIRE COMPONENTS (UI Layer)                     │
│           app/Livewire/Admin/Common/                        │
│                                                              │
│  Responsibilities:                                          │
│  • UI State ($showForm, $formItems, $isEditing)            │
│  • Form Validation (rules() method)                        │
│  • User Interaction Events (toggleForm, addFormItem)       │
│  • Livewire Events (dispatch notifications)                │
│                                                              │
│  Components:                                                │
│  • ThingsToCarry.php                                       │
│  • FAQS.php                                                │
│  • InclusionExclusionsComponent.php                        │
│  • Itinerary.php                                           │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ delegates business logic
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│           FORM REQUEST VALIDATION (Optional)                │
│           app/Http/Requests/Admin/Common/                   │
│                                                              │
│  • StoreThingsToCarryRequest.php                           │
│  • StoreInclusionExclusionRequest.php                      │
│  • StoreFaqRequest.php                                     │
│  • StoreItineraryRequest.php                               │
└─────────────────────────────────────────────────────────────┘
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│           SERVICE LAYER (Business Logic)                    │
│           app/Services/AdminCommonContentService.php        │
│                                                              │
│  Responsibilities:                                          │
│  • Model Resolution (type → ShareSafari or Package)        │
│  • Database Operations (CRUD)                              │
│  • Business Workflows                                       │
│  • Complex Queries                                          │
│                                                              │
│  Key Methods:                                               │
│  ┌──────────────────────────────────────────────┐         │
│  │ resolveModel(type, id)                       │         │
│  │   → ShareSafari | Package                    │         │
│  └──────────────────────────────────────────────┘         │
│  ┌──────────────────────────────────────────────┐         │
│  │ getColumnName(type)                          │         │
│  │   → 'share_safari_id' | 'package_id'         │         │
│  └──────────────────────────────────────────────┘         │
│  ┌──────────────────────────────────────────────┐         │
│  │ getThingsToCarryList(type, modelId)          │         │
│  │ storeThingsToCarry(type, modelId, items)     │         │
│  │ deleteThingToCarry(type, id)                 │         │
│  └──────────────────────────────────────────────┘         │
│  ┌──────────────────────────────────────────────┐         │
│  │ getFeatures(type, modelId, featureType)      │         │
│  │ storeFeatures(type, modelId, items, type)    │         │
│  │ deleteFeature(type, id)                      │         │
│  └──────────────────────────────────────────────┘         │
│  ┌──────────────────────────────────────────────┐         │
│  │ getParkFaqs(parkId)                          │         │
│  │ storeFaqs(parkId, questions, faqId)          │         │
│  │ deleteFaq(id)                                │         │
│  └──────────────────────────────────────────────┘         │
│  ┌──────────────────────────────────────────────┐         │
│  │ getItineraryDayWiseData(type, modelId)       │         │
│  │ storeItinerary(type, modelId, data)          │         │
│  │ deleteItinerary(type, id)                    │         │
│  └──────────────────────────────────────────────┘         │
└─────────────────────────────────────────────────────────────┘
                            │
                            │ uses
                            │
                            ▼
┌─────────────────────────────────────────────────────────────┐
│           ELOQUENT MODELS (Data Layer)                      │
│           app/Models/                                        │
│                                                              │
│  Base Models:                    Junction Models:           │
│  • ShareSafari.php              • FeatureThingsToCarrySafari│
│  • Package.php                  • FeaturePackageSafari      │
│  • ThingsToCarry.php            • ParkFaq.php               │
│  • Feature.php                  • ItineraryPackage.php      │
│  • Faq.php                      • ItineraryPackageActivity  │
│                                                              │
│  Responsibilities:                                          │
│  • Database Relationships                                   │
│  • Accessors/Mutators                                       │
│  • Query Scopes                                             │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔄 Type Resolution Flow

```
┌─────────────────────────────────────────────────────────────┐
│                 TYPE PARAMETER FLOW                          │
└─────────────────────────────────────────────────────────────┘

User passes type parameter
        │
        ▼
┌───────────────┐           ┌───────────────┐
│   type = 1    │           │   type = 2    │
│  (ShareSafari)│           │   (Package)   │
└───────┬───────┘           └───────┬───────┘
        │                           │
        ▼                           ▼
  resolveModel()              resolveModel()
        │                           │
        ▼                           ▼
┌──────────────────┐       ┌──────────────────┐
│ ShareSafari      │       │ Package          │
│ ::findOrFail($id)│       │ ::findOrFail($id)│
└──────────────────┘       └──────────────────┘
        │                           │
        ▼                           ▼
  getColumnName()             getColumnName()
        │                           │
        ▼                           ▼
┌──────────────────┐       ┌──────────────────┐
│'share_safari_id' │       │  'package_id'    │
└──────────────────┘       └──────────────────┘
        │                           │
        └───────────┬───────────────┘
                    ▼
        Used in database queries
                    │
                    ▼
        Model::where($columnName, $modelId)
```

---

## 📊 CRUD Operation Flow

### Create/Update Flow

```
┌──────────────────────────────────────────────────────────┐
│  1. USER FILLS FORM                                       │
│     Component: $formItems = [                            │
│         ['title' => 'Sunscreen', 'description' => '...'] │
│     ]                                                     │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  2. USER CLICKS SAVE                                      │
│     Component: public function store()                   │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  3. VALIDATION                                            │
│     Component: $this->validate($this->rules())           │
│     or Form Request validation                           │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  4. DELEGATE TO SERVICE                                   │
│     Component:                                           │
│     $service->storeThingsToCarry(                        │
│         $this->type,                                     │
│         $this->modelTable->id,                           │
│         $this->formItems                                 │
│     )                                                    │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  5. SERVICE RESOLVES COLUMN NAME                         │
│     Service: $columnName = $this->getColumnName($type)   │
│     Result: 'share_safari_id' or 'package_id'           │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  6. SERVICE CREATES RECORDS                              │
│     Service: foreach ($formItems as $item)               │
│         ThingsToCarry::create([                          │
│             'title' => $item['title'],                   │
│             'description' => $item['description']        │
│         ]);                                              │
│         FeatureThingsToCarrySafari::create([             │
│             $columnName => $modelId,                     │
│             'things_to_carry_id' => $thingsToCarry->id   │
│         ]);                                              │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  7. COMPONENT HANDLES UI FEEDBACK                        │
│     Component:                                           │
│     $this->reset('formItems', 'showForm');              │
│     $this->dispatch('swal:toast', [                     │
│         'type' => 'success',                            │
│         'message' => 'Saved successfully.'              │
│     ]);                                                  │
└──────────────────────────────────────────────────────────┘
```

### Read/Render Flow

```
┌──────────────────────────────────────────────────────────┐
│  1. COMPONENT MOUNTS                                      │
│     Component: public function mount($type, $id, Service) │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  2. RESOLVE MODEL                                         │
│     Service: $model = $this->resolveModel($type, $id)    │
│     Result: ShareSafari or Package instance              │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  3. COMPONENT RENDERS                                     │
│     Component: public function render(Service $service)  │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  4. SERVICE FETCHES DATA                                  │
│     Service: $columnName = $this->getColumnName($type)   │
│     Service: return FeatureThingsToCarrySafari           │
│         ::where($columnName, $modelId)                   │
│         ->with('thingstocarry')                          │
│         ->get();                                         │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  5. COMPONENT ASSIGNS TO PROPERTY                        │
│     Component:                                           │
│     $this->thingsToCarryList = $service->getList(...)    │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  6. BLADE VIEW DISPLAYS DATA                             │
│     Blade: @foreach($thingsToCarryList as $item)         │
│         <div>{{ $item->thingstocarry->title }}</div>    │
│     @endforeach                                          │
└──────────────────────────────────────────────────────────┘
```

### Delete Flow

```
┌──────────────────────────────────────────────────────────┐
│  1. USER CLICKS DELETE                                    │
│     Component: wire:click="delete({{ $id }})"            │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  2. COMPONENT CALLS DELETE                               │
│     Component: public function delete($id, Service)      │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  3. SERVICE DELETES RECORD                               │
│     Service: FeatureThingsToCarrySafari                  │
│         ::where('id', $id)->delete();                    │
└─────────────────────┬────────────────────────────────────┘
                      │
                      ▼
┌──────────────────────────────────────────────────────────┐
│  4. COMPONENT DISPATCHES SUCCESS                         │
│     Component: $this->dispatch('swal:toast', [          │
│         'type' => 'success',                            │
│         'message' => 'Deleted successfully.'            │
│     ]);                                                  │
└──────────────────────────────────────────────────────────┘
```

---

## 🎯 Component Interaction Flow

### Things to Carry Component

```
┌─────────────────────────────────────────────────────────┐
│  ThingsToCarry Component                                │
│  ┌───────────────────────────────────────────────────┐ │
│  │ UI State:                                         │ │
│  │ • $showForm = false                               │ │
│  │ • $formItems = []                                 │ │
│  │ • $featurethingstocarry = null                    │ │
│  │ • $thingsToCarries = []                           │ │
│  │ • $thingsToCarryList = []                         │ │
│  └───────────────────────────────────────────────────┘ │
│                                                         │
│  Methods:                                               │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────┐ │
│  │ toggleForm() │  │ addFormItem()│  │ removeItem()│ │
│  │     ↓        │  │     ↓        │  │     ↓       │ │
│  │ UI Changes   │  │ Array Push   │  │ Array Pop   │ │
│  └──────────────┘  └──────────────┘  └─────────────┘ │
│                                                         │
│  ┌──────────────┐  ┌──────────────┐  ┌─────────────┐ │
│  │   store()    │  │  delete($id) │  │ render()    │ │
│  │      ↓       │  │      ↓       │  │     ↓       │ │
│  │  → Service   │  │  → Service   │  │ → Service   │ │
│  └──────────────┘  └──────────────┘  └─────────────┘ │
└─────────────────────────────────────────────────────────┘
                    ↓
    ┌───────────────────────────────────┐
    │ AdminCommonContentService         │
    │ • storeThingsToCarry()            │
    │ • deleteThingToCarry()            │
    │ • getThingsToCarryList()          │
    └───────────────────────────────────┘
```

### Inclusions/Exclusions Component

```
┌─────────────────────────────────────────────────────────┐
│  InclusionExclusionsComponent                           │
│  ┌───────────────────────────────────────────────────┐ │
│  │ UI State:                                         │ │
│  │ • $featureType (1=Inclusions, 2=Exclusions)       │ │
│  │ • $showForm = false                               │ │
│  │ • $items = []                                     │ │
│  │ • $features = []                                  │ │
│  │ • $featureList = []                               │ │
│  └───────────────────────────────────────────────────┘ │
│                                                         │
│  Type-Specific Behavior:                                │
│  ┌──────────────────┐      ┌──────────────────┐       │
│  │ featureType = 1  │      │ featureType = 2  │       │
│  │   Inclusions     │      │   Exclusions     │       │
│  │                  │      │                  │       │
│  │ Shows: What's    │      │ Shows: What's    │       │
│  │ included in pkg  │      │ NOT included     │       │
│  └──────────────────┘      └──────────────────┘       │
│           │                         │                  │
│           └────────┬────────────────┘                  │
│                    ↓                                   │
│    ┌────────────────────────────────────┐             │
│    │ Same Service, Different Filter     │             │
│    │ getFeatures(..., $featureType)     │             │
│    └────────────────────────────────────┘             │
└─────────────────────────────────────────────────────────┘
```

---

## 🔀 Data Flow Diagram

### Complete Request-Response Cycle

```
[USER] → [BLADE VIEW] → [LIVEWIRE] → [SERVICE] → [MODEL] → [DATABASE]
                                                                  │
[USER] ← [BLADE VIEW] ← [LIVEWIRE] ← [SERVICE] ← [MODEL] ← ─────┘

Detailed Steps:

1. User Action (Click, Type, Submit)
        ↓
2. Blade Wire Directive (wire:click, wire:model)
        ↓
3. Livewire Component Method Called
        ↓
4. Component Validates Input
        ↓
5. Component Calls Service Method
        ↓
6. Service Resolves Model (type → ShareSafari/Package)
        ↓
7. Service Performs Business Logic
        ↓
8. Service Uses Eloquent Model
        ↓
9. Model Executes Database Query
        ↓
10. Database Returns Result
        ↓
11. Model Returns to Service
        ↓
12. Service Returns to Component
        ↓
13. Component Updates UI State
        ↓
14. Component Dispatches Event (toast notification)
        ↓
15. Blade Re-renders with New Data
        ↓
16. User Sees Updated UI
```

---

## 📦 Database Schema Relationships

```
┌──────────────────┐
│  ShareSafari     │
│  • id            │
│  • title         │
│  • start_date    │
│  • end_date      │
└────────┬─────────┘
         │
         │ has many
         │
         ▼
┌────────────────────────────┐
│ FeatureThingsToCarrySafari │
│ • id                       │
│ • share_safari_id (FK)     │◄────── type=1 uses this
│ • package_id (FK)          │◄────── type=2 uses this
│ • things_to_carry_id (FK)  │
└─────────┬──────────────────┘
          │
          │ belongs to
          │
          ▼
┌──────────────────┐
│ ThingsToCarry    │
│ • id             │
│ • title          │
│ • description    │
└──────────────────┘


┌──────────────────┐
│  Package         │
│  • id            │
│  • title         │
│  • start_date    │
│  • end_date      │
└────────┬─────────┘
         │
         │ has many
         │
         ▼
┌────────────────────────────┐
│ FeaturePackageSafari       │
│ • id                       │
│ • share_safari_id (FK)     │
│ • package_id (FK)          │
│ • feature_id (FK)          │
└─────────┬──────────────────┘
          │
          │ belongs to
          │
          ▼
┌──────────────────┐
│ Feature          │
│ • id             │
│ • title          │
│ • icon           │
│ • type (1 or 2)  │ ◄── 1=Inclusions, 2=Exclusions
└──────────────────┘
```

---

## 🎭 Polymorphic Pattern Visualization

```
┌─────────────────────────────────────────────────────────┐
│          POLYMORPHIC SERVICE PATTERN                     │
└─────────────────────────────────────────────────────────┘

                    AdminCommonContentService
                              │
                              │
                    ┌─────────┴─────────┐
                    │                   │
                 type=1              type=2
                    │                   │
                    ▼                   ▼
            ┌───────────────┐   ┌───────────────┐
            │ ShareSafari   │   │   Package     │
            │               │   │               │
            │ Uses:         │   │ Uses:         │
            │ share_safari_ │   │ package_id    │
            │ id            │   │               │
            └───────────────┘   └───────────────┘
                    │                   │
                    └─────────┬─────────┘
                              │
                    Same Junction Tables
                              │
        ┌─────────────────────┼─────────────────────┐
        │                     │                     │
        ▼                     ▼                     ▼
┌───────────────┐   ┌──────────────┐   ┌──────────────┐
│ Things to     │   │ Features     │   │ Itinerary    │
│ Carry         │   │ (Inclusions/ │   │ (Day-wise    │
│               │   │  Exclusions) │   │  Activities) │
└───────────────┘   └──────────────┘   └──────────────┘

KEY BENEFIT: Same component code works for both entity types!
```

---

## 🧩 Component Reusability Map

```
┌─────────────────────────────────────────────────────────┐
│  COMPONENT REUSABILITY ACROSS ENTITIES                   │
└─────────────────────────────────────────────────────────┘

┌─────────────────────┐         ┌─────────────────────┐
│  ShareSafari Pages  │         │   Package Pages     │
└─────────────────────┘         └─────────────────────┘
         │                               │
         │  Same Components!             │
         │  Just different type param    │
         │                               │
         └───────────┬───────────────────┘
                     │
     ┌───────────────┼───────────────┐
     │               │               │
     ▼               ▼               ▼
┌─────────┐   ┌──────────┐   ┌──────────┐
│ Things  │   │ Incl/Excl│   │Itinerary │
│to Carry │   │          │   │          │
└─────────┘   └──────────┘   └──────────┘
     │               │               │
     └───────────────┼───────────────┘
                     │
                     ▼
        AdminCommonContentService
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
  [ShareSafari DB]         [Package DB]

RESULT: Write once, use everywhere!
```

---

## 🎬 Animation: Store Operation Flow

```
Step 1: User Fills Form
┌────────────────────────┐
│ [Title: Sunscreen    ] │
│ [Desc: SPF 50+       ] │
│ [Add Item] [Save]      │
└────────────────────────┘

Step 2: Click Save → Component Validates
┌────────────────────────┐
│ ✓ Validation passed    │
│ Calling service...     │
└────────────────────────┘

Step 3: Service Resolves Type
┌────────────────────────┐
│ type=1                 │
│ → ShareSafari          │
│ → share_safari_id      │
└────────────────────────┘

Step 4: Service Creates Records
┌────────────────────────┐
│ Creating:              │
│ ThingsToCarry          │
│ FeatureThings...Safari │
└────────────────────────┘

Step 5: Component Shows Success
┌────────────────────────┐
│ ✓ Saved successfully!  │
│ [List Updated]         │
└────────────────────────┘
```

---

## 📈 Benefits Visualization

### Before Refactoring

```
Component A (ShareSafari)     Component B (Package)
┌──────────────────────┐      ┌──────────────────────┐
│ if (type == 1) {     │      │ if (type == 2) {     │
│   // ShareSafari     │      │   // Package         │
│   $model = Share...  │      │   $model = Pack...   │
│   $col = 'share_...' │      │   $col = 'package_id'│
│   // Create logic    │      │   // Create logic    │
│   // Delete logic    │      │   // Delete logic    │
│ }                    │      │ }                    │
└──────────────────────┘      └──────────────────────┘

Issues:
❌ Code duplication
❌ Hard to maintain (change in 2 places)
❌ Hard to test
❌ Violates DRY principle
```

### After Refactoring

```
Component A               Component B
┌──────────────┐         ┌──────────────┐
│ type=1       │         │ type=2       │
│ Uses Service │         │ Uses Service │
└──────┬───────┘         └──────┬───────┘
       │                        │
       └────────┬───────────────┘
                │
                ▼
   ┌────────────────────────┐
   │ AdminCommonContent     │
   │ Service                │
   │                        │
   │ • resolveModel()       │
   │ • All CRUD operations  │
   └────────────────────────┘

Benefits:
✅ No duplication
✅ Single source of truth
✅ Easy to test
✅ Easy to maintain
✅ Follows SOLID principles
```

---

## 🎯 Quick Decision Tree

```
                 Need common content operation?
                           │
                           ▼
                    ┌──────────────┐
                    │ Type known?  │
                    └──────┬───────┘
                           │
          ┌────────────────┼────────────────┐
          │                                 │
        Yes                                No
          │                                 │
          ▼                                 ▼
    ┌──────────┐                  ┌──────────────┐
    │ Pass type│                  │ Determine    │
    │ to       │                  │ from context │
    │ component│                  └──────┬───────┘
    └────┬─────┘                         │
         │                                │
         └────────────┬───────────────────┘
                      │
                      ▼
            Component injects service
                      │
                      ▼
        Service resolves correct model
                      │
                      ▼
          Service performs operation
                      │
                      ▼
          Component handles UI feedback
```

---

**🎨 Visual Guide Complete!**

This visual guide complements the detailed documentation in COMMON_COMPONENTS_README.md.

For code examples and detailed API reference, see the main README.
