<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $table = 'project_user';
    protected $guarded = [];

    public function User()
    {
    	return $this->belongsTo(User::class);
    }

    public function Project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
