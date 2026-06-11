<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Portfolio extends Model
{
     use HasFactory, HasUuid; 
    protected $table = 'portfolios';

    protected $fillable = ['image', 'ouvrier_id'];

    public function ouvrier()
    {
        return $this->belongsTo(Ouvrier::class);
    }
}
