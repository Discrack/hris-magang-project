<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Kolom primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Menunjukkan apakah ID bersifat auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data primary key.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed', // PASTIKAN BARIS INI ADA DAN BENAR
        // 'email_verified_at' => 'datetime', // Anda bisa menghapus ini jika tidak digunakan
    ];

    /**
     * Dapatkan model mentor yang terkait dengan user ini.
     */
    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'user_id', 'user_id');
    }

    /**
     * Dapatkan model intern yang terkait dengan user ini.
     */
    public function intern()
    {
        return $this->hasOne(Intern::class, 'user_id', 'user_id');
    }
}