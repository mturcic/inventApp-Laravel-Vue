<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategorija;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class KategorijaController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            return Kategorija::orderBy('naziv_kategorije')->paginate();
    }

    public function all()
    {
            return Kategorija::with('vrsta')->orderBy('naziv_kategorije')->get();
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
            'naziv_kategorije'=> 'required|string|max:191',

        ],
        [
            'naziv_kategorije.required' => 'Niste unijeli naziv!',
            'naziv_kategorije.string' => 'Naziv mora biti tekst!',
            'naziv_kategorije.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);

        $kategorije = new Kategorija(array(
            'naziv_kategorije' => $request['naziv_kategorije'],
        ));

        if ($kategorije->save()) {
            Log::info('Uspješno unesena kategorija "' . $request['naziv_kategorije']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Kategorija "' . $request['naziv_kategorije']. '" nije unesena.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kategorija $kategorije
     * @return \Illuminate\Http\Response
     */
    public function show(Kategorija $kategorija)

    {
        return response()->json(Kategorija::with('vrsta')->find($kategorija->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategorija $kategorije
     * @return \Illuminate\Http\Response
     */
    public function edit(Kategorija $kategorije)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kategorija $kategorije
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request)
    {
        $this->validate($request, [
            'naziv_kategorije'=> 'required|string|max:191',

        ],
        [
            'naziv_kategorije.required' => 'Niste unijeli naziv!',
            'naziv_kategorije.string' => 'Naziv mora biti tekst!',
            'naziv_kategorije.max' => 'Naziv može sadržavati najviše :max slova!',
        ]);

        $kategorije=Kategorija::find($request->id);
        Log::alert($kategorije);

        if ($kategorije->update($request->all())) {
            Log::info('Uspješno ažurirana kategorija "' . $request['naziv_kategorije']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Kategorija "' . $request['naziv_kategorije']. '" nije ažurirana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kategorija $kategorije
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kategorija $kategorija)
    {
        if ($kategorija->delete()) {
            Log::info('Uspješno obrisana kategorija "' . $kategorija['naziv_kategorije']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Kategorija "' . $kategorija['naziv_kategorije']. '" nije obrisana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }
}
