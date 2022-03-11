<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\CadastroVoto;

use App\Jobs\ComputaVotoJob;

class VoteController extends Controller
{
    public function __construct(
        private CadastroVoto $cadastroService,
    ) {}

    /**
     * @OA\Post(
     *     tags={"voto"},
     *     path="/api/votes",
     *     description="Cadastro de voto",
     *     @OA\RequestBody(
     *         @OA\MediaType(mediaType="application/json;charset=UTF-8",
     *             @OA\Schema(
     *                 required={"optionId"},
     *                 @OA\Property(
     *                      property="optionId",
     *                      type="integer",
     *                      example=1,
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
            "optionId" => "required|integer",
        ]);

        dispatch(new ComputaVotoJob($r->optionId));

        return response('', 202);
    }
}

