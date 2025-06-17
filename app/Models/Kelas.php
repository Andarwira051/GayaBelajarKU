<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'token_kelas',
        'pengajar_id',
    ];

    public function pengajar()
    {
        return $this->belongsTo(User::class, 'pengajar_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_kelas', 'kelas_id', 'user_id')->withTimestamps();
    }
}

