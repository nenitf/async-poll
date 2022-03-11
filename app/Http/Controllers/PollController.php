<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CadastroEnquete;

use App\Models\Enquete;

use App\Http\Resources\{
    PollResource,
    OptionResource,
};

class PollController extends Controller
{
    public function __construct(
        private CadastroEnquete $cadastroService,
    ) {}

    /**
     * @OA\Post(
     *     tags={"enquete"},
     *     path="/api/polls",
     *     description="Cadastro de enquete",
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json;charset=UTF-8",
     *             @OA\Schema(
     *                 required={"title", "options"},
     *                 @OA\Property(
     *                      property="title",
     *                      type="string",
     *                      example="Melhor parmegiana de Porto Alegre",
     *                 ),
     *                 @OA\Property(
     *                      property="options",
     *                      type="array",
     *                      example={{
     *                          "name": "La Osteria",
     *                          "order": "1",
     *                      }, {
     *                          "name": "Clédio",
     *                          "order": "2",
     *                      }},
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(property="name", type="string"),
     *                          @OA\Property(property="order", type="integer"),
     *                      ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(response="2XX", description="OK"),
     * )
     */
    public function store(Request $r)
    {
        $this->validate($r, [
            "title"             => "required",
            "options"           => "required|array|min:2",
            "options.*.name"    => "required|string|distinct",
            "options.*.order"   => "required|integer|distinct",
        ]);

        $opcoes = OptionResource::translate($r->options);

        $e = $this->cadastroService->execute(
            titulo: $r->title,
            opcoes: $opcoes,
        );

        return new PollResource($e);
    }
}

