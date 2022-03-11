<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'title'  => $this->titulo,
            'options' => OptionResource::collection($this->opcoes),
        ];
    }

    public static function translate($request)
    {
        if(is_array($request)) {
            return array_map(fn($r) => self::translate((object) $r), $request);
        }

        $traduzido = [
            'titulo' => $request->title,
            'opcoes' => OptionResource::translate($request->opcoes),
        ];

        if(isset($request->id)) {
            $traduzido['id'] = $request->id;
        }

        return $traduzido;
    }
}

