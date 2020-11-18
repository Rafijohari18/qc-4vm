<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\ProjectModul;
use App\Models\ProjectIssues;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ProjectService
{
    private $project;

    public function __construct(
        Project $project,
        ProjectUser $project_user,
        ProjectModul $project_modul,
        ProjectIssues $project_issues

    )
    {
        $this->project      = $project;
        $this->project_user = $project_user;
        $this->project_modul = $project_modul;
        $this->project_issues = $project_issues;
    }

    public function getProject(){
        return $this->project->paginate(15);
    }
    public function getProjectPic()
    {
        return $this->project_user->with('Project')->where('user_id',Auth::user()['id'])->paginate(10);
    }

    public function getProjectPicAll()
    {
        return $this->project_user->with('Project')->where('user_id',Auth::user()['id'])->get();
    }

    public function getReportPic()
    {
       return $this->project_issues->where('created_by',Auth::user()['id'])->paginate(10);   
    }

    public function getReportProgrammer($id)
    {
        return $this->project_issues->where('project_id',$id)->paginate(15);   
        
    }

   
    public function store($request)
    {
  
        $projects =  $this->project->create([
            'user_id'          => Auth::user()['id'],
            'name'             => $request->name,
            'code'             => $request->code,
            'description'      => $request->description,
            'jenis_project_id' => $request->jenis_project_id,
            
        ]);

        $req_pic = $request->pic;
        foreach($req_pic as $value){
            $pic =  explode('--',$value);
            
            $projects_user =  $this->project_user->create([
                'project_id'    => $projects->id,
                'user_id'       => $pic[0],
                'role'          => $pic[1],
               
            ]);

        }

    }

    public function update($request,$id)
    {
        $update_project = [
            'user_id'       => Auth::user()['id'],
            'name'          => $request->name,
            'code'          => $request->code,
            'description'   => $request->description,
            'jenis_project_id' => $request->jenis_project_id,

         ];

         $project =  $this->project::findOrFail($id);
         $project->update($update_project);

         $cek =  $this->project_user::where('project_id',$id)->get();
         if (count($cek) > 0) {
             $this->project_user::where('project_id',$id)->delete();
         }

        $req_pic = $request->pic;
  
      
        foreach($req_pic as $value){
            $pic =  explode('--',$value);
            
            $projects_user =  $this->project_user->create([
                'project_id'    => $project->id,
                'user_id'       => $pic[0],
                'role'          => $pic[1],
               
            ]);

        }

    }

    public function storeModul($request)
    {
        $this->project_modul->create([
            'project_id'    => $request->project_id,
            'name'          => $request->name,
            'code'          => $request->code,
            'description'   => $request->description,
        ]);

    }

    public function updateModul($request,$id)
    {
        $update_modul = [
            'name'          => $request->name,
            'code'          => $request->code,
            'description'   => $request->description,
         ];

         $projectModul =  $this->project_modul::findOrFail($id);
         $projectModul->update($update_modul);
    }

    
    
}