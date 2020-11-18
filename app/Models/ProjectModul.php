<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModul extends Model
{
    protected $table = 'project_modules';
    protected $guarded = [];


    public function Project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function ProjectIssues()
    {
        return $this->hasMany(ProjectIssues::class, 'module_id');
    }
}
