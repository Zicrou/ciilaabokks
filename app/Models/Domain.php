<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    protected $table = 'domain';

    protected $fillable = ['name'];
    
    public function metiers()
    {
        return $this->hasMany(Metier::class);
    }
}
