<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'assessments';

    /**
     * Kolom primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'assessment_id';

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
        'intern_id',
        'mentor_id',
        'rating',
        'feedback',
        'assessment_date',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'assessment_date' => 'date',
    ];

    /**
     * Dapatkan intern yang dinilai.
     */
    public function intern()
    {
        return $this->belongsTo(Intern::class, 'intern_id', 'intern_id');
    }

    /**
     * Dapatkan mentor yang memberikan penilaian.
     */
    public function mentor()
    {
        return $this->belongsTo(Mentor::class, 'mentor_id', 'mentor_id');
    }
}