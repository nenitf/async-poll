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
     * @OA\Get(
     *     tags={"enquete"},
     *     path="/api/polls",
     *     description="Listagem de enquetes",
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Página",
     *         @OA\Schema(type="integer", example=1),
     *     ),
     *     @OA\Response(response="2XX", description="OK"),
     * )
     */
    public function index(Request $r)
    {
        return PollResource::collection(
            Enquete::paginate(10)
        );
    }

    /**
     * @OA\Get(
     *     tags={"enquete"},
     *     path="/api/polls/{id}",
     *     description="Exibição de 1 enquete",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id enquete",
     *         required=true,
     *         @OA\Schema(type="integer", example=1),
     *     ),
     *     @OA\Response(response="2XX", description="OK"),
     * )
     */
    public function show(int $id, Request $r)
    {
        return new PollResource(Enquete::findOrFail($id));
    }

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

