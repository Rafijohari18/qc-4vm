<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\ProjectService;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Auth;
use DB;
use Image;
use Illuminate\Support\Str;

class ListProjectController extends Controller
{
    private $project;

    public function __construct(ProjectService $project)
    {
        $this->project  = $project;
    }

    public function index(Request $request)
    {
        $data['title'] = 'Project';
        $data['project'] = $this->project->getProjectPic();
        $data['total']  = $data['project']->count(); 
      
        return view('backend.project.pic.list', compact('data'));
    }

    public function prevSuport(Request $request, $id)
    {
        $data['title'] = 'Report';
        $data['report'] = $this->project->getReportPic();
        $data['total']  = $data['report']->count(); 

        return view('backend.project.pic.report',compact('data'));
    }

    public function prevProgrammer(Request $request, $id)
    {
        $data['title'] = 'Report';
        $data['report'] = $this->project->getReportProgrammer($id);
        $data['total']  = $data['report']->count(); 

        return view('backend.project.pic.report',compact('data'));
    }


    
}
