<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->bigIncrements('notification_templates_id');
            $table->string('template_code')->unique();
            $table->string('name')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->text('short_codes')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        // Seed a minimal template used by auth flows
        DB::table('notification_templates')->insert([
            'template_code' => 'AGENTEMAILVERIFY',
            'name' => 'Agent Email Verification',
            'subject' => 'Verify your email, {{username}}',
            'body' => 'Your verification code is {{otp}}.',
            'short_codes' => '{{username}},{{otp}}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::create('species', function (Blueprint $table) {
            $table->bigIncrements('species_id');
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('display_image')->nullable();
            $table->string('slug')->nullable();
            $table->uuid('uuid')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_key')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('top_species')->default(0);
            $table->string('meta_image')->nullable();
            $table->timestamps();
        });

        Schema::create('park_wildlife_found', function (Blueprint $table) {
            $table->bigIncrements('park_wildlife_found_id');
            $table->unsignedBigInteger('park_id')->nullable();
            $table->unsignedBigInteger('species_id')->nullable();
            $table->timestamps();
        });

        Schema::create('package_details_tabs', function (Blueprint $table) {
            $table->bigIncrements('package_details_tabs_id');
            $table->unsignedBigInteger('package_tabs_id')->nullable();
            $table->unsignedBigInteger('package_id')->nullable();
            $table->string('title')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('safari_inclusion_exclusions', function (Blueprint $table) {
            $table->bigIncrements('safari_inclusion_exclusions_id');
            $table->unsignedBigInteger('package_id')->nullable();
            $table->unsignedBigInteger('share_safari_id')->nullable();
            $table->tinyInteger('type')->default(1);
            $table->string('icon')->nullable();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('feature_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('safari_inclusion_exclusions');
        Schema::dropIfExists('package_details_tabs');
        Schema::dropIfExists('park_wildlife_found');
        Schema::dropIfExists('species');
        Schema::dropIfExists('notification_templates');
    }
};
