<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ouvrier extends Model
{
    use HasFactory, HasUuid; 
    protected $table = 'ouvrier';


    protected $fillable = ['name', 'date_of_birth', 'country_id', 'region_id', 'departement_id', 'domain_id', 'metier_id', 'photo', 'phone_number', 'email', 'address', 'phone_number_2', 'photo_cni', 'numero_cni', 'annees_experience', 'entreprises'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }
}
