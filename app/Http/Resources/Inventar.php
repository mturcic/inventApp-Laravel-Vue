<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Inventar extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'naziv inventara' => $this->nazivInventara,
            'slika inventara' => $this->slikaInventara,
            'datum nabave' => $this->datumNabave,
            'godina nabave' => $this->godinaNabave,
            'nabavna vrijednost' => $this->nabavnaVrijednost,
            'stopa amortizacije' => $this->stopaAmortizacije,
            'kolicina' => $this->kolicina,
            'jedinica mjere' => $this->jedinicaMjere,
            'napomena' => $this->napomena,
            'ulazna faktura' => $this->ulaznaFaktura,
            'otpis inventara' => $this->otpisInventara

            
        ];
    }
}