<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    
    public function getOne($id)
    {
        $userId = auth()->user()->id;
        $note = Note::where('user_id', $userId)->findOrFail($id);

        return $note;
    }
    public function getOneByTitle(Request $request)
    {
        $dataUser = auth()->user();
        $note = Note::where('user_id', $dataUser->id)->where('title', 'like', '%'.$request->title.'%')->findOrFail();

        return $note;
    }

    public function delete($id)
    {
        $userId = auth()->user()->id;

        $note = Note::where('user_id', $userId)->findOrFail($id);

        $note->delete();

        return 'Note deleted';
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

        Note::create($data);

        $response = [
            'note' => $data
        ];

        return $response ;
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
        $note = Note::where('user_id', $userId)->findOrFail($id);

        if (isset($request->title)){
            $note->title = $request->title;
        }
        if ($request->has('description')){
            $note->description = $request->description;
        }

        $note->save();

        $response = [
            'note' => $note,
            'message' =>'note updated'
        ];

        return $response;
    }

    public function getAllByUser()
    {
        $dataUser = auth()->user();

        $notesByUserId = User::findOrFail($dataUser->id)->notes;

        $response = [
            'user' => $dataUser,
            'notes' => $notesByUserId
        ];

        return $response;
    }
}
