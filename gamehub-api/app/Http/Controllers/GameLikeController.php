<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateGameRequest;
use App\Models\GameLike;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GameLikeController extends Controller
{

    public function __construct(protected GameLike $repository)
    {

    }

    public function index(Request $request)
    {

    }

    public function store(CreateUpdateGameRequest $request)
    {
        $userId = $request->user()->id;
        $data = $request->validated();
        $data["user_id"] = $userId;

        $game = $this->repository->create($data);
        return $game;
    }

    public function update(Request $request, GameLike $gameLikes)
    {
        //
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $userId = $request->user()->id;
            $game = $this->repository->find($userId);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
