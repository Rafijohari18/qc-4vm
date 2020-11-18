<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ProjectService;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\ProjectModul;
use App\Models\JenisProject;
use Spatie\Permission\Models\Role;
use Auth;
use DB;
use Image;
use Illuminate\Support\Str;
use Response;

class ProjectController extends Controller
{
    private $project;

    public function __construct(ProjectService $project)
    {
        $this->project  = $project;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Project';
        $data['project'] = $this->project->getProject();
        $data['total']  = $data['project']->count(); 
      
        return view('backend.project.index', compact('data'));
    }

    public function create()
    {
        $data['title']         = 'Create';
        $data['type']          = strtolower($data['title']);
        $data['PM']            = User::with('roles')->whereHas('roles',function($q){
                                    $q->where('id',5);
                                })->get();
        
        $data['PGM']           = User::with('roles')->whereHas('roles',function($q){
                                    $q->where('id',6);
                                })->get();

        $data['SPT']           = User::with('roles')->whereHas('roles',function($q){
                                    $q->whereIn('id', [7,8]);
                                })->get();                
                    
        $data['jenis_project'] = JenisProject::all();                
        return view('backend.project.create', compact('data'));
    }
    public function store(Request $request)
    {
        $this->project->store($request);
        return redirect('project')->with('success', 'Berhasil  Tambah Project');
        
    }

    public function edit($id)
    {
        $data['title'] = 'Edit';
        $data['type'] = strtolower($data['title']);
        $data['project'] = Project::find($id);
        $data['jenis_project'] = JenisProject::all();                
        
        $data['project_user'] = ProjectUser::with('user','Project')->where('project_id',$id)->get();
        
        if($data['project_user']->count() > 0 ){
            
            foreach($data['project_user'] as $project_user){
                $programmer      = $project_user->Project->Programmer;
                $project_manager = $project_user->Project->ProjectManager;
                $support         = $project_user->Project->Support;
            }
            
           
            foreach($project_manager as $pro_manager){
                $promanager_id[] = $pro_manager->User->id;
            }
            foreach($programmer as $program){
                $programmer_id[] = $program->User->id;
            }
            foreach($support as $supp){
                $support_id[] = $supp->User->id;
            }
            
            
            if(isset($support_id)){
                 $collectSPR = collect($support_id);
                 
                 $data['spr_id'] = $collectSPR->map(function($item2, $key2) {
                    return $item2;
                 })->all();
            }
            
            if(isset($promanager_id)){
                 $collectPM = collect($promanager_id);
                 $data['pm_id'] = $collectPM->map(function($item, $key) {
                    return $item;
                })->all();
            }
    
    
            if(isset($programmer_id )){
                $collectPGM = collect($programmer_id);
                
                $data['pgm_id'] = $collectPGM->map(function($item1, $key1) {
                    return $item1;
                 })->all();
    
            }
           
            
            

        }
       



         
         $data['PM']    = User::with('roles')->whereHas('roles',function($q){
            $q->where('id',5);
        })->get();

        $data['PGM']    = User::with('roles')->whereHas('roles',function($q){
                    $q->where('id',6);
                })->get();

        $data['SPT']    = User::with('roles')->whereHas('roles',function($q){
                    $q->whereIn('id', [7,8]);
                })->get();          

       
        return view('backend.project.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {

        $this->project->update($request,$id);
        
        return redirect('project')->with('success', 'Edit Project Berhasil');
            
       
    }

    public function destroy($id)
    {
        
        $project = Project::find($id);
        $project->delete();
        
        return back()->with('success', 'Delete Project successfully');
       
    }

    public function modul(Request $request,$id)
    {
        $data['title'] = Project::where('id',$id)->first();
        $data['modul'] = ProjectModul::where('project_id',$id)->paginate(15);
        $data['total'] = $data['modul']->count(); 

        return view('backend.project.modul', compact('data'));

    }

    public function changemodulStatus(Request $request)
    {
       
        $project_modul = ProjectModul::find($request->project_id);
        $project_modul->test_ready = $request->status;
        $project_modul->save();

        $success = true;
        $message = "Status Berhasil di Update";
              
        return Response::json(
            [
                'success' => $success,
                'message' => $message,
        ]);
  
    }

    public function createModul(Request $request)
    {
        $data['title'] = 'Create';
        $data['type'] = strtolower($data['title']);

        return view('backend.project.modul.form', compact('data'));
    }

    public function storeModul(Request $request)
    {
        $this->project->storeModul($request);

        return redirect()->route('project.modul', ['id' => $request->project_id])->with('success', 'Berhasil Tambah Modul');
    }

    public function editModul(Request $request, $id)
    {
        $data['title'] = 'Edit';
        $data['type'] = strtolower($data['title']);
        $data['modul'] = ProjectModul::find($id);
        
        return view('backend.project.modul.form', compact('data'));
    }

    public function updateModul(Request $request,$id)
    {
        $this->project->updateModul($request,$id);
        $data['project_id'] = ProjectModul::where('id',$id)->first();

        return redirect()->route('project.modul', ['id' => $data['project_id']->project_id])->with('success', 'Berhasil Tambah Modul');
    }

}
