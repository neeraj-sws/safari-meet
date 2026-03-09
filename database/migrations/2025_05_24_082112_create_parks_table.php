<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parks', function (Blueprint $table) {
<<<<<<< HEAD
            $table->bigIncrements('park_id');
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->integer('wildlife_found')->nullable();
            $table->string('closed_months')->nullable();
            $table->string('area')->nullable();
            $table->string('established')->nullable();
            $table->string('famous_for')->nullable();
            $table->string('core_zone_price')->nullable();
            $table->string('buffer_zone_price')->nullable();
            $table->string('core_zone')->nullable();
            $table->string('buffer_zone')->nullable();
            $table->string('entry_gates')->nullable();
            $table->string('nearest_railway')->nullable();
            $table->string('morning_time')->nullable();
            $table->string('afternoon_time')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('display_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('banner_title')->nullable();
            $table->tinyInteger('top_rated')->default(0);
            $table->tinyInteger('popular')->default(0);
            $table->tinyInteger('trending')->default(0);
            $table->tinyInteger('top_safari')->default(0);
            $table->string('meta_image')->nullable();
            $table->uuid('uuid')->nullable();
=======
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('state_id');
            $table->integer('country_id');
            $table->text('train')->comment('nearest train station')->nullable();
            $table->text('airport')->comment('nearest airport')->nullable();
            $table->text('safari_session')->nullable();
            $table->integer('wildlife_found')->nullable();
            $table->string('safari_cost')->nullable();
            $table->string('safari_mode')->nullable();
            $table->string('closed_months')->nullable();
>>>>>>> 89a5c42040adfeb70ab0b1e6118742b9b6d90d5b
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parks');
    }
};
