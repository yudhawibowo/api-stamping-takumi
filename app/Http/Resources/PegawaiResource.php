<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PegawaiResource extends JsonResource
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
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'bagian' => $this->bagian,
            'username' => $this->username,
            'password' => $this->password,
            'id_jabatan' => $this->jabatan,
            'id_shift' => $this->id_shift,
        ];
    }
}
