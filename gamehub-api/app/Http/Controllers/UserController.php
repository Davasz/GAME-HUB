<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return $user;
    }

    public function show(string $id)
    {
        return User::find($id);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id)->update($request->all());
        return $user;
    }

    public function destroy(string $id)
    {
        $user = User::find($id)->delete();
        return $user;
    }
}
