<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PPDB extends Model
{
    protected $table = 'ppdb';
    
    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'anak_ke',
        'jumlah_saudara',
        'alamat_siswa',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'alamat_ortu',
        'nomor_telepon',
        'status'
    ];
    
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}