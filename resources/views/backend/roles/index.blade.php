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

    <div class="card">
        <div class="card-body d-flex justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
            <div class="col-md-2"><a href="{{ route('roles.create') }}" class="btn btn-primary float-right" data-toggle="tooltip" data-original-title="click to add role"><i class="las la-plus"></i> Tambah</a></div>
        </div>
      <div class="card-header bg-dark text-white">
        <div class="row no-gutters align-items-center">
          <div class="col font-weight-bold">Name</div>
          <div class="d-none d-md-block col-6 text-muted">
            <div class="row no-gutters align-items-center text-white">
              <div class="col-3">Guard Name</div>
              <div class="col-3">Created At</div>
              <div class="col-3">Updated At</div>
              <div class="col-3">Actions</div>
            </div>
          </div>
        </div>
      </div>
      @php
          $no = $data['roles']->firstItem();
      @endphp
      @foreach ($data['roles'] as $item)
      <div class="card-body py-3">
        <div class="row no-gutters align-items-center">
          <div class="col"><a href="#" class="text-big font-weight-semibold">{{ ucfirst($item['name']) }}</a></div>
          <div class="d-none d-md-block col-6">

            <div class="row no-gutters align-items-center">
              <div class="col-3">{{ $item['guard_name'] }}</div>
              <div class="col-3">{{ date('d F Y', strtotime($item['created_at'])) }}</div>
              <div class="col-3">{{ date('d F Y', strtotime($item['updated_at'])) }}</div>
              <div class="media col-3 align-items-center">
                <div class="media-body flex-truncate ml-2">
                 
                    <a href="{{ route('roles.edit', ['id' => $item['id']]) }}" class="btn icon-btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="click to edit role"><i class="ion ion-md-create"></i></a>
                    <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger delete" data-toggle="tooltip" data-original-title="click to delete role">
                        <i class="las la-trash-alt"></i>
                        <form action="{{ route('roles.destroy', ['id' => $item['id']])}}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </a>
                    
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <hr class="m-0">
      @endforeach
      @if ($data['total'] == 0)
      <br>
      <div class="d-flex justify-content-center"><strong style="color:red;"><i>!No Record From Roles!</i></strong></div>
      @endif
      <br>
      {{ $data['roles']->links() }}
    </div>

</div>
<!-- / Content -->
@endsection

@section('jsbody')
<script>
    $('.delete').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: 'Hapus role ?',
        text: "Anda yakin ingin menghapu!",
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
