<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Project extends Model
{
    protected $table = 'projects';
    protected $guarded = [];
    
    public function User()
    {
    	return $this->belongsToMany(User::class);
    }

    public function ProjectModul()
    {
        return $this->hasMany(ProjectModul::class, 'project_id');
    }

    public function Programmer()
    {
        return $this->hasMany(ProjectUser::class, 'project_id')->where('role', 11);
    }
    public function ProjectManager()
    {
        return $this->hasMany(ProjectUser::class, 'project_id')->where('role', 10);
    }
    public function Support()
    {
        return $this->hasMany(ProjectUser::class, 'project_id')->whereIn('role',[12,13]);
    }

    public function JenisProject()
    {
        return $this->belongsTo(JenisProject::class,'jenis_project_id');
    }

    public function listModulByUser($id)
    {
        return ProjectIssues::where('project_id',$id)->get();
    }

    public function jumlahSolved($id)
    {
        return ProjectIssues::where('project_id',$id)->whereIn('status',[30,31])->count();
    }

    public function jumlahModul($id)
    {
        return ProjectIssues::where('project_id',$id)->count();
    }
    
}
