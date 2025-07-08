<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mata_pelajaran_id');
            $table->unsignedBigInteger('guru_id');
            $table->string('semester');
            $table->string('tahun');
            $table->json('murid_nilai'); // {murid_id: uas_score}
            $table->timestamps();

            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajaran')->onDelete('cascade');
            $table->foreign('guru_id')->references('id')->on('users')->onDelete('cascade');
            
            // Index untuk query yang lebih cepat
            $table->index(['mata_pelajaran_id', 'semester', 'tahun']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('nilai');
    }
};