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

    public function createOrUpdateTodo(Request $request){
        $val = $request->validate([
           'title'=>'required|max:50',
           'details'=>'max:250',
            'user_id'=>'',
        ]);

        $created = Todo::updateOrCreate(
            ['id'=>$request->id],
            [
                'title'=>$val['title'],
                'details'=>$val['details'],
                'user_id'=>$val['user_id'],

            ]);
        return response()->json($created, Response::HTTP_OK);
    }

    public function destroy($id){
        $data = Todo::where('id',$id)->delete();
        return response()->json($data,Response::HTTP_OK);

    }
    public function getTodo($id){
        $data = Todo::where('id',$id)->first();
        return response()->json($data,Response::HTTP_OK);
    }
//    public function updateTodo(Request $request){
//        $val = $request->validate([
//            'title'=>'required|max:50',
//            'details'=>'max:250',
//            'user_id'=>'',
//            'id'=>''
//        ]);
//        $data = Todo::where('id',$val['id'])->update($val);
//        return response()->json($data,Response::HTTP_OK);
//    }
}
