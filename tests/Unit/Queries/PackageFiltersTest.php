<?php

namespace Tests\Unit\Queries;

use App\Models\Package;
use App\Models\Park;
use App\Queries\Filters\PackageFilters;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_filter_only_returns_active_packages()
    {
        // Create test packages
        Package::factory()->create(['status' => 1]);
        Package::factory()->create(['status' => 0]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->published()->build()->get();

        $this->assertCount(1, $result);
        $this->assertEquals(1, $result->first()->status);
    }

    public function test_order_by_latest()
    {
        Package::factory()->create(['created_at' => now()->subDays(2)]);
        Package::factory()->create(['created_at' => now()]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->orderBy('latest')->build()->get();

        $this->assertEquals(now()->format('Y-m-d'), $result->first()->created_at->format('Y-m-d'));
    }

    public function test_order_by_popular()
    {
        Package::factory()->create(['popular' => 5]);
        Package::factory()->create(['popular' => 10]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->orderBy('popular')->build()->get();

        $this->assertEquals(10, $result->first()->popular);
    }

    public function test_by_park_filter()
    {
        $park = Park::factory()->create();
        Package::factory()->create(['park_id' => $park->park_id]);
        Package::factory()->create();

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->byPark($park->park_id)->build()->get();

        $this->assertCount(1, $result);
        $this->assertEquals($park->park_id, $result->first()->park_id);
    }

    public function test_by_stay_category()
    {
        Package::factory()->create(['stay_category_id' => 1]);
        Package::factory()->create(['stay_category_id' => 2]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->byStayCategory([1])->build()->get();

        $this->assertCount(1, $result);
        $this->assertEquals(1, $result->first()->stay_category_id);
    }

    public function test_by_stay_category_multiple()
    {
        Package::factory()->create(['stay_category_id' => 1]);
        Package::factory()->create(['stay_category_id' => 2]);
        Package::factory()->create(['stay_category_id' => 3]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->byStayCategory([1, 2])->build()->get();

        $this->assertCount(2, $result);
    }

    public function test_filters_chain()
    {
        $park = Park::factory()->create();
        Package::factory()->create([
            'park_id' => $park->park_id,
            'stay_category_id' => 1,
            'status' => 1,
        ]);
        Package::factory()->create([
            'stay_category_id' => 1,
            'status' => 0,
        ]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        $result = $filters->byPark($park->park_id)
            ->byStayCategory([1])
            ->published()
            ->build()
            ->get();

        $this->assertCount(1, $result);
    }

    public function test_filter_with_null_values()
    {
        Package::factory()->count(3)->create(['status' => 1]);

        $query = Package::query();
        $filters = new PackageFilters($query);

        // Should not break when filters are null
        $result = $filters->byPark(null)
            ->byStayCategory(null)
            ->published()
            ->build()
            ->get();

        $this->assertCount(3, $result);
    }
}
