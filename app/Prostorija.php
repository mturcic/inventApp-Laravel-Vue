<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Prostorija extends Model
{
    use Notifiable;

    protected $table = 'prostorija';

    protected $fillable = [
        'naziv_prostorije',
        'prostor_id'
    ];
    
    public function prostor()
    {
        return $this->belongsTo(Prostor::class,'prostor_id');
    }

    public function inventar()
    {
        return $this->belongsToMany(Inventar::class,'prostorija__inventar','prostorija_id','inventar_id');
    }
}