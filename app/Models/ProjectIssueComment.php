<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectIssueComment extends Model
{
    protected $table = 'project_issue_comments';
    protected $guarded = [];

    public function User()
    {
    	return $this->belongsTo(User::class,'user_id');
    }

    public function ProjectModul()
    {
    	return $this->belongsTo(ProjectModul::class,'module_id');
    }

    public function ProjectIssues()
    {
    	return $this->belongsTo(ProjectIssues::class,'issue_id');
    }

    

    

   


}
