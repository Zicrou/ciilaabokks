<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Region extends Model
{
     use HasFactory, HasUuid; 
    protected $table = 'regions';

    protected $fillable = ['name', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function departements()
    {
        return $this->hasMany(Departement::class);
    }
}
