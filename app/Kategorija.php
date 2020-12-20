<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kategorija extends Model
{
    use Notifiable;

    protected $table = 'kategorija';
    
    protected $fillable = [
        'naziv_kategorije',
    ];



    public function vrsta()
    {
        return $this->hasMany(Vrsta::class,'kategorija_id');
    }
}
