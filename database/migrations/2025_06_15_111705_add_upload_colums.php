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
        Schema::table('albums', function (Blueprint $table) {

            $table->unsignedBigInteger('upload_id')->nullable()->after('id');
            $table->foreign('upload_id')
                ->references('id')
                ->on('uploads')
                ->nullOnDelete();
        });
        Schema::table('album_images', function (Blueprint $table) {

            $table->unsignedBigInteger('upload_id')->nullable()->after('id');
            $table->foreign('upload_id')
                ->references('id')
                ->on('uploads')
                ->nullOnDelete();
        });
        Schema::table('shared_safaris', function (Blueprint $table) {

            $table->unsignedBigInteger('upload_id')->nullable()->after('id');
            $table->foreign('upload_id')
                ->references('id')
                ->on('uploads')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropForeign(['upload_id']);
            $table->dropColumn(['upload_id']);
        });
        Schema::table('album_images', function (Blueprint $table) {
            $table->dropForeign(['upload_id']);
            $table->dropColumn(['upload_id']);
        });
        Schema::table('shared_safaris', function (Blueprint $table) {
            $table->dropForeign(['upload_id']);
            $table->dropColumn(['upload_id']);
        });
    }
};
