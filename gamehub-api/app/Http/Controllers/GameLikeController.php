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
        try {
            $userId = $request->user()->id;

            $likedGame = $this->repository
                ->where('user_id', $userId)
                ->where('game_slug', $request->game_slug)
                ->first();

            if ($likedGame) {
                return response()->json(['error' => 'This game has already been liked'], Response::HTTP_FORBIDDEN);
            }

            $data = $request->validated();
            $data["user_id"] = $userId;

            $game = $this->repository->create($data);
            return $game;
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request, string $id)
    {
        try {
            $userId = $request->user()->id;
            $game = $this->repository->find($userId);
            $game->delete();
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
