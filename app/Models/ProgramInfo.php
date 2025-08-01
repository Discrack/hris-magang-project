<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramInfo extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'program_info';

    /**
     * Kolom primary key untuk model ini.
     *
     * @var string
     */
    protected $primaryKey = 'info_id';

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
        'title',
        'content',
    ];
}