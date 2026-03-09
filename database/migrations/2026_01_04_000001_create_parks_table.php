<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('parks')) {
            return;
        }

        Schema::create('parks', function (Blueprint $table) {
            $table->bigIncrements('park_id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('short_description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('display_image')->nullable();
            $table->uuid('uuid')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('parks');
    }
};
