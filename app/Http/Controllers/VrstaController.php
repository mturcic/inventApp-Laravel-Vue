<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vrsta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class VrstaController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Vrsta::with('kategorija')->orderBy('naziv_vrste')->paginate();
    }

    public function all()
    {
        return Vrsta::orderBy('naziv_vrste')->get();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'naziv_vrste'=> 'required|string|max:191',

        ],
        [
            'naziv_vrste.required' => 'Niste unijeli naziv!',
            'naziv_vrste.string' => 'Naziv mora biti tekst!',
            'naziv_vrste.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);

        $vrste = new Vrsta(array(
            'naziv_vrste' => $request['naziv_vrste'],
            'kategorija_id' => $request['kategorija_id'],
        ));

        if ($vrste->save()) {
            Log::info('Uspješno unesena vrsta "' . $request['naziv_vrste']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Vrsta "' . $request['naziv_vrste']. '" nije unesena.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Vrsta $vrste
     * @return \Illuminate\Http\Response
     */
    public function show(Vrsta $vrstum)
    {
        return response()->json(Vrsta::with('inventar.prostorija.prostor','kategorija')->find($vrstum->id));        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Vrsta $vrste
     * @return \Illuminate\Http\Response
     */
    public function edit(Vrsta $vrste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vrsta $vrste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'naziv_vrste'=> 'required|string|max:191',

        ],
        [
            'naziv_vrste.required' => 'Niste unijeli naziv!',
            'naziv_vrste.string' => 'Naziv mora biti tekst!',
            'naziv_vrste.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);

        $vrste=Vrsta::find($request->id);
        Log::alert($vrste);

        if ($vrste->update($request->all())) {
            Log::info('Uspješno ažurirana vrsta "' . $request['naziv_vrste']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Vrsta "' . $request['naziv_vrste']. '" nije ažurirana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vrsta $vrste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vrsta $vrstum)
    {
        if ($vrstum->delete()) {
            Log::info('Uspješno obrisana vrsta "' . $vrstum['naziv_vrste']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Vrsta "' . $vrstum['naziv_vrste']. '" nije obrisana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }
}