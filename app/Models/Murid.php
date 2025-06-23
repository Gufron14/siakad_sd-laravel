<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';
    protected $fillable = ['nama', 'kelas_id', 'orangtua_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function orangtua()
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'murid_id');
    }

    /**
     * Get nilai untuk mata pelajaran, semester, dan tahun tertentu
     */
    public function getNilai($mataPelajaranId, $semester, $tahun)
    {
        return $this->nilai()
            ->where('mata_pelajaran_id', $mataPelajaranId)
            ->where('semester', $semester)
            ->where('tahun', $tahun)
            ->first();
    }
}
