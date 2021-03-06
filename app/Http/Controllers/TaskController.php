<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function getOne($id)
    {
        $userId = auth()->user()->id;
        $task = Task::where('user_id', $userId)->findOrFail($id);

        return $task;
    }
    public function getOneByTitle(Request $request)
    {
        $dataUser = auth()->user();
        $task = Task::where('user_id', $dataUser->id)->where('title', 'like', '%'.$request->title.'%')->findOrFail();

        return $task;
    }

    public function delete($id)
    {
        $userId = auth()->user()->id;

        $task = Task::where('user_id', $userId)->findOrFail($id);

        $task->delete();

        return 'Task deleted';
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }   

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => auth()->user()->id
        ];

        Task::create($data);

        return 'Task created';
    }
    public function updateOne(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'description' => 'string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = auth()->user()->id;
        $task = Task::where('user_id', $userId)->findOrFail($id);

        if (isset($request->title)){
            $task->title = $request->title;
        }
        if ($request->has('description')){
            $task->description = $request->description;
        }

        $task->save();

        return 'Task updated';
    }

    public function getAllByUser()
    {
        $dataUser = auth()->user();

        $tasksByUserId = User::findOrFail($dataUser->id)->tasks;

        $response = [
            'user' => $dataUser,
            'tasks' => $tasksByUserId
        ];

        return $response;
    }
};
