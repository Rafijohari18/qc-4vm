<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class ProjectIssues extends Model
{
    protected $table = 'project_issues';
    protected $guarded = [];

    public function User()
    {
    	return $this->belongsTo(User::class,'created_by');
    }

    public function ProjectModul()
    {
    	return $this->belongsTo(ProjectModul::class,'module_id');
    }

    public function ProjectIssueOccurent()
    {
    	return $this->hasMany(ProjectIssueOccurent::class,'issue_id');
    }

    public function cekStatus($id)
    {
        return ProjectIssueOccurent::where('issue_id',$id)->first()['handled_by'];
    }
    
    protected $casts = [
        'attachments' => 'array',
    ];


    


}
