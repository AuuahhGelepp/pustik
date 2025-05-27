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
        // Add other fillable fields based on your migration
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
