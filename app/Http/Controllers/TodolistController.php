<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use Illuminate\Support\Facades\DB;
use DateTime;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\TodoMailer;

class TodolistController extends Controller
{
    public function index(Request $request) {
        $skip = $request->page*$request->size;
        if($request->title){
            $count = Todolist::whereRaw("name like '%".$request->title."%'")->count();
            $todolists = Todolist::whereRaw("name like '%".$request->title."%'")->orderBy("todo_at", "desc")->skip($skip)->take($request->size)->get();
        }else{
            $count = Todolist::orderBy("todo_at", "desc")->count();
            $todolists = Todolist::orderBy("todo_at", "desc")->skip($skip)->take($request->size)->get();
        }
        return response()->json(['count' => $count, 'data' => $todolists]);
    }
    public function store(Request $request) {
        $in_todo_at = new DateTime($request->todo_at);
        $todolist = new Todolist([
            'name' => $request->title, 
            'detail' => $request->description, 
            'todo_at' => $in_todo_at->format('Y-m-d H:i:s'),
            'is_finish' => 0,
            'is_finish_at' => null,
            'is_notified' => 0
        ]);
        $todolist->save();
        return response()->json('todolist created!');
    }
    public function show($id) {
        $todolist = Todolist::find($id);
        return response()->json($todolist);
    }
    public function update($id, Request $request) {
        $in_todo_at = new DateTime($request->todo_at);
        $in_updated_at = new DateTime($request->updated_at);
        $request->todo_at = $in_todo_at->format('Y-m-d H:i:s');
        $request->updated_at = $in_updated_at->format('Y-m-d H:i:s');
        DB::table('todolists')
            ->where('_id', $id)
            ->update([
                'name' => $request->name,
                'detail' => $request->detail,
                'todo_at' => $request->todo_at,
                'updated_at' => $request->updated_at,
            ])
            ;
        return response()->json('todolist updated!');
    }
    public function destroy($id = null) {
        if($id){
            $todolist = Todolist::find($id)->delete();
        }else{
            $todolist = Todolist::truncate();
        }
        return response()->json('todolist deleted!');
    }
     
    public function gettodo() {
        $todolists = Todolist::where('is_finish', '=', 0)
            ->whereDate('todo_at', '>=', Carbon::now())
            ->orderBy("todo_at", "desc")
            ->get();
        return response()->json($todolists);
    }
    public function gettodopast() {
        $todolists = Todolist::where('is_finish', '=', 0)
            ->whereDate('todo_at', '<', Carbon::now())
            ->orderBy("todo_at", "desc")
            ->get();
        return response()->json($todolists);
    }
    public function gettodofinish() {
        $todolists = Todolist::where('is_finish', '=', 1)
            ->orderBy("is_finish_at", "desc")
            ->get();
        return response()->json($todolists);
    }
    public function finish(Request $request) {
        DB::table('todolists')
            ->where('_id', $request->_id)
            ->update([
                'is_finish' => 1,
                'is_finish_at' => date('Y-m-d H:i:s')
            ])
        ;
        return response()->json('todolist updated!');
    }
}
