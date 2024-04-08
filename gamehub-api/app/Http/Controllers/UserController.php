<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(protected User $repository)
    {

    }

    public function store(CreateUpdateUserRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = bcrypt($data['password']);

            $user = $this->repository::create($data);

            return new UserResource($user);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $user = $this->repository->with('gameLikes')
                ->find($user_id);
            return new UserResource($user);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(CreateUpdateUserRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->password)
                $data['password'] = bcrypt($data['password']);

            $user = $this->repository::findOrFail($request->user()->id);

            $user->update($data);

            return new UserResource($user);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $user = $this->repository::findOrFail($request->user()->id);
            $user->delete();

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
