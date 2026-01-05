<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('packages')) {
            return;
        }

        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('package_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->unsignedBigInteger('park_id')->nullable();
            $table->decimal('min_price_pp', 10, 2)->nullable();
            $table->decimal('max_price_pp', 10, 2)->nullable();
            $table->string('display_image')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('no_of_safari')->nullable();
            $table->tinyInteger('popular')->default(0);
            $table->tinyInteger('trending')->default(0);
            $table->tinyInteger('top_rated')->default(0);
            $table->uuid('uuid')->nullable();
            $table->timestamps();

            $table->foreign('park_id')->references('park_id')->on('parks')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
