<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'nip',
        'phone',
        'address'
    ];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }

    public function murid()
    {
        return $this->hasMany(Murid::class, 'orangtua_id');
    }

    // Scope untuk mendapatkan user dengan role guru
    public function scopeGuru($query)
    {
        return $query->role('guru');
    }

    // Scope untuk mendapatkan guru yang belum memiliki kelas
    public function scopeGuruTanpaKelas($query)
    {
        return $query->role('guru')->doesntHave('kelas');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
