<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'tgl_order' => $this->tgl_order,
            'id_customer' => $this->id_customer,
            'po_number' => $this->po_number,
            'quotation_number' => $this->quotation_number,
            'so_number' => $this->so_number,
            'product_name' => $this->product_name,
            'product_number' => $this->product_number,
            'qty' => $this->qty,
            'material_supply' => $this->material_supply,
            'internal_order_number' => $this->internal_order_number,
            'notes' => $this->notes,
            'upload_file' => $this->upload_file,
            'id_pegawai' => $this->id_pegawai,
        ];
    }
}
