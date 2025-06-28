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
        Schema::table('absensi', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['murid_id']);
            
            // Change murid_id to JSON and add semester
            $table->json('murid_data')->after('murid_id'); // {murid_id: status}
            $table->string('semester')->after('tanggal');
            
            // Drop the old murid_id and status columns
            $table->dropColumn(['murid_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            // Restore original structure
            $table->unsignedBigInteger('murid_id')->after('id');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa'])->after('tanggal');
            
            // Drop new columns
            $table->dropColumn(['murid_data', 'semester']);
            
            // Restore foreign key
            $table->foreign('murid_id')->references('id')->on('murid')->onDelete('cascade');
        });
    }
};
