<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prostorija;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProstorijaController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //povezivanje prostorije i prostora naredbom with gdje je ime prostor deklarirano u modelu Prostorija
        return Prostorija::with('prostor')->orderBy('naziv_prostorije')->paginate();
    }

    public function all()
    {
        return Prostorija::orderBy('naziv_prostorije')->get();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'naziv_prostorije'=>'required|string|max:191',
        ],
        [
            'naziv_prostorije.required' => 'Niste unijeli naziv!',
            'naziv_prostorije.string' => 'Naziv mora biti tekst!',
            'naziv_prostorije.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);
        $prostorije = new Prostorija(array(
            'naziv_prostorije' => $request['naziv_prostorije'],
            'prostor_id' => $request['prostor_id'],
        ));

        if ($prostorije->save()) {
            Log::info('Uspješno unesena prostorija "' . $request['naziv_prostorije']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Prostorija "' . $request['naziv_prostorije']. '" nije unesena.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prostorija  $prostori
     * @return \Illuminate\Http\Response
     */
    public function show(Prostorija $prostorija)
    {
        return response()->json(Prostorija::with('inventar.prostorija.prostor')->find($prostorija->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prostorija $prostorije
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request)
    {
        $this->validate($request, [
            'naziv_prostorije'=>'required|string|max:191',
        ],
        [
            'naziv_prostorije.required' => 'Niste unijeli naziv!',
            'naziv_prostorije.string' => 'Naziv mora biti tekst!',
            'naziv_prostorije.max' => 'Naziv može sadržavati najviše :max slova!',

        ]);
        $prostorije = Prostorija::find($request->id);
        Log::alert($prostorije);

        if ($prostorije->update($request->all())) {
            Log::info('Uspješno ažurirana prostorija "' . $request['naziv_prostorije']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Prostorija "' . $request['naziv_prostorije']. '" nije ažurirana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prostorija  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prostorija $prostorija)
    {
        if ($prostorija->delete()) {
            Log::info('Uspješno obrisana prostorija "' . $prostorija['naziv_prostorije']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Prostorija "' . $prostorija['naziv_prostorije']. '" nije obrisana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }
}