@extends('layouts.backend')

@section('title', $data['title'])

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">Users Manager /</span> {{ $data['title'] }}
    </h4>

    <!-- Filters -->
    <div class="ui-bordered px-4 pt-4 mb-4">
        <div class="form-row align-items-center">
        <div class="col-md mb-4">
        <form action="" method="GET">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Search...">
        </div>
        <div class="col-md col-xl-2 mb-4">
            <label class="form-label d-none d-md-block">&nbsp;</label>
            <button type="submit" class="btn btn-secondary btn-block" data-toggle="tooltip" data-original-title="click to search"><i class="fas fa-search"></i></button>
        </form>
        </div>
        </div>
    </div>
    <!-- / Filters -->

    <div class="d-flex justify-content-between">
        <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
        <div class="col-md-2"><a href="{{ route('role-has-permission.create') }}" class="btn btn-info float-right" data-toggle="tooltip" data-original-title="click to add role has permission"><i class="fas fa-plus"></i> Create</a></div>
    </div>
    <br>

    @php
        $no = $data['role_has_permission']->firstItem();
    @endphp
    @foreach ($data['role_has_permission'] as $item)
    <div id="accordion">
        <div class="card mb-2">
            <div class="card-header">
                <a class="text-body" data-toggle="collapse" href="#accordion-{{ $item['id'] }}">
                    <i class="fas fa-user-secret"></i> <strong>{{ ucfirst($item['name']) }}</strong>
                </a>
                <hr class="border-light m-0">
                <br>
                <a href="{{ route('role-has-permission.edit', ['id' => $item['id']]) }}" class="btn icon-btn btn-sm btn-warning " data-toggle="tooltip" data-original-title="click to edit role has permission"><i class="ion ion-md-create"></i></a>
                <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="click to delete role has permission">
                    <i class="las la-trash-alt"></i>
                    <form action="{{ route('role-has-permission.destroy', ['id' => $item['id']])}}" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </a>
                                                        </div>
            <div id="accordion-{{ $item['id'] }}" class="collapse" data-parent="#accordion">
                <div class="card-body">
                    <hr class="border-light m-0">
                    <div class="table-responsive">
                    <table class="table card-table m-0">
                        <tbody>
                        <tr>
                            <th>Module</th>
                            <th>Permission</th>
                        </tr>
                        @foreach ($item->permissions as $value)
                        <tr>
                            <td>{{ strtoupper($value['name']) }}</td>
                            <td><span class="ion ion-md-checkmark text-primary"></span></td>
                        </tr>
                        @endforeach
                        @if (count($item->permissions) == 0)
                        <tr>
                            <td><div class="badge badge-danger"><i>Not permission</i></div></td>
                            <td><span class="ion ion-md-close text-light"></span></td>
                        </tr>
                        @endif
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @if ($data['total'] == 0 OR $data['total'] == 20)
    <div class="card">
        <div class="card-body">
            {{ $data['role_has_permission']->links('vendor.pagination.bootstrap-4') }}
            @if ($data['total'] == 0)
            <div class="d-flex justify-content-center"><strong style="color:red;"><i>!No Record From Role Has Permission!</i></strong></div>
            @endif
        </div>
    </div>
    @endif

</div>
<!-- / Content -->
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/css/pages/users.css') }}">
@endsection

@section('jsbody')
<script>
    $('.delete').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: 'Are you sure delete this role has permission ?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.value) {
            $(this).find('form').submit();
        }
        })
    });
</script>
@endsection
