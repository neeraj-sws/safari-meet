<?php

namespace Tests\Feature;

use App\Models\Park;
use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test for Top Rated Parks API
 *
 * Following SOLID principles in testing:
 * - Each test has a single responsibility
 * - Tests are isolated and independent
 */
class TopRatedParksApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that top rated parks endpoint returns successful response
     */
    public function test_can_get_top_rated_parks(): void
    {
        // Arrange: Create a top rated park
        $country = Country::factory()->create(['name' => 'India']);
        $state = State::factory()->create(['name' => 'Madhya Pradesh', 'country_id' => $country->country_id]);
        $city = City::factory()->create(['name' => 'Sawai Madhopur', 'state_id' => $state->state_id]);

        $park = Park::create([
            'name' => 'Ranthambhore National Park',
            'slug' => 'ranthambhore-national-park',
            'short_description' => 'Famous tiger reserve',
            'city_id' => $city->city_id,
            'state_id' => $state->state_id,
            'country_id' => $country->country_id,
            'display_image' => 'uploads/parks/ranthambhore.jpg',
            'famous_for' => 'Tiger sightings',
            'banner_title' => 'Experience Wildlife',
            'status' => true,
            'top_rated' => true,
        ]);

        // Act: Call the API endpoint
        $response = $this->getJson('/api/public/top-rated-parks');

        // Assert: Check response structure and data
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'park_id',
                            'name',
                            'slug',
                            'short_description',
                            'famous_for',
                            'banner_title',
                            'display_image',
                            'country',
                            'state',
                            'city',
                        ]
                    ],
                    'total',
                    'per_page',
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Top rated parks retrieved successfully',
            ]);

        // Verify the park is in the response
        $this->assertEquals('Ranthambhore National Park', $response->json('data.data.0.name'));
    }

    /**
     * Test that only top rated parks are returned
     */
    public function test_only_returns_top_rated_parks(): void
    {
        // Create one top rated and one regular park
        Park::factory()->create(['top_rated' => true, 'status' => true, 'name' => 'Top Rated Park']);
        Park::factory()->create(['top_rated' => false, 'status' => true, 'name' => 'Regular Park']);

        $response = $this->getJson('/api/public/top-rated-parks');

        $response->assertStatus(200);

        $parks = $response->json('data.data');

        // Should only have 1 park (the top rated one)
        $this->assertCount(1, $parks);
        $this->assertEquals('Top Rated Park', $parks[0]['name']);
    }

    /**
     * Test that inactive parks are not returned
     */
    public function test_does_not_return_inactive_parks(): void
    {
        // Create top rated but inactive park
        Park::factory()->create(['top_rated' => true, 'status' => false]);

        $response = $this->getJson('/api/public/top-rated-parks');

        $response->assertStatus(200);

        $parks = $response->json('data.data');

        // Should return empty array
        $this->assertCount(0, $parks);
    }

    /**
     * Test pagination works correctly
     */
    public function test_pagination_works(): void
    {
        // Create 15 top rated parks
        Park::factory()->count(15)->create(['top_rated' => true, 'status' => true]);

        // Request 5 per page
        $response = $this->getJson('/api/public/top-rated-parks?per_page=5');

        $response->assertStatus(200)
            ->assertJsonPath('data.per_page', 5)
            ->assertJsonPath('data.total', 15);

        $this->assertCount(5, $response->json('data.data'));
    }

    /**
     * Test per_page validation
     */
    public function test_validates_per_page_parameter(): void
    {
        // Test with invalid per_page (too large)
        $response = $this->getJson('/api/public/top-rated-parks?per_page=150');

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid per_page parameter',
            ]);

        // Test with invalid per_page (not a number)
        $response = $this->getJson('/api/public/top-rated-parks?per_page=abc');

        $response->assertStatus(422);
    }

    /**
     * Test image URL is properly formatted
     */
    public function test_image_url_includes_base_url(): void
    {
        $park = Park::factory()->create([
            'top_rated' => true,
            'status' => true,
            'display_image' => 'uploads/parks/test.jpg'
        ]);

        $response = $this->getJson('/api/public/top-rated-parks');

        $imageUrl = $response->json('data.data.0.display_image');

        // Should include the base URL
        $this->assertStringContainsString(env('APP_URL'), $imageUrl);
        $this->assertStringContainsString('uploads/parks/test.jpg', $imageUrl);
    }
}
