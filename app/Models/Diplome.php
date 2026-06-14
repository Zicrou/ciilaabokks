<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Diplome extends Model
{
     use HasFactory, HasUuid; 
    protected $table = 'diplomes';

    protected $fillable = ['name'];

    public function ouvriers()
    {
        return $this->belongsToMany(Ouvrier::class );
    }
}
