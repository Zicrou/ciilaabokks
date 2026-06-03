<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Metier extends Model
{
    protected $table = 'metier';

    protected $fillable = ['name', 'domain_id'];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }
}
