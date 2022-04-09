<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    
    public function getOne($id)
    {
        $userId = auth()->user()->id;
        $contact = Contact::where('user_id', $userId)->findOrFail($id);

        return $contact;
    }
    public function getOneByName(Request $request)
    {
        $dataUser = auth()->user();
        $contact = Contact::where('user_id', $dataUser->id)->where('name', 'like', '%'.$request->name.'%')->findOrFail();
       
        return $contact;
    }

    public function delete($id)
    {
        $userId = auth()->user()->id;

        $contact = Contact::where('user_id', $userId)->findOrFail($id);

        $contact->delete();

        return 'Contact deleted';
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }   

        $data = [
            'name' => $request->name,
            'surname' => $request->surname,
            'phone' => $request->phone,
            'email' => $request->email,
            'user_id' => auth()->user()->id
        ];

        Contact::create($data);

        return 'Contact created';
    }

    public function updateOne(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'surname' => 'string',
            'phone' => 'string',
            'email' => 'string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $userId = auth()->user()->id;
        $contact = Contact::where('user_id', $userId)->findOrFail($id);

        if (isset($request->name)){
            $contact->name = $request->name;
        }
        if ($request->has('surname')){
            $contact->surname = $request->surname;
        }
        if ($request->has('phone')){
            $contact->phone = $request->phone;
        }
        if ($request->has('email')){
            $contact->email = $request->email;
        }

        $contact->save();

        $response = [
            'contact' => $contact,
            'message' =>'contact updated'
        ];

        return $response;
    }

    public function getAllByUser()
    {
        $dataUser = auth()->user();

        $contactsByUserId = User::findOrFail($dataUser->id)->contacts;

        $response = [
            'user' => $dataUser,
            'contacts' => $contactsByUserId
        ];

        return $response;
    }
}
