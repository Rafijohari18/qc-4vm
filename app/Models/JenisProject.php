<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisProject extends Model
{
    protected $table = 'jenis_project';
    protected $guarded = [];

    public function Project()
    {
    	return $this->hasMany(Project::class,'jenis_project_id');
    }

}
