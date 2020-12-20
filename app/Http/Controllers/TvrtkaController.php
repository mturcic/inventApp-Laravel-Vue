<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tvrtka;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TvrtkaController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tvrtka::orderBy('naziv_tvrtke')->paginate();
    }

    public function all()
    {
            return Tvrtka::orderBy('naziv_tvrtke')->get();
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
            'naziv_tvrtke'=> 'required|string|max:191',

        ],
        [
            'naziv_tvrtke.required' => 'Niste unijeli naziv!',
            'naziv_tvrtke.string' => 'Naziv mora biti tekst!',
            'naziv_tvrtke.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);

        $tvrtke = new Tvrtka(array(
            'naziv_tvrtke' => $request['naziv_tvrtke'],
        ));

        if ($tvrtke->save()) {
            Log::info('Uspješno unesena tvrtka "' . $request['naziv_tvrtke']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Tvrtka "' . $request['naziv_tvrtke']. '" nije unesena.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Tvrtka $tvrtke
     * @return \Illuminate\Http\Response
     */
    public function show(Tvrtka $tvrtka)
    {
        return response()->json(Tvrtka::with('inventar.prostorija.prostor')->find($tvrtka->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Tvrtka $tvrtke
     * @return \Illuminate\Http\Response
     */
    public function edit(Tvrtka $tvrtke)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tvrtka $tvrtke
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'naziv_tvrtke'=> 'required|string|max:191',

        ],
        [
            'naziv_tvrtke.required' => 'Niste unijeli naziv!',
            'naziv_tvrtke.string' => 'Naziv mora biti tekst!',
            'naziv_tvrtke.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);

        $tvrtke=Tvrtka::find($request->id);
        Log::alert($tvrtke);

        if ($tvrtke->update($request->all())) {
            Log::info('Uspješno ažurirana tvrtka "' . $request['naziv_tvrtke']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Tvrtka "' . $request['naziv_tvrtke']. '" nije ažurirana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tvrtka $tvrtke
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tvrtka $tvrtka)
    {
        if ($tvrtka->delete()) {
            Log::info('Uspješno obrisana tvrtka "' . $tvrtka['naziv_tvrtke']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Tvrtka "' . $tvrtka['naziv_tvrtke']. '" nije obrisana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }
}