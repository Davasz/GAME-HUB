<?php

namespace App\Http\Controllers;

use App\Mail\BuyGame;
use App\Models\GameBougth;
use App\Http\Requests\CreateUpdateGameBougthRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class GameBougthController extends Controller
{

    public function __construct(protected GameBougth $repository)
    {

    }

    public function store(CreateUpdateGameBougthRequest $request)
    {
        try {
            $userId = $request->user()->id;

            $likedGame = $this->repository
            ->where('user_id', $userId)
            ->where('game_slug', $request->game_slug)
            ->first();

            if ($likedGame) {
                return response()->json(['error' => 'This game has already been bougth'], Response::HTTP_FORBIDDEN);
            }

            $data = $request->validated();
            $data["user_id"] = $userId;

            $game = $this->repository->create($data);

            // E-mail

            Mail::to($request->user())->send(new BuyGame([
                "fromName" => "GameHub.com",
                "subject" => "Purchase confirmation",
                "message" => "Congratulations on your new purchase, your $request->game_slug game activation key is: 1321378126786472",
            ]));

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
