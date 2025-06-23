<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = ['murid_id', 'kelas_id', 'guru_id', 'tanggal', 'status'];

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}