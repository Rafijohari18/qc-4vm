@extends('layouts.backend')

@section('title', $data['title'])

@section('content')

<div class="container-fluid container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">Users Manager /</span> {{ $data['title'] }}
    </h4>



    <!-- / Filters -->

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
            <a href="{{ route('users.create') }}" class="btn btn-outline-primary" data-toggle="tooltip" data-original-title="click to add user"><i class="las la-plus"></i> Tambah</a>
        </div>

      <div class="card-body">
          <div class="box-form">
            <div class="title-heading">
              <h5>Cari User</h5>
            </div>
            <div class="row align-items-center">
                <div class="col-md-4">
                    @if (isset($_GET['r']))
                        @php
                            $selected = $_GET['r'];
                        @endphp
                    @else
                        @php
                            $selected = '';
                        @endphp
                    @endif
                    <div class="form-group">
                        <label>Roles</label>
                        <select class="form-control selectpicker show-tick dynamic_select" name="r" data-style="btn-default">
                            <option value="">Select Roles</option>
                            @foreach ($data['roles'] as $role)
                            <option value="{{ $role['name'] }}" {{ $role['name'] == $selected ? 'selected' : '' }}>{{ ucfirst($role['name']) }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-md-8">
                    <form action="" method="GET">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <label>Name or Other</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q" value="{{ Request::get('q') }}" placeholder="Search...">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary btn-block" data-toggle="tooltip" data-original-title="click to search"><i class="fa fa-search"></i></button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        <div class="table-responsive table-mobile-responsive"> 
        <table class="table table-hover">
          <thead >
            <tr>
              <th width="10px">No</th>
              <th>Name</th>
              <th>Username</th>
              <th>E-mail</th>
              <th>Roles</th>

              <th>Join</th>

              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @if ($data['total'] == 0)
                  <tr>
                      <td colspan="9" align="center"><i><strong style="color:red;">! No Record From User !</strong></i></td>
                  </tr>
              @endif
              @php
                  $no = $data['users']->firstItem();
              @endphp
              @foreach ($data['users'] as $item)
              <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $item['name'] }}</td>
                  <td>{{ $item['username'] }}</td>
                  <td><a href="mailto:{{ $item['email'] }}" target="_blank">{{ $item['email'] }}</a></td>
                  @foreach ($item->roles as $role)
                  <td>
                      <div  class="badge badge-outline-primary">{{ $role['name'] }}</div>
                  </td>
                  @endforeach


                  <td>{{ date('d F Y', strtotime($item['created_at'])) }}</td>
                 
                  <td>


                    @if ($item->id == auth()->user()->id || $item->roles[0]->id <=  auth()->user()->roles[0]->id)

                        <a href="#" class="btn icon-btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="cannot edit user"><i class="fa fa-pen"></i></a>
                        <a href="#" class="btn icon-btn btn-sm btn-danger" data-toggle="tooltip" data-original-title="cannot delete user"><i class="fa fa-trash-alt"></i></a>
                    @else
                    <a href="{{ route('users.edit', ['id' => $item['id']]) }}" class="btn icon-btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="klik untuk edit user"><i class="fa fa-pen"></i></a>
                    <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger delete" data-toggle="tooltip" data-original-title="klik untuk hapus user"><i class="fa fa-trash-alt"></i>
                        <form action="{{ route('users.destroy', ['id' => $item['id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                      </a>
                    @endif





                  </td>
              </tr>
              @endforeach
          </tbody>

         
           
        </table>
      </div>
      </div>
      {{ $data['users']->links() }}
    </div>

</div>
<!-- / Content -->
@endsection


@section('jsbody')
<script>
    $('.dynamic_select').on('change', function () {

        var url = $(this).val();
        if (url) {
            window.location = '?r='+url;
        }
        return false;
    });

    $('.dynamic_select2').on('change', function () {
        var url = $(this).val();
        if (url) {
            window.location = '?s='+url;
        }
        return false;
        //$('form').submit();
    });
</script>
<script>

    $('.delete').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: 'Hapus User ?',
        text: "Anda yakin ingin menghapus!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya!'
        }).then((result) => {
        if (result.value) {
            $(this).find('form').submit();
        }
        })
    });
</script>
@endsection
