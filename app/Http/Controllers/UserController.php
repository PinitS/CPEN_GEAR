<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers()
    {
        $dataUser = User::where('id' ,"!=" ,Auth::user()->id)->get();
        return response()->json(['status' => true , 'dataUser' => $dataUser]);
    }
    public function getOneUser($id)
    {
        $dataUser = User::find($id);
        return response()->json(['status' => true , 'dataUser' => $dataUser]);
    }
    public function create(Request $request)
    {

        $item = new User;
        $item->name = $request->input('name');
        $item->email = $request->input('email');
        $item->password = Hash::make($request->input('password'));
        $item->status = 0;
        $item->amount = 0;
        if($item->save()){
            return response()->json(['status' => true]);
        }
        else{
            return response()->json(['status' => false]);
        }

    }
    public function update(Request $request , $id)
    {
        $item = User::find($id);
        $item->name = $request->input('name');
        $item->email = $request->input('email');
        $item->status = $request->input('status');
        if($item->save()){
            return response()->json(['status' => true]);
        }
        else{
            return response()->json(['status' => false]);
        }
    }
    public function delete($id)
    {
        $item = User::find($id)->delete();
        return response()->json(['status' => true]);
    }
    public function resetPassword(Request $request , $id)
    {
        $item = User::find($id);
        $item->password = Hash::make($request->input('password'));
        if($item->save()){
            if($id == Auth::user()->id)
            {
                return response()->json(['status' => "only"]);
            }
            return response()->json(['status' => "other"]);
        }
        else{
            return response()->json(['status' => "false"]);
        }
    }
    //
}
