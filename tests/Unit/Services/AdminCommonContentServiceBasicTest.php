<?php

namespace Tests\Unit\Services;

use App\Services\AdminCommonContentService;
use PHPUnit\Framework\TestCase;

class AdminCommonContentServiceBasicTest extends TestCase
{
    private AdminCommonContentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AdminCommonContentService();
    }

    /** @test */
    public function service_can_be_instantiated()
    {
        $this->assertInstanceOf(AdminCommonContentService::class, $this->service);
    }

    /** @test */
    public function it_returns_correct_column_name_for_type_1()
    {
        $result = $this->service->getColumnName(1);
        $this->assertEquals('share_safari_id', $result);
    }

    /** @test */
    public function it_returns_correct_column_name_for_type_2()
    {
        $result = $this->service->getColumnName(2);
        $this->assertEquals('package_id', $result);
    }

    /** @test */
    public function calculate_itinerary_days_handles_package_type()
    {
        // Create a mock package
        $mockPackage = (object)['start_tour' => 5];

        $days = $this->service->calculateItineraryDays(2, $mockPackage);

        $this->assertEquals(5, $days);
    }
}

