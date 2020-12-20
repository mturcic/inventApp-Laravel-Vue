<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vrsta extends Model
{
    use Notifiable;

    protected $table = 'vrsta';
    
    protected $fillable = [
        'naziv_vrste',
        'kategorija_id'
    ];

    public function kategorija()
    {
        return $this->belongsTo(Kategorija::class,'kategorija_id');
    }

    public function inventar()
    {
        return $this->hasMany(Inventar::class,'vrsta_id');
    }
}
