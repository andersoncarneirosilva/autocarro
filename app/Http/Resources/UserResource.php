<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'telefone'          => $this->telefone,
            'nivel_acesso'      => $this->nivel_acesso,
            'perfil'            => $this->perfil,
            'plano'             => $this->plano,
            'classe'            => $this->classe,
            'status'            => $this->status,
            'credito'           => $this->credito,
            'size_folder'       => $this->size_folder,
            'payment_status'    => $this->payment_status,
            'external_reference'=> $this->external_reference,

            // Foto com URL completa
            'image' => $this->image 
                ? url('storage/' . $this->image) 
                : null,

            'created_at' => $this->created_at
                ? $this->created_at->format('d/m/Y H:i')
                : null,

            'updated_at' => $this->updated_at
                ? $this->updated_at->format('d/m/Y H:i')
                : null,
        ];
    }
}
