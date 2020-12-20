<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tvrtka extends Model
{
    use Notifiable;

    protected $table = 'tvrtka';
    
    protected $fillable = [
        'naziv_tvrtke',
    ];

    public function inventar()
    {
        return $this->hasMany(Inventar::class,'tvrtka_id');
    }
}
