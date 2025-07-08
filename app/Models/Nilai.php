<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $fillable = [
        'mata_pelajaran_id', 
        'guru_id', 
        'semester', 
        'tahun',
        'murid_nilai'
    ];

    protected $casts = [
        'murid_nilai' => 'array', // Cast JSON to array
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Get nilai untuk murid tertentu
     */
    public function getNilaiMurid($muridId)
    {
        return $this->murid_nilai[$muridId] ?? null;
    }

    /**
     * Set nilai untuk murid tertentu
     */
    public function setNilaiMurid($muridId, $nilai)
    {
        $muridNilai = $this->murid_nilai ?? [];
        $muridNilai[$muridId] = $nilai;
        $this->murid_nilai = $muridNilai;
    }

    /**
     * Static method untuk save/update nilai
     */
    public static function saveNilai($mataPelajaranId, $guruId, $semester, $tahun, $muridNilaiData)
    {
        return static::updateOrCreate(
            [
                'mata_pelajaran_id' => $mataPelajaranId,
                'semester' => $semester,
                'tahun' => $tahun,
            ],
            [
                'guru_id' => $guruId,
                'murid_nilai' => $muridNilaiData, // JSON: {murid_id: nilai}
            ]
        );
    }
}
