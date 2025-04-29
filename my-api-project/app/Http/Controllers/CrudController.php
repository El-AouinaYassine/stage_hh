<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class CrudController extends Controller
{
    public function getAllUsers(){
        $allUser = User::all();
        return response()->json(data: ['users'=>$allUser], status: 200);
    }
    public function getUserById($id){
        $user = User::find($id);
        if($user == null){
            return response()->json(data:['msg'=>'user not found'],status:404);
        }else{
            return response()->json(data:['user'=>$user],status:200);
        }
    }
    public function deleteUserById($id){
        $user = User::find($id);
        if($user == null){
            return response()->json(data:['msg'=>'user not found'],status:404);
        }else{
            $user->delete();
            return response()->json(data:['msg'=>"user $user->name is deleted !!"],status:200);
        }
    }
    public function updateUserById(Request $request ,$id){
        $user = User::find($id);
        if($user == null){
            return response()->json(data:['msg'=>'user not found'],status:404);
        }else{
            $user->name=$request->name;
            $user->email=$request->email;
            $user->save();
            return response()->json(data:['msg'=>"user $user->name is deleted !!"],status:200);
        }
    }
}
