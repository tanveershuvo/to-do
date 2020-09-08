<?php

namespace App\Http\Controllers;

use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function getAllTodos($id){
        $allTodos = Todo::with('user')->where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return response()->json($allTodos,Response::HTTP_OK);
    }

    public function createTodo(Request $request){
        $val = $request->validate([
           'title'=>'required|max:50',
           'details'=>'max:250',
            'user_id'=>'',
        ]);
        $created = Todo::create($val);
        return response()->json($created, Response::HTTP_OK);
    }

    public function destroy($id){
        $val = Todo::where('id',$id)->delete();
        return response()->json($val,Response::HTTP_OK);

    }
}
