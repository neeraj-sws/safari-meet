<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add Safari Creation notification template
        DB::table('notification_templates')->insert([
            'template_code' => 'SAFARI_CREATED',
            'name' => 'Safari Creation Completed',
            'subject' => 'New Safari Created: {{safari_title}}',
            'body' => '
                <h2>New Safari Created</h2>
                <p>A new Safari has been created and needs your review.</p>
                <hr>
                <p><strong>Safari Title:</strong> {{safari_title}}</p>
                <p><strong>Park:</strong> {{park_name}}</p>
                <p><strong>Price Range:</strong> ₹{{min_price}} - ₹{{max_price}}</p>
                <p><strong>Duration:</strong> {{days}} Days, {{nights}} Nights</p>
                <p><strong>Created At:</strong> {{created_at}}</p>
                <p><strong>Status:</strong> Awaiting Admin Approval</p>
                <hr>
                <p>Please review and approve this safari in the admin panel.</p>
                <p>&copy; {{year}} SafariMeet. All rights reserved.</p>
            ',
            'short_codes' => '{{safari_title}},{{park_name}},{{min_price}},{{max_price}},{{days}},{{nights}},{{created_at}},{{year}}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add Package Creation notification template
        DB::table('notification_templates')->insert([
            'template_code' => 'PACKAGE_CREATED',
            'name' => 'Package Creation Completed',
            'subject' => 'New Package Created: {{package_title}}',
            'body' => '
                <h2>New Package Created</h2>
                <p>A new Package has been created and needs your review.</p>
                <hr>
                <p><strong>Package Title:</strong> {{package_title}}</p>
                <p><strong>Park:</strong> {{park_name}}</p>
                <p><strong>Price Range:</strong> ₹{{min_price}} - ₹{{max_price}}</p>
                <p><strong>Created At:</strong> {{created_at}}</p>
                <p><strong>Status:</strong> Awaiting Admin Approval</p>
                <hr>
                <p>Please review and approve this package in the admin panel.</p>
                <p>&copy; {{year}} SafariMeet. All rights reserved.</p>
            ',
            'short_codes' => '{{package_title}},{{park_name}},{{min_price}},{{max_price}},{{created_at}},{{year}}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('notification_templates')
            ->whereIn('template_code', ['SAFARI_CREATED', 'PACKAGE_CREATED'])
            ->delete();
    }
};
