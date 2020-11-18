<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisProject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\Repository;
use Response;
use Http;


class JenisProjectController extends Controller
{

    private $model,$kambing;

    public function __construct(JenisProject $JenisProject){
        $this->model = new Repository($JenisProject);
    }
    public function index(Request $request)
    {
        $data['title']          = 'Jenis Project';
        $data['jenis_project']  = JenisProject::paginate(20);
        $data['total']          = $data['jenis_project']->count();

        return view('backend.jenis_project.index',compact('data'));
    }


       public function store(Request $request)
    {
        $this->model->create($request->only($this->model->getModel()->fillable));
        return back()->with('success','Jenis Project Berhasil di Simpan !');
    }

    public function update(Request $request, $id)
    {
        $this->model->update($request->only($this->model->getmodel()->fillable),$id);
        return back()->with('success','Jenis Project Berhasil di Update !');
    }
      public function destroy($id)
    {
        $this->model->delete($id);
        return back()->with('success','Jenis Project Berhasil di Hapus !');
    }
}
