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
