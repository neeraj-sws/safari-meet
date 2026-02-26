# Top Rated Parks API - SOLID Principles Implementation

## Overview
This API endpoint provides access to top-rated parks with comprehensive data including location, safari types, best visiting times, and wildlife species.

**Endpoint:** `GET /api/public/top-rated-parks`

## SOLID Principles Applied

### 1. **Single Responsibility Principle (SRP)**
Each class has ONE clear responsibility:

- **ParkRepository**: Only handles database queries and data retrieval
- **ParkService**: Only handles business logic and data transformation
- **TopRatedParksController**: Only handles HTTP requests/responses
- **TopRatedParkResource**: Only handles response formatting

### 2. **Open/Closed Principle (OCP)**
- Service and Repository are open for extension but closed for modification
- Can add new methods without changing existing code
- Easy to add new park filtering or sorting logic

### 3. **Liskov Substitution Principle (LSP)**
- ParkRepository implements ParkRepositoryInterface
- Can be replaced with any implementation of the interface
- Mock implementations can be used for testing

### 4. **Interface Segregation Principle (ISP)**
- ParkRepositoryInterface contains only methods needed for park operations
- No forced implementation of unused methods
- Clean, focused interface

### 5. **Dependency Inversion Principle (DIP)**
- Controller depends on ParkService (abstraction)
- Service depends on ParkRepositoryInterface (abstraction)
- All dependencies are injected, not created
- Loosely coupled, highly testable code

## Architecture

```
Request → Controller → Service → Repository → Model → Database
                ↓
            Response
```

## File Structure

```
app/
├── Contracts/
│   └── Repositories/
│       └── ParkRepositoryInterface.php      # Interface defining repository contract
├── Repositories/
│   └── ParkRepository.php                   # Data access layer (queries)
├── Services/
│   └── ParkService.php                      # Business logic layer
├── Http/
│   ├── Controllers/Api/Common/Public/
│   │   └── TopRatedParksController.php      # HTTP request handler
│   └── Resources/
│       └── TopRatedParkResource.php         # Response formatter
└── Providers/
    └── AppServiceProvider.php               # Dependency injection bindings

routes/
└── api.php                                  # API route registration
```

## API Documentation

### Request

**Method:** GET  
**URL:** `/api/public/top-rated-parks`

**Query Parameters:**
- `per_page` (optional): Number of items per page (1-100, default: 10)

**Example:**
```bash
GET /api/public/top-rated-parks?per_page=15
```

### Response

**Success (200):**
```json
{
  "success": true,
  "message": "Top rated parks retrieved successfully",
  "data": {
    "current_page": 1,
    "data": [
      {
        "park_id": 1,
        "name": "Jim Corbett National Park",
        "slug": "jim-corbett-national-park",
        "short_description": "India's oldest national park...",
        "famous_for": "Tiger Reserve",
        "banner_title": "Experience Wildlife",
        "display_image": "https://yourdomain.com/uploads/parks/corbett.jpg",
        "country": {
          "country_id": 1,
          "name": "India"
        },
        "state": {
          "state_id": 5,
          "name": "Uttarakhand"
        },
        "city": {
          "city_id": 10,
          "name": "Ramnagar"
        },
        "park_safari_types": [
          {
            "id": 1,
            "type": "Jeep Safari"
          },
          {
            "id": 2,
            "type": "Canter Safari"
          }
        ],
        "park_best_times": [
          {
            "id": 1,
            "weather": "Winter"
          },
          {
            "id": 2,
            "weather": "Summer"
          }
        ],
        "species_list": [
          {
            "id": 1,
            "name": "Bengal Tiger"
          },
          {
            "id": 5,
            "name": "Asian Elephant"
          }
        ],
        "meta_title": "Jim Corbett National Park - Best Tiger Reserve",
        "meta_description": "Visit India's oldest national park...",
        "top_rated": true
      }
    ],
    "first_page_url": "http://yourdomain.com/api/public/top-rated-parks?page=1",
    "from": 1,
    "last_page": 3,
    "last_page_url": "http://yourdomain.com/api/public/top-rated-parks?page=3",
    "next_page_url": "http://yourdomain.com/api/public/top-rated-parks?page=2",
    "path": "http://yourdomain.com/api/public/top-rated-parks",
    "per_page": 10,
    "prev_page_url": null,
    "to": 10,
    "total": 25
  },
  "errors": null
}
```

**Error (422 - Validation Error):**
```json
{
  "success": false,
  "message": "Invalid per_page parameter",
  "data": null,
  "errors": {
    "per_page": [
      "Must be a number between 1 and 100"
    ]
  }
}
```

**Error (500 - Server Error):**
```json
{
  "success": false,
  "message": "Failed to retrieve top rated parks",
  "data": null,
  "errors": {
    "error": "Error message details"
  }
}
```

## Benefits of This Architecture

### 1. **Testability**
- Each layer can be tested independently
- Easy to mock dependencies
- Clear boundaries between components

### 2. **Maintainability**
- Changes in one layer don't affect others
- Easy to locate and fix bugs
- Clear code organization

### 3. **Scalability**
- Easy to add new features
- Can swap implementations (e.g., different database, caching)
- Minimal code changes needed for extensions

### 4. **Reusability**
- Repository can be used by multiple services
- Service can be used by multiple controllers
- Resources can be reused across different endpoints

## Testing Examples

### Unit Test for Repository
```php
public function test_get_top_rated_parks()
{
    $park = Park::factory()->create(['top_rated' => true, 'status' => true]);
    
    $repository = new ParkRepository(new Park());
    $result = $repository->getTopRatedParks(10);
    
    $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    $this->assertTrue($result->contains($park));
}
```

### Unit Test for Service
```php
public function test_service_transforms_park_data()
{
    $mockRepo = Mockery::mock(ParkRepositoryInterface::class);
    // ... mock setup
    
    $service = new ParkService($mockRepo);
    $result = $service->getTopRatedParks(10);
    
    // Assert transformations
}
```

### Integration Test for API
```php
public function test_top_rated_parks_endpoint()
{
    $park = Park::factory()->create(['top_rated' => true, 'status' => true]);
    
    $response = $this->getJson('/api/public/top-rated-parks');
    
    $response->assertStatus(200)
             ->assertJsonStructure([
                 'success',
                 'message',
                 'data' => [
                     'data' => [
                         '*' => [
                             'park_id',
                             'name',
                             'slug',
                             // ... other fields
                         ]
                     ]
                 ]
             ]);
}
```

## Extension Examples

### Adding Caching
```php
// In ParkService
public function getTopRatedParks(int $perPage = 10): LengthAwarePaginator
{
    $cacheKey = "top_rated_parks_{$perPage}_" . request()->get('page', 1);
    
    return Cache::remember($cacheKey, 3600, function() use ($perPage) {
        $parks = $this->parkRepository->getTopRatedParks($perPage);
        // ... transformation logic
        return $parks;
    });
}
```

### Adding Sorting
```php
// In ParkRepository
public function getTopRatedParks(int $perPage = 10, string $sortBy = 'created_at'): LengthAwarePaginator
{
    return $this->model
        ->where('status', true)
        ->where('top_rated', true)
        ->orderBy($sortBy, 'DESC')
        ->paginate($perPage);
}
```

## Related Endpoints

- `GET /api/public/park` - Get all parks with filters
- `GET /api/public/park/details/{slug}` - Get specific park details
- `GET /api/public/park/search` - Search parks

## Notes

- All parks must have `status = true` and `top_rated = true` to appear in results
- Images URLs are automatically prefixed with APP_URL
- Response is paginated for performance
- All relationships are eager loaded to prevent N+1 queries
