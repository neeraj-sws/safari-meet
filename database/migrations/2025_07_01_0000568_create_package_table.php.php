<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('package_id');
            $table->unsignedBigInteger('upload_id')->nullable();
            $table->string('title', 255)->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('park_id')->nullable();
            $table->unsignedBigInteger('visit_purpose_id')->nullable();
            $table->unsignedBigInteger('stay_category_id')->nullable();
            $table->integer('min_price_pp')->nullable();
            $table->integer('max_price_pp')->nullable();
            $table->string('display_image', 255)->nullable();
            $table->integer('no_of_safari')->nullable();
            $table->integer('start_tour')->nullable();
            $table->integer('end_tour')->nullable();
            $table->text('tour_highlights')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('popular')->default(0);
            $table->tinyInteger('trending')->default(0);
            $table->tinyInteger('top_rated')->default(0);
            $table->tinyInteger('type')->default(1);
            $table->unsignedBigInteger('organized_by')->nullable();
            $table->string('best_time')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('browser')->nullable();
            $table->string('os')->nullable();
            $table->string('device')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->uuid('uuid')->nullable();
            $table->timestamps();

            $table->index('park_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
}
