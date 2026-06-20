<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ouvrier extends Model
{
    use HasFactory, HasUuid; 
    protected $table = 'ouvriers';


    protected $fillable = ['name', 'date_of_birth', 'country_id', 'region_id', 'departement_id', 'photo', 'phone_number', 'email', 'address', 'phone_number_2', 'photo_cni', 'numero_cni', 'annees_experience', 'user_id'];

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function domaines()
    {
        return $this->belongsToMany(Domaine::class );
    }

    public function metiers()
    {
        return $this->belongsToMany(Metier::class );
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function diplomes()
    {
        return $this->belongsToMany(Diplome::class);
    }

    public function entrepriseS()
    {
        return $this->belongsToMany(Entreprise::class);
    }
}
