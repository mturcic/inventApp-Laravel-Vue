<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Prostorija_Inventar extends Model
{
    use Notifiable;

    protected $table = 'prostorija__inventar';
    
    protected $fillable = [
        'prostorija_id',
        'inventar_id',
        
    ];
}
