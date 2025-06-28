<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $fillable = ['nama', 'kelas_id'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'mata_pelajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Hitung rata-rata kelas untuk mata pelajaran ini
     */
    public function getRataRataKelas($kelasId, $semester, $tahun)
    {
        return $this->nilai()
            ->whereHas('murid', function($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->where('semester', $semester)
            ->where('tahun', $tahun)
            ->whereNotNull('uts')
            ->whereNotNull('uas')
            ->get()
            ->map(function($nilai) {
                return ($nilai->uts + $nilai->uas) / 2;
            })
            ->avg();
    }
}