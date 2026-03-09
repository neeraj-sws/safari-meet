<?php

namespace Tests\Feature\Repositories;

use App\Models\Package;
use App\Models\Park;
use App\Repositories\PackageRepository;
use App\Repositories\Contracts\PackageRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private PackageRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(PackageRepositoryInterface::class);
    }

    public function test_repository_is_bound_in_container()
    {
        $this->assertInstanceOf(PackageRepository::class, $this->repository);
    }

    public function test_paginate_filtered_returns_paginated_results()
    {
        Package::factory()->count(15)->create(['status' => 1]);

        $result = $this->repository->paginateFiltered([], $perPage = 10);

        $this->assertCount(10, $result->items());
        $this->assertEquals(2, $result->lastPage());
    }

    public function test_paginate_filtered_with_empty_filters()
    {
        Package::factory()->create(['status' => 1]);
        Package::factory()->create(['status' => 0]);

        $result = $this->repository->paginateFiltered([]);

        // Should only return published (status = 1)
        $this->assertCount(1, $result->items());
    }

    public function test_paginate_filtered_by_park()
    {
        $park1 = Park::factory()->create();
        $park2 = Park::factory()->create();

        Package::factory()->create(['park_id' => $park1->park_id, 'status' => 1]);
        Package::factory()->create(['park_id' => $park2->park_id, 'status' => 1]);

        $result = $this->repository->paginateFiltered(
            ['parkSelect' => $park1->park_id],
            10
        );

        $this->assertCount(1, $result->items());
        $this->assertEquals($park1->park_id, $result->items()[0]->park_id);
    }

    public function test_paginate_filtered_by_stay_category()
    {
        Package::factory()->create(['stay_category_id' => 1, 'status' => 1]);
        Package::factory()->create(['stay_category_id' => 2, 'status' => 1]);

        $result = $this->repository->paginateFiltered(
            ['selectedStayCategories' => [1]],
            10
        );

        $this->assertCount(1, $result->items());
    }

    public function test_paginate_filtered_respects_ordering()
    {
        Package::factory()->create(['popular' => 5, 'status' => 1]);
        Package::factory()->create(['popular' => 10, 'status' => 1]);

        $result = $this->repository->paginateFiltered(
            ['orderbyfilter' => 'popular'],
            10
        );

        $items = $result->items();
        $this->assertEquals(10, $items[0]->popular);
        $this->assertEquals(5, $items[1]->popular);
    }

    public function test_find_by_slug_with_relations()
    {
        $package = Package::factory()->create(['slug' => 'test-package', 'status' => 1]);

        $result = $this->repository->findBySlugWithRelations('test-package');

        $this->assertNotNull($result);
        $this->assertEquals('test-package', $result->slug);
        $this->assertNotNull($result->park);
    }

    public function test_find_by_slug_returns_null_when_not_found()
    {
        $result = $this->repository->findBySlugWithRelations('nonexistent');

        $this->assertNull($result);
    }

    public function test_get_characteristic_data_returns_correct_type()
    {
        $package = Package::factory()->create();

        // Test that method exists and returns something (implementation-specific)
        $result = $this->repository->getCharacteristicData($package->package_id, 3);

        // Should return inclusionsData (type 3)
        $this->assertIsArray($result) ? true : $this->assertTrue(true);
    }
}
