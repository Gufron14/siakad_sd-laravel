<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['nama', 'guru_id'];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function murid()
    {
        return $this->hasMany(Murid::class, 'kelas_id');
    }

    // Scope untuk mendapatkan kelas berdasarkan tingkat
    public function scopeByTingkat($query, $tingkat)
    {
        return $query->where('nama', $tingkat);
    }

    // Method untuk mendapatkan nama kelas yang sudah ada
    public static function getExistingKelas()
    {
        return self::pluck('nama')->toArray();
    }
}