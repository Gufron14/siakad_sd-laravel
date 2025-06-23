<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PPDB extends Model
{
    protected $table = 'ppdb';
    protected $fillable = [
        'nama', 'nisn', 'asal_sekolah', 'nama_ortu', 'alamat', 'status'
    ];
}