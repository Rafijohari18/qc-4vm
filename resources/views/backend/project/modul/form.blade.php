@extends('layouts.backend')

@section('title', $data['title'])

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Modul /</span> {{ $data['title'] }} <span class="text-muted">{{ $data['type'] == 'edit' ? '#'.$data['modul']['id'] : '' }}</span>
    </h4>

    <div class="card">
      <div class="card-header">
        <div class="title-heading">
              <h6 class="m-0">{{ $data['type'] == 'create' ? 'Create Modul' : 'Modul / '.$data['modul']['name'].'' }}</h6>
        </div>
      </div>
      <form action="{{ $data['type'] == 'create' ? route('project.modul.store') : route('project.modul.update', ['id' => $data['modul']['id']]) }}" method="POST">
          @csrf
          @if ($data['type'] == 'edit')
          @method('PUT')
          @endif

        @if ($data['type'] == 'create')
        <input type="text" name="project_id" value="{{ Request::segment('4') }}" hidden>
       
        @endif
        <div class="card-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Nama Modul</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" name="name" value="{{ $data['type'] == 'create' ? old('name') : old('name', $data['modul']['name']) }}" placeholder="enter name...">
              
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Kode Modul</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control" name="code" value="{{ $data['type'] == 'create' ? old('code') : old('code', $data['modul']['code']) }}" placeholder="enter username...">
               
              </div>
            </div>
          </div>
         
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Deskripsi</label>
              </div>
              <div class="col-md-10">
                <textarea name="description" class="form-control">{{ $data['type'] == 'create' ? old('description') : old('description', $data['modul']['description']) }}</textarea>
              </div>
            </div>
          </div>

        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-10 ml-sm-auto">
              <button type="submit" class="btn btn-primary">{{ $data['type'] == 'create' ? 'Simpan' : 'Simpan Perubahan' }}</button>
              <a href="{{ route('users.index') }}" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>

</div>
<!-- / Content -->
@endsection
