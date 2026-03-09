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
<<<<<<< HEAD
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
=======
            $table->id(); // bigint(20) unsigned, auto_increment
            $table->unsignedBigInteger('upload_id')->nullable();
            $table->string('title', 255);
            $table->unsignedBigInteger('safari_park_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('no_of_safari');
            $table->unsignedBigInteger('visit_purpose_id');
            $table->unsignedBigInteger('stay_category_id');
            $table->integer('min_price_pp');
            $table->integer('max_price_pp');
            $table->integer('total_seats');
            $table->string('share_seats', 255);
            $table->text('safari_plan');
            $table->string('display_image', 255);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
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
