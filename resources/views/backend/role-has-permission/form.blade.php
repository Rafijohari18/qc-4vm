@extends('layouts.backend')

@section('title', $data['title'])

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Users Manager / Role Has Pemission /</span> {{ $data['title'] }} <span class="text-muted">{{ $data['type'] == 'edit' ? '#'.$data['roles']['id'] : '' }}</span>
    </h4>

    <div class="card">
      <h6 class="card-header">
        <i class="fas fa-{{ $data['type'] == 'create' ? 'plus' : 'edit' }}"></i> {{ $data['type'] == 'create' ? 'Role Has Permission' : 'Role Has Permission / '.$data['roles']['name'].'' }}
      </h6>
       <div class="card-body">
        <form action="{{ $data['type'] == 'create' ? route('role-has-permission.store') : route('role-has-permission.update', ['id' => $data['roles']['id']]) }}" method="POST">
            @csrf
            @if ($data['type'] == 'edit')
            @method('PUT')
            @endif
          <div class="form-group row">
            <label class="col-form-label col-sm-2 text-sm-left">Roles</label>
            <div class="col-sm-12">
                <select class="selectpicker show-tick @error('roles') is-invalid @enderror" name="role_id" data-style="btn-default">
                    <option value="">Select Role</option>
                    @if ($data['type'] == 'create')
                    @foreach ($data['roles'] as $item)
                        <option value="{{ $item['id'] }}"> {{ $item['name'] }}</option>
                    @endforeach
                    @else
                    <option value="{{ $data['roles']['id'] }}" selected> {{ $data['roles']['name'] }}</option>
                    @endif
                </select>
                @error('role_id')
                <div style="color:red;">{{ $message }}</div>
                @enderror
                </div>
          </div>
          <div class="form-group row">
          <hr class="border-light m-0">
            <div class="table-responsive">
            <table class="table card-table m-0">
              <tbody>
                <tr>
                    <th>Module</th>
                    <th>Permission</th>
                </tr>
                @foreach ($data['permission'] as $item)
                <tr>
                    <td>{{ strtoupper($item['name']) }}</td>
                    <td>
                    <label class="custom-control custom-checkbox px-2 m-0">
                        <input type="checkbox" class="custom-control-input" name="permission[]" value="{{ $item['name'] }}" {{ $data['type'] == 'edit' ? in_array($item['id'], $data['permission_id']) ? 'checked' : '' : '' }}>
                        <span class="custom-control-label"></span>
                    </label>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
          </div>

          <div class="form-group row">
            <div class="          col-sm-10 ml-sm-auto">
              <button type="submit" class="btn btn-primary">{{ $data['type'] == 'create' ? 'Save' : 'Save changes' }}</button>
              <a href="{{ route('role-has-permission.index') }}" class="btn btn-default">Cancel</a>
            </div>
          </div>
        </form>
      </div>
    </div>

</div>
<!-- / Content -->
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
@endsection

@section('jsfoot')
<script src="{{ asset('assets/temp_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
@endsection
