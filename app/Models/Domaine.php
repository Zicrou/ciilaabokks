<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domaine extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'domaines';

    protected $fillable = ['name'];
    
    public function metiers()
    {
        return $this->hasMany(Metier::class);
    }

    public function ouvrier()
    {
        return $this->belongsToMany(Ouvrier::class );
    }
}
