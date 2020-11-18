<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectIssueOccurent extends Model
{
    protected $table = 'project_issue_occurences';
    protected $guarded = [];

    public function User()
    {
    	return $this->belongsTo(User::class,'submitted_by');
    }

    public function ProjectModul()
    {
    	return $this->belongsTo(ProjectModul::class,'module_id');
    }

    public function ProjectIssues()
    {
    	return $this->belongsTo(ProjectIssues::class,'issue_id');
    }

    protected $casts = [
        'extra_attachment' => 'array',
    ];

   


}
