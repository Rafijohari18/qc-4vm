@extends('layouts.backend')

@section('title', $data['title'])

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Users Manager / {{ ucfirst(Request::segment(2)) }} /</span> {{ $data['title'] }} <span class="text-muted">{{ $data['type'] == 'edit' ? '#'.$data['permission']['id'] : '' }}</span>
    </h4>

    <div class="card">
      <h6 class="card-header">
        <i class="fas fa-{{ $data['type'] == 'create' ? 'plus' : 'edit' }}"></i> {{ $data['type'] == 'create' ? 'Permission' : 'Permission / '.$data['permission']['name'].'' }}
      </h6>
       <div class="card-body">
        <form action="{{ $data['type'] == 'create' ? route('permission.store') : route('permission.update', ['id' => $data['permission']['id']]) }}" method="POST">
            @csrf
            @if ($data['type'] == 'edit')
            @method('PUT')
            @endif
          <div class="form-group row">
            <label class="col-form-label col-sm-2 text-sm-left">Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data['type'] == 'create' ? old('name') : old('name', $data['permission']['name']) }}" placeholder="enter name...">
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="form-group row">
            <label class="col-form-label col-sm-2 text-sm-left">Guard Name</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" value="web" readonly>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-10 ml-sm-auto">
              <button type="submit" class="btn btn-primary">{{ $data['type'] == 'create' ? 'Save' : 'Save changes' }}</button>
              <a href="{{ route('permission.index') }}" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>

</div>
<!-- / Content -->
@endsection
