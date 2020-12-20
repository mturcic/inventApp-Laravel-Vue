<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventar;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Prostorija_inventar;
use App\Prostorija;
use App\Vrsta;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class InventarController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //povezivanje inventara i vrste/tvrtke/prostorije s naredbom with a naziv vrste/tvrtke/prostorije je deklariran u modelu Inventar
        return Inventar::with('vrsta','vrsta.kategorija','tvrtka','prostorija.prostor')->orderBy('naziv_inventara')->paginate();
    }

    public function all()
    {
        return Inventar::orderBy('naziv_inventara')->get();
    }

    //Pretraživanje
    public function search(){

        if ($search = \Request::get('q')) {
            $inventar = Inventar::where(function($query) use ($search){
                $query->where('naziv_inventara','LIKE',"%$search%")
                    ->orWhere('ulazna_faktura','LIKE',"%$search%");
                    // ->orWhere('vrsta.naziv_vrste','LIKE',"%$search%")
                    // ->orWhere('kategorija.naziv_kategorije','LIKE',"%$search%")
                    // ->orWhere('tvrtka.naziv_tvrtke','LIKE',"%$search%")
                    // ->orWhere('prostorija.naziv_prostorije','LIKE',"%$search%");
            })->with('vrsta.kategorija','tvrtka','prostorija.prostor')->orderBy('naziv_inventara')->paginate();
        }else{
            $inventar = Inventar::with('vrsta.kategorija','tvrtka','prostorija.prostor')->orderBy('naziv_inventara')->paginate();
        }

        return $inventar;

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
            'naziv_inventara'=>'required|string|max:191',
            'kolicina'=>'required',
            'jedinica_mjere'=>'required|string',
            'vrsta_id'=>'required|not_in:0',
            'prostorija_id'=>'required|not_in:0',
            'kategorija_id'=>'required|not_in:0',
        ],
        [
            'naziv_inventara.required' => 'Niste unijeli naziv!',
            'naziv_inventara.string' => 'Naziv mora biti tekst!',
            'naziv_inventara.max' => 'Naziv može sadržavati najviše :max slova!',

            'kolicina.required' => 'Niste unijeli količinu!',

            'jedinica_mjere.required' => 'Niste unijeli jedinicu mjere!',
            'jedinica_mjere.string' => 'Jedinica mjere mora biti tekst!',

            'prostorija_id.required' => 'Niste odabrali kategoriju!',
            'prostorija_id.not_in' => 'Niste odabrali kategoriju!',

            'kategorija_id.required' => 'Niste odabrali kategoriju!',
            'kategorija_id.not_in' => 'Niste odabrali kategoriju!',

            'vrsta_id.required' => 'Niste odabrali vrstu!',
            'vrsta_id.not_in' => 'Niste odabrali vrstu!',
        ]);
       

        $id = Inventar::insertGetId(array(
            'naziv_inventara' => $request['naziv_inventara'],
            'slika_inventara' => 'inventar_default.png',
            'datum_nabave' => $request['datum_nabave'],
            'godina_nabave' => $request['godina_nabave'],
            'nabavna_vrijednost' => $request['nabavna_vrijednost'],
            'stopa_amortizacije' => $request['stopa_amortizacije'],
            'kolicina' => $request['kolicina'],
            'jedinica_mjere' => $request['jedinica_mjere'],
            'napomena' => $request['napomena'],
            'ulazna_faktura' => 'faktura_default.pdf',
            'vrsta_id' => $request['vrsta_id'],
            'otpis_inventara' => $request['otpis_inventara'],
            'generirani_kod' => $request['generirani_kod'],
            'tvrtka_id' => $request['tvrtka_id'],
        ));

        $inventar =Inventar::find($id);
        Log::alert(json_encode($request['prostorija_id']));

        foreach($request['prostorija_id'] as $prostorija_id){

            $inventar_prostorije = new Prostorija_inventar(array(

                'prostorija_id' => $prostorija_id,
                'inventar_id' => $id
    
            ));

            if($inventar_prostorije->save()) {

                $prostorija=Prostorija::find($prostorija_id);

                Log::info('Uspješno povezan inventar "' . $inventar['naziv_inventara']. '" s prostorijom "' . $prostorija['naziv_prostorije']. '"');
                 continue;
            } else {
                Log::error('Neuspjeh - Inventar nije povezan s prostorijom "' . $prostorija['naziv_prostorije']. '"');
                continue;
            }

        }

        if ($request->hasFile('slika_inventara')) {
            
                $file= $request->file('slika_inventara');

                Log::alert('Postoji slika za inventar i unosimo ju');
                $imageName = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('images'), $imageName);
                $inventar->slika_inventara= $imageName;
                $inventar->update();

            
        }

        if ($request->hasFile('ulazna_faktura')) {
                $pdf=$request->file('ulazna_faktura');
         
                Log::alert('Postoji račun za inventar i unosimo ju');
                $documentName = $pdf->getClientOriginalName();
                $pdf->move(public_path('documents'), $documentName);
                $inventar->ulazna_faktura= $documentName;
                $inventar->update();
               

            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Inventar $inventar
     * @return \Illuminate\Http\Response
     */
    public function update(Inventar $inventar,Request $request)
    {
        $this->validate($request, [
            'naziv_inventara'=>'required|string|max:191',
            'kolicina'=>'required',
            'jedinica_mjere'=>'required|string',
        ],
        [
            'naziv_inventara.required' => 'Niste unijeli naziv!',
            'naziv_inventara.string' => 'Naziv mora biti tekst!',
            'naziv_inventara.max' => 'Naziv može sadržavati najviše :max slova!',

            'kolicina.required' => 'Niste unijeli količinu!',

            'jedinica_mjere.required' => 'Niste unijeli jedinicu mjere!',
            'jedinica_mjere.string' => 'Jedinica mjere mora biti tekst!',
        ]);

        $currentPhoto = $inventar->slika_inventara;
        if($request->slika_inventara != $currentPhoto) {
            $imageName = time().'.' . explode('/', explode(':', substr($request->slika_inventara, 0, strpos($request->slika_inventara, ';')))[1])[1];
            Image::make($request->slika_inventara)->save(public_path('images/').$imageName);
            $request->merge(['slika_inventara' => $imageName]);

            $inventarPhoto = public_path('images/').$currentPhoto;

            if(file_exists($inventarPhoto)){
                @unlink($inventarPhoto);
            }
            tap ($inventar)->update($request->except('ulazna_faktura'));
        }

        $currentDoc = $inventar->ulazna_faktura;
        if($request->ulazna_faktura != $currentDoc) {
            Log::alert('Ulazim u IF za dokuemnte');
            $docName = time().'.' . explode('/', explode(':', substr($request->ulazna_faktura, 0, strpos($request->ulazna_faktura, ';')))[1])[1];

            Storage::putFileAs('documents', new File($request->file('ulazna_faktura')),$docName);
         
            $request->merge(['ulazna_faktura' => $docName]);

            $documentPhoto = public_path('documents/').$currentDoc;

            if(file_exists($documentPhoto)){
                @unlink($documentPhoto);
            }
            tap ($inventar)->update($request->except('slika_inventara'));
        }
        
        return tap ($inventar)->update($request->except('slika_inventara','ulazna_faktura'));
        


        // if ($inventar->update($request->all())) {
        //     Log::info('Uspješno ažurirana stavka "' . $request['naziv_inventara']. '"');
        //     return response(null, Response::HTTP_OK);
        // } else {
        //     Log::error('Neuspjeh - Stavka "' . $request['naziv_inventara']. '" nije ažurirana.');
        //     return response(null, Response::HTTP_NOT_IMPLEMENTED);
        // }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventar $inventar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventar $inventar)
    {
        if($inventar->delete()) {
            Log::info('Uspješno obrisana stavka "' . $inventar['naziv_inventara']. '"');
            return response(null, Response::HTTP_OK);
        } else {
            Log::error('Neuspjeh - Stavka "' . $inventar['naziv_inventara']. '" nije obrisana.');
            return response(null, Response::HTTP_NOT_IMPLEMENTED);
        }
    }
}
