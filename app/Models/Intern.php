<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Intern extends Model
{
    use HasFactory;

    protected $table = 'interns';
    protected $primaryKey = 'intern_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'profile_picture',
        'phone_number',
        'batch',
        // 'asal_kampus', // Baris ini dihapus
        'mentor_id',
        'joining_date',
        'termination_date',
    ];

    /**
     * Dapatkan user yang memiliki intern ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Dapatkan mentor yang membimbing intern ini.
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }

    /**
     * Dapatkan semua catatan kehadiran untuk intern ini.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'intern_id', 'intern_id');
    }

    /**
     * Dapatkan semua catatan penggajian untuk intern ini.
     */
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'intern_id', 'intern_id');
    }

    /**
     * Dapatkan semua penilaian untuk intern ini.
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'intern_id', 'intern_id');
    }

    /**
     * Accessor untuk mendapatkan URL foto profil.
     * Jika tidak ada foto, akan mengembalikan URL avatar dummy.
     *
     * @return string
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return Storage::url('avatars/' . $this->profile_picture);
        }

        $initials = strtoupper(substr($this->full_name, 0, 1));
        $bgColor = '007bff';
        $textColor = 'ffffff';
        $size = '100x100';

        return "https://placehold.co/{$size}/{$bgColor}/{$textColor}?text={$initials}";
    }
}