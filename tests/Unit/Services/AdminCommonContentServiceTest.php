<?php

namespace Tests\Unit\Services;

use App\Models\{
    Feature,
    FeaturePackageSafari,
    FeatureThingsToCarrySafari,
    Faq,
    ItineraryPackage,
    ItineraryPackageActivity,
    Package,
    ParkFaq,
    ShareSafari,
    ThingsToCarry
};
use App\Services\AdminCommonContentService;
use Carbon\Carbon;
use Tests\TestCase;

class AdminCommonContentServiceTest extends TestCase
{
    private AdminCommonContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminCommonContentService();
    }

    /**
     * SHARED MODEL RESOLUTION TESTS
     */

    /** @test */
    public function it_resolves_shared_safari_model_by_type()
    {
        $safari = ShareSafari::factory()->create();

        $result = $this->service->resolveModel(1, $safari->id);

        $this->assertInstanceOf(ShareSafari::class, $result);
        $this->assertEquals($safari->id, $result->id);
    }

    /** @test */
    public function it_resolves_package_model_by_type()
    {
        $package = Package::factory()->create();

        $result = $this->service->resolveModel(2, $package->id);

        $this->assertInstanceOf(Package::class, $result);
        $this->assertEquals($package->id, $result->id);
    }

    /** @test */
    public function it_throws_exception_when_model_not_found()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->service->resolveModel(1, 99999);
    }

    /** @test */
    public function it_returns_correct_column_name_for_shared_safari()
    {
        $columnName = $this->service->getColumnName(1);

        $this->assertEquals('share_safari_id', $columnName);
    }

    /** @test */
    public function it_returns_correct_column_name_for_package()
    {
        $columnName = $this->service->getColumnName(2);

        $this->assertEquals('package_id', $columnName);
    }

    /**
     * THINGS TO CARRY TESTS
     */

    /** @test */
    public function it_retrieves_all_things_to_carry_options()
    {
        ThingsToCarry::factory()->count(3)->create();

        $options = $this->service->getThingsToCarryOptions();

        $this->assertIsArray($options);
        $this->assertGreaterThanOrEqual(3, count($options));
    }

    /** @test */
    public function it_retrieves_things_to_carry_for_shared_safari()
    {
        $safari = ShareSafari::factory()->create();
        FeatureThingsToCarrySafari::factory()
            ->count(2)
            ->create(['share_safari_id' => $safari->id]);

        $items = $this->service->getThingsToCarryList(1, $safari->id);

        $this->assertEquals(2, $items->count());
        $this->assertTrue($items->every(fn($item) => $item->share_safari_id === $safari->id));
    }

    /** @test */
    public function it_retrieves_things_to_carry_for_package()
    {
        $package = Package::factory()->create();
        FeatureThingsToCarrySafari::factory()
            ->count(2)
            ->create(['package_id' => $package->id]);

        $items = $this->service->getThingsToCarryList(2, $package->id);

        $this->assertEquals(2, $items->count());
        $this->assertTrue($items->every(fn($item) => $item->package_id === $package->id));
    }

    /** @test */
    public function it_returns_thing_to_carry_details()
    {
        $item = FeatureThingsToCarrySafari::factory()->create();

        $result = $this->service->getThingToCarryDetails($item->id);

        $this->assertNotNull($result);
        // Note: If ThingsToCarry relationship exists, check it
    }

    /** @test */
    public function it_stores_things_to_carry_for_shared_safari()
    {
        $safari = ShareSafari::factory()->create();
        $items = [
            ['title' => 'Sunscreen', 'description' => 'SPF 50+'],
            ['title' => 'Hat', 'description' => 'Wide-brimmed'],
        ];

        $this->service->storeThingsToCarry(1, $safari->id, $items);

        $stored = FeatureThingsToCarrySafari::where('share_safari_id', $safari->id)->get();
        $this->assertEquals(2, $stored->count());
        $this->assertEquals('Sunscreen', $stored->first()->title);
    }

    /** @test */
    public function it_stores_things_to_carry_for_package()
    {
        $package = Package::factory()->create();
        $items = [
            ['title' => 'Binoculars', 'description' => '10x42 zoom'],
        ];

        $this->service->storeThingsToCarry(2, $package->id, $items);

        $stored = FeatureThingsToCarrySafari::where('package_id', $package->id)->get();
        $this->assertEquals(1, $stored->count());
        $this->assertEquals('Binoculars', $stored->first()->title);
    }

    /** @test */
    public function it_deletes_thing_to_carry()
    {
        $item = FeatureThingsToCarrySafari::factory()->create();

        $result = $this->service->deleteThingToCarry($item->id);

        $this->assertTrue($result);
        $this->assertNull(FeatureThingsToCarrySafari::find($item->id));
    }

    /**
     * FEATURES (INCLUSIONS/EXCLUSIONS) TESTS
     */

    /** @test */
    public function it_retrieves_feature_options_by_type()
    {
        Feature::factory()
            ->count(2)
            ->create(['type' => 1]); // Inclusion
        Feature::factory()
            ->count(1)
            ->create(['type' => 2]); // Exclusion

        $inclusions = $this->service->getFeatureOptions(1);
        $exclusions = $this->service->getFeatureOptions(2);

        $this->assertGreaterThanOrEqual(2, $inclusions->count());
        $this->assertGreaterThanOrEqual(1, $exclusions->count());
    }

    /** @test */
    public function it_retrieves_features_for_shared_safari()
    {
        $safari = ShareSafari::factory()->create();
        FeaturePackageSafari::factory()
            ->count(2)
            ->create(['share_safari_id' => $safari->id, 'type' => 1]);

        $features = $this->service->getFeatures(1, $safari->id, 1);

        $this->assertEquals(2, $features->count());
        $this->assertTrue($features->every(fn($f) => $f->share_safari_id === $safari->id));
    }

    /** @test */
    public function it_retrieves_features_for_package()
    {
        $package = Package::factory()->create();
        FeaturePackageSafari::factory()
            ->count(2)
            ->create(['package_id' => $package->id, 'type' => 2]);

        $features = $this->service->getFeatures(2, $package->id, 2);

        $this->assertEquals(2, $features->count());
        $this->assertTrue($features->every(fn($f) => $f->package_id === $package->id));
    }

    /** @test */
    public function it_returns_feature_details()
    {
        $feature = Feature::factory()->create();

        $result = $this->service->getFeatureDetails($feature->id);

        $this->assertNotNull($result);
        $this->assertEquals($feature->id, $result->id);
    }

    /** @test */
    public function it_stores_features_for_shared_safari()
    {
        $safari = ShareSafari::factory()->create();
        $items = [
            ['icon' => 'water.svg', 'title' => 'Water'],
            ['icon' => 'lunch.svg', 'title' => 'Lunch'],
        ];

        $this->service->storeFeatures(1, $safari->id, 1, $items);

        $stored = FeaturePackageSafari::where('share_safari_id', $safari->id)->get();
        $this->assertEquals(2, $stored->count());
        $this->assertEquals('Water', $stored->first()->title);
    }

    /** @test */
    public function it_stores_features_for_package()
    {
        $package = Package::factory()->create();
        $items = [
            ['icon' => 'alcohol.svg', 'title' => 'Alcohol'],
        ];

        $this->service->storeFeatures(2, $package->id, 2, $items);

        $stored = FeaturePackageSafari::where('package_id', $package->id)->get();
        $this->assertEquals(1, $stored->count());
        $this->assertEquals('Alcohol', $stored->first()->title);
    }

    /** @test */
    public function it_deletes_feature()
    {
        $feature = FeaturePackageSafari::factory()->create();

        $result = $this->service->deleteFeature($feature->id);

        $this->assertTrue($result);
        $this->assertNull(FeaturePackageSafari::find($feature->id));
    }

    /**
     * FAQ TESTS
     */

    /** @test */
    public function it_retrieves_faq_options_by_category()
    {
        Faq::factory()
            ->count(3)
            ->create(['category_id' => 2]);

        $faqs = $this->service->getFaqOptions(2);

        $this->assertGreaterThanOrEqual(3, $faqs->count());
        $this->assertTrue($faqs->every(fn($faq) => $faq->category_id === 2));
    }

    /** @test */
    public function it_retrieves_park_faqs()
    {
        $park = \App\Models\Park::factory()->create();
        ParkFaq::factory()
            ->count(2)
            ->create(['park_id' => $park->id]);

        $faqs = $this->service->getParkFaqs($park->id);

        $this->assertEquals(2, $faqs->count());
        $this->assertTrue($faqs->every(fn($faq) => $faq->park_id === $park->id));
    }

    /** @test */
    public function it_stores_park_faqs()
    {
        $park = \App\Models\Park::factory()->create();
        $questions = [
            ['question' => 'what is the best time to visit?', 'answer' => 'June to October'],
            ['question' => 'is malaria a risk?', 'answer' => 'Yes, take precautions'],
        ];

        $this->service->storeFaqs($park->id, $questions);

        $stored = ParkFaq::where('park_id', $park->id)->get();
        $this->assertEquals(2, $stored->count());
        $this->assertStringStartsWith('What', $stored->first()->question); // Ucwords applied
    }

    /** @test */
    public function it_skips_empty_faq_entries_when_storing()
    {
        $park = \App\Models\Park::factory()->create();
        $questions = [
            ['question' => 'Valid question', 'answer' => 'Valid answer'],
            ['question' => '   ', 'answer' => '   '], // Empty
        ];

        $this->service->storeFaqs($park->id, $questions);

        $stored = ParkFaq::where('park_id', $park->id)->get();
        $this->assertEquals(1, $stored->count());
    }

    /** @test */
    public function it_deletes_park_faq()
    {
        $faq = ParkFaq::factory()->create();

        $result = $this->service->deleteFaq($faq->id);

        $this->assertTrue($result);
        $this->assertNull(ParkFaq::find($faq->id));
    }

    /**
     * ITINERARY TESTS
     */

    /** @test */
    public function it_calculates_itinerary_days_for_shared_safari()
    {
        $safari = ShareSafari::factory()->create([
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays(5),
        ]);

        $days = $this->service->calculateItineraryDays(1, $safari);

        $this->assertEquals(6, $days); // Inclusive of both start and end
    }

    /** @test */
    public function it_calculates_itinerary_days_for_package()
    {
        $package = Package::factory()->create(['start_tour' => 7]);

        $days = $this->service->calculateItineraryDays(2, $package);

        $this->assertEquals(7, $days);
    }

    /** @test */
    public function it_retrieves_itinerary_day_wise_data()
    {
        $safari = ShareSafari::factory()->create();

        // Create itinerary days
        $day1 = ItineraryPackage::factory()->create([
            'share_safari_id' => $safari->id,
            'order_by' => 1,
            'short_description' => 'Day 1: Arrival',
        ]);
        ItineraryPackageActivity::factory()
            ->count(2)
            ->create(['itinerary_packages_id' => $day1->id]);

        $day2 = ItineraryPackage::factory()->create([
            'share_safari_id' => $safari->id,
            'order_by' => 2,
            'short_description' => 'Day 2: Game drive',
        ]);

        $dayWiseData = $this->service->getItineraryDayWiseData(1, $safari->id);

        $this->assertArrayHasKey(1, $dayWiseData);
        $this->assertArrayHasKey(2, $dayWiseData);
        $this->assertEquals('Day 1: Arrival', $dayWiseData[1]['heading']);
        $this->assertCount(2, $dayWiseData[1]['activities']);
    }

    /** @test */
    public function it_retrieves_itinerary_by_specific_day()
    {
        $package = Package::factory()->create();
        $itinerary = ItineraryPackage::factory()->create([
            'package_id' => $package->id,
            'order_by' => 3,
        ]);

        $result = $this->service->getItineraryByDay(2, $package->id, 3);

        $this->assertNotNull($result);
        $this->assertEquals($itinerary->id, $result->id);
        $this->assertEquals(3, $result->order_by);
    }

    /** @test */
    public function it_returns_null_for_non_existent_itinerary_day()
    {
        $package = Package::factory()->create();

        $result = $this->service->getItineraryByDay(2, $package->id, 99);

        $this->assertNull($result);
    }

    /** @test */
    public function it_creates_new_itinerary()
    {
        $safari = ShareSafari::factory()->create();
        $activities = ['Morning game drive', 'Lunch at lodge', 'Afternoon safari'];

        $itinerary = $this->service->storeItinerary(
            1,
            $safari->id,
            1,
            'Arrival and Orientation',
            $activities
        );

        $this->assertNotNull($itinerary->id);
        $this->assertEquals(1, $itinerary->order_by);
        $this->assertEquals('Arrival and Orientation', $itinerary->short_description);

        $stored_activities = ItineraryPackageActivity::where('itinerary_packages_id', $itinerary->id)->get();
        $this->assertEquals(3, $stored_activities->count());
    }

    /** @test */
    public function it_updates_existing_itinerary()
    {
        $itinerary = ItineraryPackage::factory()->create([
            'short_description' => 'Old heading',
        ]);
        ItineraryPackageActivity::factory()
            ->count(2)
            ->create(['itinerary_packages_id' => $itinerary->id]);

        $newActivities = ['New activity 1', 'New activity 2', 'New activity 3'];
        $updated = $this->service->storeItinerary(
            1,
            $itinerary->share_safari_id,
            1,
            'New heading',
            $newActivities,
            $itinerary->id
        );

        $this->assertEquals('New heading', $updated->short_description);

        $activities = ItineraryPackageActivity::where('itinerary_packages_id', $itinerary->id)->get();
        $this->assertEquals(3, $activities->count()); // Old ones deleted, new ones created
    }

    /** @test */
    public function it_skips_empty_activities_when_storing_itinerary()
    {
        $package = Package::factory()->create();
        $activities = ['Valid activity', '   ', 'Another valid'];

        $itinerary = $this->service->storeItinerary(
            2,
            $package->id,
            1,
            'Day 1',
            $activities
        );

        $stored_activities = ItineraryPackageActivity::where('itinerary_packages_id', $itinerary->id)->get();
        $this->assertEquals(2, $stored_activities->count()); // Empty one skipped
    }

    /** @test */
    public function it_deletes_itinerary_with_activities()
    {
        $itinerary = ItineraryPackage::factory()->create();
        ItineraryPackageActivity::factory()
            ->count(3)
            ->create(['itinerary_packages_id' => $itinerary->id]);

        $id = $itinerary->id;
        $result = $this->service->deleteItinerary($id);

        $this->assertTrue($result);
        $this->assertNull(ItineraryPackage::find($id));
        $this->assertEquals(0, ItineraryPackageActivity::where('itinerary_packages_id', $id)->count());
    }

    /** @test */
    public function it_returns_false_when_deleting_non_existent_itinerary()
    {
        $result = $this->service->deleteItinerary(99999);

        $this->assertFalse($result);
    }
}
