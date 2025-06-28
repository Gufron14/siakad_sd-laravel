<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = ['murid_data', 'kelas_id', 'guru_id', 'tanggal', 'semester'];

    protected $casts = [
        'murid_data' => 'array', // Cast JSON to array
        'tanggal' => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Get murids from the JSON data with their status
     * Returns: [['murid_id' => 1, 'status' => 'hadir', 'nama' => 'John'], ...]
     */
    public function getMuridsWithStatusAttribute()
    {
        if (!$this->murid_data) {
            return collect();
        }

        return collect($this->murid_data)->map(function ($status, $muridId) {
            $murid = Murid::find($muridId);
            return [
                'murid_id' => $muridId,
                'status' => $status,
                'nama' => $murid ? $murid->nama : 'Unknown',
                'murid' => $murid
            ];
        });
    }

    /**
     * Static method to create or update absensi for a class
     */
    public static function saveClassAttendance($kelasId, $guruId, $tanggal, $semester, $absensiData)
    {
        return static::updateOrCreate(
            [
                'kelas_id' => $kelasId,
                'tanggal' => $tanggal,
            ],
            [
                'guru_id' => $guruId,
                'semester' => $semester,
                'murid_data' => $absensiData, // JSON: {murid_id: status}
            ]
        );
    }
}