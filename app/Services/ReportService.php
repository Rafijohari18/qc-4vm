<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\ProjectModul;
use App\Models\ProjectIssues;
use App\Models\ProjectIssueOccurent;
use App\Models\ProjectIssueComment;
use Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Str;
use DB;

class ReportService
{
    private $project;

    public function __construct(
        Project $project,
        ProjectUser $project_user,
        ProjectModul $project_modul,
        ProjectIssues $project_issues,
        ProjectIssueOccurent $project_issues_occurent,
        ProjectIssueComment  $project_issues_comment
    )
    {
        $this->project      = $project;
        $this->project_user = $project_user;
        $this->project_modul = $project_modul;
        $this->project_issues = $project_issues;
        $this->project_issues_occurent = $project_issues_occurent;
        $this->project_issues_comment = $project_issues_comment;
    }

    public function getProject(){
        return $this->project->paginate(15);
    }
    public function getProjectPic()
    {
        return $this->project_user->with('Project')->where('user_id',Auth::user()['id'])->paginate(10);
    }

    public function getReportPic()
    {
       return $this->project_issues->where('created_by',Auth::user()['id'])->paginate(10);   
    }
   
    public function store($request)
    {
        if ($request->attachments != null) {
         
            foreach($request->file('attachments') as $file)
            {
                $name = 'file/'.Str::slug($request->input('code')).''.time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/file/', $name);  
                $fileMove[] = $name;  
            }
      }else{
                $fileMove = NULL;
      } 
        
        $code_project =  $this->project::where('id',$request->project_id)->first()['code'];
        $code_modul   =  $this->project_modul::where('id',$request->module_id)->first()['code'];
        $code_index   =  $this->kode($request->module_id);

        $code         =  $code_project.$code_modul.$code_index;
        $projects =  $this->project_issues->create([
            'attachments'          => $fileMove,
            'project_id'           => $request->project_id,
            'module_id'            => $request->module_id,
            'created_by'           => Auth::user()['id'],
            'code'                 => $code,
            'code_index'           => $this->kode($request->module_id),
            'priority'             => $request->priority,
            'url'                  => $request->url,
            'reproduction_steps'   => $request->reproduction_steps,
            'status'               => 0

        ]);

       $this->project_issues_occurent->create([
            'project_id'    => $request->project_id,
            'module_id'     => $request->module_id,
            'issue_id'      => $projects->id,
            'submitted_by'  => Auth::user()['id'],
            'occurence'     => 1,
       ]);

       $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $request->project_id,
            'module_id'         => $request->module_id,
            'issue_id'          => $projects->id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Tambahkan Oleh '.Auth::user()['name']
       ]);

    }

    public function updateHandle($id,$issue_id)
    {
        $this->project_issues->where('id', $issue_id)->update(['status' => 10]);
        $this->project_issues_occurent::where('id', $id)->update(['handled_by' => Auth::user()['id']]);
        
        $projectOccurent = $this->project_issues_occurent::where('id',$id)->first();

        $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $projectOccurent->project_id,
            'module_id'         => $projectOccurent->module_id,
            'issue_id'          => $projectOccurent->issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Handle Oleh '.Auth::user()['name']
        ]);
    }   

    public function updateHold($id,$issue_id)
    {
        $this->project_issues->where('id', $issue_id)->update(['status' => 11]);

        $projectIssues = $this->project_issues::where('id',$id)->first();

        $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $projectIssues->project_id,
            'module_id'         => $projectIssues->module_id,
            'issue_id'          => $issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Hold Oleh '.Auth::user()['name']
        ]);

    }

    protected function kode($module_id)
    {
        $kd="";
        $query = DB::table('project_issues')->where('module_id',$module_id)
        ->select(DB::raw('MAX(RIGHT(code_index,4)) as kd_max'));

        if ($query->count()>0) {
          foreach ($query->get() as $key ) {
            $tmp = ((int)$key->kd_max)+1;
            $kd = sprintf("%04s", $tmp);
            }
        }else {
            $kd = "0001";
        }
  
        return  $kd;
  }

    public function update($request,$id)
    {
        $cek_issue = $this->project_issues_occurent::where('id', $id)->first();

        // dd($request->all());
        $fileMove = $request->attachments_dulu;
        
        if ($request->attachments != null) {
            $gambar_baru = $request->attachments;
            // $gambar_dulu = $request->attachments_dulu;
            // array_push($gambar_baru,$gambar_dulu);
            
          foreach($gambar_baru as $key => $file)
            {
                $name = 'file/'.Str::slug($request->input('code')).''.time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/file/', $name);  
                $fileMove[] = $name;  
            }
        }

    
        
      
        $update_project_issues = [
            'attachments'          => $fileMove,
            'module_id'            => $request->module_id,
            'project_id'            => $request->project_id,
            'created_by'           => Auth::user()['id'],
            'priority'             => $request->priority,
            'url'                  => $request->url,
            'reproduction_steps'   => $request->reproduction_steps,
         ];

         $projects_issues =  $this->project_issues::where('id',$cek_issue->issue_id)->first();
       
         $projects_issues->update($update_project_issues);

         $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $request->project_id,
            'module_id'         => $request->module_id,
            'issue_id'          => $cek_issue->issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Update Oleh '.Auth::user()['name']
       ]);

    }

    public function updateOccurences($request, $id)
    {

        $update_project_issues = [
            'status'  => 1,
         ];

         $projects_issues =  $this->project_issues::where('id',$id)->first();
         $projects_issues->update($update_project_issues);
       
        if ($request->extra_attachments) {
            $gambar_baru = $request->extra_attachments;
            // $gambar_dulu = $request->attachments_dulu;
            // array_push($gambar_baru,$gambar_dulu);
            
          foreach($gambar_baru as $key => $file)
            {
                $name = 'file/'.Str::slug($request->input('code')).''.time().'-'.$file->getClientOriginalName();
                $file->move(public_path().'/file/', $name);  
                $fileMove[] = $name;  
            }
        }else{
            $fileMove = NULL;
        }

        

        $status = $request->status;

        if($status == 31){
            $close = date('Y-m-d H:i:s');
        }else{
            $close = NULL;
        }

        $cek_occurence = $this->project_issues_occurent::where('issue_id',$id)
                        ->orderBy('id','DESC')->first();

        $occurence = ((int)$cek_occurence->occurence)+1;

        $this->project_issues_occurent->create([
            'project_id'        => $request->project_id,
            'module_id'         => $request->module_id,
            'issue_id'          => $id,
            'submitted_by'      => Auth::user()['id'],
            'occurence'         => $occurence,
            'extra_attachment'  => $fileMove,
            'extra_note'        => $request->extra_note,
            'closed_at'         => $close,
       ]);

       $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $request->project_id,
            'module_id'         => $request->module_id,
            'issue_id'          => $id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Reissue Oleh '.Auth::user()['name']
        ]);

        
    }


    public function fixed($request, $id,$issue_id)
    {
        $this->project_issues::where('id', $issue_id)->update(['status' => 20]);       

        $this->project_issues_occurent::where('id', $id)
        ->update(['handler_note' => $request->handler_note]);
        
        
        $projectIssues = $this->project_issues::where('id',$issue_id)->first();

        $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $projectIssues->project_id,
            'module_id'         => $projectIssues->module_id,
            'issue_id'          => $issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Fixec Oleh '.Auth::user()['name']
        ]);

    }

    public function updateJson($data,$id)
    {     

        foreach($data as $datas){
            $fileMove[] = $datas; 
        }

        $this->project_issues::where('id', $id)->update(['attachments' => $fileMove]);
    }

    public function commentPost($request,$issue_id)
    {
        $projectIssues = $this->project_issues::where('id', $issue_id)->first();

        $this->project_issues_comment->create([
            'system_message'    => 1,
            'project_id'        => $projectIssues->project_id,
            'module_id'         => $projectIssues->module_id,
            'issue_id'          => $issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => $request->message,
        ]);

    }
    
}