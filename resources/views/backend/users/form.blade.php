@extends('layouts.backend')

@section('title', $data['title'])

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Users Manager / {{ ucfirst(Request::segment(2)) }} /</span> {{ $data['title'] }} <span class="text-muted">{{ $data['type'] == 'edit' ? '#'.$data['users']['id'] : '' }}</span>
    </h4>

    <div class="card">
      <div class="card-header">
        <div class="title-heading">
              <h6 class="m-0">{{ $data['type'] == 'create' ? 'Create User' : 'User / '.$data['users']['name'].'' }}</h6>
        </div>
      </div>
      <form action="{{ $data['type'] == 'create' ? route('users.store') : route('users.update', ['id' => $data['users']['id']]) }}" method="POST">
          @csrf
          @if ($data['type'] == 'edit')
          @method('PUT')
          @endif
        <div class="card-body">
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Name</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $data['type'] == 'create' ? old('name') : old('name', $data['users']['name']) }}" placeholder="enter name...">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Username</label>
              </div>
              <div class="col-md-10">
                <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $data['type'] == 'create' ? old('username') : old('username', $data['users']['username']) }}" placeholder="enter username...">
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Email</label>
              </div>
              <div class="col-md-10">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $data['type'] == 'create' ? old('email') : old('email', $data['users']['email']) }}" placeholder="enter email...">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
         
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Roles</label>
              </div>
              <div class="col-md-10">
                  <select class="form-control selectpicker show-tick @error('roles') is-invalid @enderror" name="roles" data-style="btn-default">
                      <option value="">Select Role</option>
 
                      @foreach ($data['roles'] as $item)
                          <option value="{{ $item['name'] }}" {{ $data['type'] == 'create' ? old('roles') == $item['name'] ? 'selected' : ''  : old('roles', $data['users']['roles'][0]['name']) == $item['name'] ? 'selected' : '' }}> {{ ucfirst($item['name']) }}</option>
                      @endforeach
                  </select>
                  @error('roles')
                  <div style="color:red;">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Password</label>
              </div>
              <div class="col-md-10">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="enter password...">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label>Password Confirmation</label>
              </div>
              <div class="col-md-10">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="enter password confirmation...">
                @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
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
