<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getOne($id)
    {
        $user = User::findOrFail($id);

        return $user;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return 'User deleted';
    }
    public function updateOne(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'surname' => 'string',
            'nickname' => 'string',
            'age' => 'integer',
            'email' => 'email',
            'password' => 'string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = auth()->user()->id;
        $user = User::where('id', $userId)->findOrFail($id);

        if (isset($request->name)){
            $user->name = $request->name;
        }
        if ($request->has('surname')){
            $user->surname = $request->surname;
        }
        if ($request->has('nickname')){
            $user->nickname = $request->nickname;
        }
        if ($request->has('age')){
            $user->age = $request->age;
        }
        if ($request->has('email')){
            $user->email = $request->email;
        }

        $user->save();

        return 'User updated';
    }

}
