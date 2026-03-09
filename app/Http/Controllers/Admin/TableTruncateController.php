<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class TableTruncateController extends Controller
{
    private const ALLOWED_TABLES = [
        'accommodations',
        'accommodation_amenities',
        'accommodation_images',
        'activity_logs',
        'album_categories',
        'album_images',
        'album_tag',
        'appearance',
        'comman_park_rules',
        'conservation',
        'conservation_details',
        'contact_us_forms',
        'coupons',
        'enquiries',
        'enquiries_accommodations',
        'facts',
        'failed_jobs',
        'follows',
        'jobs',
        'job_batches',
        'join_shared_safaris',
        'media_posts',
        'notifications',
        'packages',
        'package_banners',
        'package_details_tabs',
        'parks',
        'park_about_section',
        'park_accommodations',
        'park_best_time',
        'park_best_time_visit',
        'park_details',
        'park_details_dynamic_tabs',
        'park_details_tabs',
        'park_faqs',
        'park_information',
        'park_key_info',
        'park_reachabilities',
        'park_reachabilities_distance',
        'park_rules',
        'park_safari_time',
        'park_safari_time_details',
        'park_safari_type',
        'park_species',
        'park_travel_tips',
        'park_what_to_carry',
        'park_wildlife_found',
        'park_zone',
        'payments',
        'post_comments',
        'post_likes',
        'reports',
        'safaries_types',
        'safari_accommodations',
        'safari_allotted_seats',
        'safari_conversations',
        'safari_conversation_messages',
        'safari_details_dynamic_tabs',
        'safari_discussion',
        'safari_enquiries',
        'safari_inclusion_exclusions',
        'safari_itineraries',
        'safari_itinerary_activities',
        'safari_ratings',
        'safari_rating_heading',
        'safari_things_to_carries',
        'shared_safaris',
        'shared_safari_details_tabs',
        'species',
        'species_adaptations',
        'species_details_characterstics',
        'species_details_dynamic_tabs',
        'species_dietes',
        'species_interesting_facts',
        'species_lifestyle',
        'species_overview',
        'species_physical_appereances',
        'species_threats',
        'users',
        'wishlists',
    ];

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'table' => ['nullable', 'string', Rule::in(self::ALLOWED_TABLES)],
            'all' => ['nullable', 'boolean'],
        ]);

        $truncateAll = (bool) ($validated['all'] ?? false) || empty($validated['table']);

        if ($truncateAll) {
            return $this->truncateAllAllowedTables();
        }

        return $this->truncateSingleTable($validated['table']);
    }

    public function truncateAllAllowedTables(): JsonResponse
    {
        $existingTables = array_values(array_filter(self::ALLOWED_TABLES, fn ($table) => Schema::hasTable($table)));
        $missingTables = array_values(array_diff(self::ALLOWED_TABLES, $existingTables));

        Schema::disableForeignKeyConstraints();

        try {
            foreach ($existingTables as $table) {
                DB::table($table)->truncate();
            }
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        return response()->json([
            'message' => 'Allowed tables truncated successfully.',
            'mode' => 'all',
            'truncated_tables' => $existingTables,
            'missing_tables' => $missingTables,
            'truncated_count' => count($existingTables),
        ]);
    }

    private function truncateSingleTable(string $table): JsonResponse
    {
        if (!Schema::hasTable($table)) {
            return response()->json([
                'message' => "Table '{$table}' does not exist in this database.",
            ], 422);
        }

        Schema::disableForeignKeyConstraints();

        try {
            DB::table($table)->truncate();
        } finally {
            Schema::enableForeignKeyConstraints();
        }

        return response()->json([
            'message' => "Table '{$table}' truncated successfully.",
            'mode' => 'single',
            'table' => $table,
        ]);
    }
}

