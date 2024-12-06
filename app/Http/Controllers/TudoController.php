<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
class TudoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       if($request->status){
        $task=Task::where('status',$request->status)->paginate(10);

       }else{
        $task=Task::paginate(10);

       }

        return view('dashboard',['tasks'=>$task]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('tudo-form');  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
        'title'=>'required',
        'description'=>'required',
        'due_date'=>'required',
        'status'=>'required',
      ]) ;

      $Task= new Task();
      $Task->title=$request->title;
      $Task->description=$request->description;
      $Task->due_date=$request->due_date;
      $Task->status=$request->status;

      if($Task->save()){
        return redirect('todos')->with('success', 'Task created.');


      }else{
        return redirect()->back()->with('error', 'Please Try Again.');

      }
     

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $showTask = Task::where('id',$id)->first(); 

        return view('update-tudo',['tasks'=>$showTask]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'due_date'=>'required',
            'status'=>'required',
          ]) ;
    
          $Task= Task::where('id',$id)->first();
          $Task->title=$request->title;
          $Task->description=$request->description;
          $Task->due_date=$request->due_date;
          $Task->status=$request->status;
    
          if($Task->save()){
            return redirect('todos')->with('success', 'Task updated.');
    
          }else{
            return redirect()->back()->with('error', 'Please Try Again.');
    
          }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $deleteTask = Task::find($id); 

        // Check if the task exists
        if ($deleteTask) {
            $deleteTask->delete();
            return redirect()->back()->with('success', 'Task deleted.');
        } else {
            return redirect()->back()->with('error', 'Task not found.');
        }
    }
}
