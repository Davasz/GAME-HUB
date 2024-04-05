<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(protected User $repository) {

    }

    public function index()
    {
        $user = $this->repository::paginate();
        return UserResource::collection($user);
    }

    public function store(CreateUpdateUserRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $user = $this->repository::create($data);

        return new UserResource($user);
    }

    public function show(Request $request,string $id)
    {
        $user = $this->repository::findOrFail($id);
        return new UserResource($user);
    }

    public function update(CreateUpdateUserRequest $request, string $id)
    {
        $data = $request->validated();

        if ($request->password)
            $data['password'] = bcrypt($data['password']);

        $user = $this->repository::findOrFail($id);

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        $user = $this->repository::findOrFail($id);
        $user->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
