<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nama_material' => $this->nama_material,
            'product_name' => $this->product_name,
            'product_number' => $this->product_number,
            'p1' => $this->p1,
            'l' => $this->l,
            't' => $this->t,
            'd' => $this->d,
            'p2' => $this->p2,
            'qty' => $this->qty,
        ];
    }
}
