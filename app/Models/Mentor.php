<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'mentors';

    /**
     * Kolom primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'mentor_id';

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
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone_number',
        'department',
    ];

    /**
     * Dapatkan user yang memiliki mentor ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Dapatkan intern yang dibimbing oleh mentor ini.
     */
    public function interns()
    {
        return $this->hasMany(Intern::class, 'mentor_id', 'mentor_id');
    }

    /**
     * Dapatkan semua penilaian yang diberikan oleh mentor ini.
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'mentor_id', 'mentor_id');
    }
}