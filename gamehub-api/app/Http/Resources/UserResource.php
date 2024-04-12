<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
        ];

        if ($request->method() == "GET") {
            $user = [
                "id" => $this->id,
                "name" => $this->name,
                "email" => $this->email,
                "game_likes" => $this->gameLikes,
                "game_bougts" => $this->gameBougth
            ];
        }

        return $user;
    }
}
