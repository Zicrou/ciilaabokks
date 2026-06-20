<?php

namespace App\Models;

use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metier extends Model
{
    use HasFactory, HasUuid;
    protected $table = 'metiers';

    protected $fillable = ['name', 'domaine_id'];

    public function domaine()
    {
        return $this->belongsTo(Domaine::class);
    }

    public function ouvriers()
    {
        return $this->belongsToMany(Ouvrier::class );
    }
}
