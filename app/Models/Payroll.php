<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'payroll';

    /**
     * Kolom primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'payroll_id';

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
        'payment_date',
        'amount',
        'description',
    ];

    /**
     * Dapatkan intern yang terkait dengan catatan penggajian ini.
     */
    public function intern()
    {
        return $this->belongsTo(Intern::class, 'intern_id', 'intern_id');
    }
}