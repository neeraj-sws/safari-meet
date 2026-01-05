<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shared_safaris', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('safari_park_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('no_of_safari');
            $table->unsignedBigInteger('visit_purpose_id');
            $table->unsignedBigInteger('stay_category_id');
            $table->integer('min_price_pp');
            $table->integer('max_price_pp');
            $table->integer('total_seats');
            $table->string('share_seats');
            $table->text('safari_plan');
            $table->string('display_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shared_safaris');
    }
};
