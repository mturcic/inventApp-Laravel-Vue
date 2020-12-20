<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Prostor extends Resource
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
            'opis prostora' => $this->opisProstora,
            'adresa prostora' => $this->adresaProstora
        ];
    }
}
