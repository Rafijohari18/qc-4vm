@extends('layouts.backend')

@section('title', $data['title'])

@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Project /</span> {{ $data['title'] }} 
    </h4>

    <div class="card">
      <div class="card-header">
        <div class="title-heading">
              <h6 class="m-0">Create Project </h6>
        </div>
      </div>
      <form action="{{ route('project.store') }}" method="POST">
          @csrf
        <div class="card-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Nama Project</label>
              </div>
              <div class="col-md-10">
                <input type="text" required class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="enter name...">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Kode Project</label>
              </div>
              <div class="col-md-10">
                <input type="text" required class="form-control @error('code') is-invalid @enderror" name="code"  placeholder="enter code...">
                @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Jenis Project</label>
              </div>
              
                <div class="col-md-10">
                
                <select class="form-control" name="jenis_project_id" required>
                    <optgroup label="Select Jenis Project">
                        @foreach ($data['jenis_project'] as $jenis_project)
                            <option value="{{ $jenis_project['id'] }}"> {{ ucfirst($jenis_project['name']) }}</option>
                        @endforeach
                    </optgroup>
                  
                </select>
               

                    
                </div>

            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Project Manager</label>
              </div>
              
                <div class="col-md-10">
                
                <select class="select2-demo form-control" name="pic[]" multiple required>
                    <optgroup label="Select Project Manager">
                        @foreach ($data['PM'] as $pm)
                            <option value="{{ $pm['id'] }}--{{ 10 }}"> {{ ucfirst($pm['name']) }}</option>
                        @endforeach
                    </optgroup>
                  
                </select>
               

                    
                </div>

            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Programmer</label>
              </div>
                <div class="col-md-10">
                    <select class="select2-demo form-control" name="pic[]" multiple style="width: 100%" required>
                        <optgroup label="Select Programmer"> 
                        @foreach ($data['PGM'] as $pgm)
                            <option value="{{ $pgm['id'] }}--{{ 11 }}"> {{ ucfirst($pgm['name']) }}</option>
                        @endforeach
                    </optgroup>

                    </select>
                    
                </div>

            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Support</label>
              </div>
                <div class="col-md-10">
                    <select class="select2-demo form-control" name="pic[]" multiple style="width: 100%" required>
                        <optgroup label="Select Support">
                        @foreach ($data['SPT'] as $spt)
                      
                            <option value="{{ $spt['id'] }}--{{ $spt->roles[0]->id }}"> {{ ucfirst($spt['name']) }}</option>
                        @endforeach
                        </optgroup>
                    </select>
                   

                    
                </div>

            </div>
          </div>


          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Deskripsi</label>
              </div>
              <div class="col-md-10">
              <textarea name="description" class="form-control"></textarea>
              </div>
            </div>
          </div>
        

        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-10 ml-sm-auto">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ route('project.index') }}" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </div>
      </form>
    </div>

</div>
<!-- / Content -->
@endsection
@section('jsfoot')

<script src="{{ asset('assets/temp_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/temp_backend/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/temp_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/temp_backend/js/forms_selects.js') }}"></script>
@endsection