<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MesinResource extends JsonResource
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
            'code_mesin' => $this->code_mesin,
            'nama_mesin' => $this->nama_mesin,
            'tonase' => $this->tonase,
            'sph' => $this->sph,
            'capacity' => $this->capacity,
            'status_mesin' => $this->status_mesin,
        ];
    }
}
