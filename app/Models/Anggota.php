<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Anggota extends Model
{
    use HasFactory;
    
    protected $table = 'anggota';
    
    protected $fillable = [
        'nama',
        'foto',
        'divisi_id',
        'alamat',
        'no_telp'
    ];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('images/default-avatar.png');
    }
}
