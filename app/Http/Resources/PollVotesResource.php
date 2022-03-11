<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PollVotesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'options' => array_map(fn($o) => [
                'option_id' => $o->id,
                'total'     => count($o->votos),
            ], iterator_to_array($this->opcoes)),
        ];
    }
}

