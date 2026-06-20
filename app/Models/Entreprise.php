<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Entreprise extends Model
{
     use HasFactory, HasUuid; 
    protected $table = 'entreprises';

    protected $fillable = ['name', 'ouvrier_id'];

    public function ouvriers()
    {
        return $this->belongsToMany(Ouvrier::class);
    }
}
