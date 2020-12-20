<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Prostor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProstorController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Prostor::orderBy('opis_prostora')->paginate();
    }

    public function all()
    {
        return Prostor::with('prostorija')->orderBy('opis_prostora')->get();
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
            'opis_prostora'=>'required|string|max:191',
            'adresa_prostora'=>'required|string|max:191',
        ],
        [
            'opis_prostora.required' => 'Niste unijeli opis!',
            'opis_prostora.string' => 'Opis mora biti tekst!',
            'opis_prostora.max' => 'Opis može sadržavati najviše :max slova!',

            'adresa_prostora.required' => 'Niste unijeli adresu!',
            'adresa_prostora.string' => 'Adresa mora biti tekst!',
            'adresa_prostora.max' => 'Adresa može sadržavati najviše :max slova!',
        ]);
        $prostori = new Prostor(array(
            'opis_prostora' => $request['opis_prostora'],
            'adresa_prostora' => $request['adresa_prostora'],
        ));

        if ($prostori->save()) {
            Log::info('Uspješno unesen prostor "' . $request['opis_prostora']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Prostor "' . $request['opis_prostora']. '" nije unesen.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prostor  $prostori
     * @return \Illuminate\Http\Response
     */

    public function show(Prostor $prostor)

    {
        return response()->json(Prostor::with('prostorija')->find($prostor->id));
        //return response()->json($parent->children()->with('city')->get());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prostor $prostori
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'opis_prostora'=>'required|string|max:191',
            'adresa_prostora'=>'required|string|max:191',
        ],
        [
            'opis_prostora.required' => 'Niste unijeli opis!',
            'opis_prostora.string' => 'Opis mora biti tekst!',
            'opis_prostora.max' => 'Opis može sadržavati najviše :max slova!',

            'adresa_prostora.required' => 'Niste unijeli adresu!',
            'adresa_prostora.string' => 'Adresa mora biti tekst!',
            'adresa_prostora.max' => 'Adresa može sadržavati najviše :max slova!',
        ]);
        $prostori = Prostor::find($request->id);
        Log::alert($prostori);

        if ($prostori->update($request->all())) {
            Log::info('Uspješno ažuriran prostor "' . $request['opis_prostora']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Prostor "' . $request['opis_prostora']. '" nije ažuriran.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prostor  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prostor $prostor)
    {
        if ($prostor->delete()) {
            Log::info('Uspješno obrisan prostor "' . $prostor['opis_prostora']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Prostor "' . $prostor['opis_prostora']. '" nije obrisan.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }
}
