<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ReportService;
use App\Services\ProjectService;
use App\Models\Project;
use App\Models\ProjectIssueOccurent;
use App\Models\ProjectIssueComment;
use App\Models\ProjectUser;
use App\Models\ProjectIssues;
use App\Models\User;
use App\Models\ProjectModul;
use Auth;
use DB;
use Response;
use File;

class ReportController extends Controller
{
    private $report,$project;

    public function __construct(ReportService $report,ProjectService $project,ProjectIssueComment $project_issues_comment)
    {
        $this->report                  = $report;
        $this->project                 = $project;
        $this->project_issues_comment  = $project_issues_comment;
    }

    public function create(Request $request)
    {
        $data['title']    = 'Create';
        $data['type']     = strtolower($data['title']);
        $data['project']  = ProjectUser::with('Project')->where('user_id',Auth::user()['id'])->get();
        
        return view('backend.project.report.create', compact('data'));
    }

    public function store(Request $request)
    {
        $this->report->store($request);

        return redirect()->route('my.report')->with('success', 'Berhasil Tambah Report');
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit';
        $data['type'] = strtolower($data['title']);
        $data['report'] = ProjectIssueOccurent::find($id);
        $data['modul']  =  ProjectModul::where('project_id',$data['report']->project_id)->get();
        $data['project']  = ProjectUser::with('Project')->where('user_id',Auth::user()['id'])->get();

        return view('backend.project.report.edit', compact('data'));
    }

    public function reissue($id,$issue_id)
    {
        $data['title']                  = 'Reissue';
        $data['type']                   = strtolower($data['title']);
        $data['report']                 = ProjectIssues::where('id',$issue_id)->first();
        $data['modul']                  =  ProjectModul::where('project_id',$data['report']->project_id)->get();
        $data['project']                = ProjectUser::with('Project')->where('user_id',Auth::user()['id'])->get();
        
        return view('backend.project.report.reissue', compact('data'));
    }

    public function update(Request $request,$id)
    {
       
        $this->report->update($request,$id);
        $data['project_id'] = ProjectIssueOccurent::where('id',$id)->first();

        return redirect()->route('my.report')->with('success', 'Berhasil Update Report');
    }

    public function updateOccurences(Request $request, $id)
    {
        $this->report->updateOccurences($request,$id);
        return redirect()->route('all.report')->with('success', 'Berhasil Update Report');


    }

    public function destroy($id, $issue_id)
    {
        $project_issues_occurent = ProjectIssueOccurent::where('id',$id)->first();
        if($project_issues_occurent->extra_attachments){
            foreach($project_issues_occurent->extra_attachments as $attachments){
                File::delete($attachments);
             }
        }

        ProjectIssueOccurent::where('id',$id)->delete();

        $cek_project_issue_occurent = ProjectIssueOccurent::where('issue_id',$id)->first();

        if($cek_project_issue_occurent == null){
            $project_issues = ProjectIssues::where('id',$issue_id)->first();
            if($project_issues->attachments){
                foreach($project_issues->attachments as $gambar){
                    File::delete($gambar);
                 }
            }
            
            ProjectIssues::where('id',$issue_id)->delete();

        }

        
       
         
        return back()->with('success','Report di Hapus !');
    }
    
    public function removePhoto(Request $request,$id, $attachments_key)
    {
      
        $project_issues = ProjectIssues::where('id',$id)->first();
        
        File::delete($project_issues->attachments[$attachments_key]);
        
        $data = $project_issues->attachments;
        unset($data[$attachments_key]);
        
        $update = $this->report->updateJson($data, $id);
       
        return back()->with('success','Photo di Hapus !');
    }
    
    public function all(Request $request)
    {
        $data['title']          = 'All Report';
        $data['project_user']   = $this->project->getProjectPicAll();
        foreach($data['project_user'] as $project_user){
            $id_project[] = $project_user->project_id; 
        }
        
        $data['report']         = ProjectIssueOccurent::whereIn('project_id',[$id_project])->paginate(20);
        
        $data['total']          = $data['report']->count();

        return view('backend.report.all', compact('data'));

    }

    public function myreport(Request $request)
    {
        $data['title']  = 'My Report';
        $data['report'] = ProjectIssueOccurent::where('submitted_by',Auth::user()['id'])->paginate(20);
        $data['total']  = $data['report']->count();

        return view('backend.report.myreport', compact('data'));
    }

    public function comment($id)
    {
        $data['title']  = 'Comment Report';
        $data['report'] = ProjectIssues::find($id);
        $data['comment'] = $this->project_issues_comment::where('issue_id',$id)->get();
    

        return view('backend.report.comment', compact('data'));
        
    }

    public function commentPost(Request $request, $issue_id)
    {
        $this->report->commentPost($request,$issue_id);
        return redirect()->route('my.report')->with('success','Report Berhasil di Reply !');
    }

    public function updateHandle($id,$issue_id)
    {
        $this->report->updateHandle($id);
        return back()->with('success','Report Berhasil di Handle !');
        
    }

    public function updateHold($id,$issue_id)
    {
        $this->report->updateHold($id);
        return back()->with('success','Report Berhasil di Hold !');
        
    }

    public function fixed(Request $request , $id,$issue_id)
    {
        $this->report->fixed($request,$id,$issue_id);
        return back()->with('success','Report Berhasil di Hold !');
    }

    public function getModul($id)
    {
    
        $modul = DB::table("project_modules")
                    ->where("project_id",$id)
                    ->where("test_ready",1)
                    ->pluck("name","id");
        return response()->json($modul);
    }

    public function close($id, $issue_id)
    {
        $projectOccurent = ProjectIssueOccurent::where('id',$id)->first();

        ProjectIssues::where('id',$issue_id)->update(['status' => 31]);
        ProjectIssueOccurent::where('id',$id)->update(['closed_at' => date('Y-m-d H:i:s')]);

        $projectOccurent = ProjectIssueOccurent::where('id',$id)->first();

        $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $projectOccurent->project_id,
            'module_id'         => $projectOccurent->module_id,
            'issue_id'          => $projectOccurent->issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Close Oleh '.Auth::user()['name']
        ]);
        
        return back()->with('success','Report Berhasil di Tutup !');

    }

    public function solved($id,$issue_id)
    {
        ProjectIssues::where('id',$issue_id)->update(['status' => 30]);
        ProjectIssueOccurent::where('id',$id)->update(['solved' => 1]);


        $projectOccurent = ProjectIssueOccurent::where('id',$id)->first();

        $this->project_issues_comment->create([
            'system_message'    => 0,
            'project_id'        => $projectOccurent->project_id,
            'module_id'         => $projectOccurent->module_id,
            'issue_id'          => $projectOccurent->issue_id,
            'user_id'           => Auth::user()['id'],
            'message'           => 'Report di Close Oleh '.Auth::user()['name']
        ]);
        
        return back()->with('success','Report Berhasil di Solved !');
    }

}
