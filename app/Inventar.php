<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Sofa\Eloquence\Eloquence;

class Inventar extends Model
{
    use Notifiable;
    use Eloquence;

    protected $searchableColumns = ['naziv_inventara','ulazna_faktura','vrsta.naziv_vrste','kategorija.naziv_kategorije','tvrtka.naziv_tvrtke','prostorija.naziv_prostorije'];

    protected $table = 'inventar';

    protected $fillable = [
        'naziv_inventara',
        'slika_inventara',
        'datum_nabave',
        'godina_nabave',
        'nabavna_vrijednost',
        'stopa_amortizacije',
        'kolicina',
        'jedinica_mjere',
        'napomena',
        'ulazna_faktura',
        'otpis_inventara',
        'vrsta_id',
        'tvrtka_id',
        'generirani_kod',
    ];

    public function vrsta()
    {
        return $this->belongsTo(Vrsta::class,'vrsta_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tvrtka()
    {
        return $this->belongsTo(Tvrtka::class, 'tvrtka_id');
    }

    public function prostorija()
    {
        return $this->belongsToMany(Prostorija::class,'prostorija__inventar','inventar_id','prostorija_id');
    }
}