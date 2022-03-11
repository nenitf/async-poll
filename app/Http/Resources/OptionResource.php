<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->nome,
            'order' => $this->ordem,
        ];
    }

    public static function translate($request)
    {
        if(is_array($request)) {
            return array_map(fn($r) => self::translate((object) $r), $request);
        }

        $traduzido = [
            'nome'  => $request->name,
            'ordem' => $request->order,
        ];

        if(isset($request->id)) {
            $traduzido['id'] = $request->id;
        }

        return $traduzido;
    }
}

