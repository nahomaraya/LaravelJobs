<?php

namespace App\Http\Controllers;

use App\Models\Jobs;
use Illuminate\Http\Request;

class JobsController extends Controller
{
  
    public function show(Jobs $job){
        return view('jobs.show', [
            
            'job' => $job
    
        ]);
    }

    public function index(){
        return view('jobs.index', [
            
            'jobs' => Jobs::latest()->filter(request(['tag', 'search']))->paginate(3),
    
        ]);
    }
   
    public function create(){
      
        return view('jobs.create');
    }
    public function store(Request $request){
        
        $formFields = $request->validate([
            'company' => 'required',
            'title'=> 'required',
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'tags' => 'required',
           'description' => 'required',
           
        ]);
        
        
        if($request->hasFile('logo')){
            
            $formFields['logo']= $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id']=auth()->id();
        
        Jobs::create($formFields);
        return redirect('/') -> with('message', 'Job listing created successfully');
    }

    public function edit(Jobs $job){
        if($job->user_id != auth()->id()){
            abort('403', 'You aint allowed');
        }
        else{
        return view('jobs.edit',[
            
            'job' => $job
    
        ] );}
    }
    public function update(Request $request, Jobs $job){
        
       
        $formFields = $request->validate([
            'company' => 'required',
            'title'=> 'required',
            'location' => 'required',
            'email' => ['required','email'],
            'website' => 'required',
            'tags' => 'required',
           'description' => 'required',
        ]);
        // echo "Here";
        if($request->hasFile('logo')){
            
            $formFields['logo']= $request->file('logo')->store('logos', 'public');
        }
        $job->update($formFields);
        return back()->with('message', 'Job listing updated successfully');
    
    }
    public function delete(Jobs $job){
        if($job->user_id != auth()->id()){
            abort('403', 'You aint allowed');
        }
        else{
        $job->delete();
        return redirect('/')->with('message', 'Job listing deleted successfully');
        }
    }
    public function manage(){
        return view('jobs.manage',
        [
            
            'jobs' => auth()->user()->jobs()->get()
    
        ]
    );
    }
}
 
