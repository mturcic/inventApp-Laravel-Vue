<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Prostor extends Model
{
    use Notifiable;
    
    protected $table = 'prostor';

    protected $fillable = [
        'opis_prostora',
        'adresa_prostora',
    ];

    public function prostorija()
    {
        return $this->hasMany(Prostorija::class,'prostor_id');
    }
}
