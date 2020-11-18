@extends('layouts.backend')

@section('title', $data['title'])
@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.css') }}">

@endsection

@section('content')

<div class="container-fluid container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">List Project </span>
    </h4>



    <!-- / Filters -->

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
            <a href="{{ route('project.create') }}" class="btn btn-outline-primary" data-toggle="tooltip" data-original-title="click to add project"><i class="las la-plus"></i> Tambah</a>
        </div>

      <div class="card-body">
         
        <div class="table-responsive table-mobile-responsive"> 
        <table class="table table-hover table-bordered table-striped sortable">
          <thead >
            <tr>
              <th width="10px">No</th>
              <th>Nama Project</th>
              <th>Kode Project</th>
              <th>Jenis Project</th>
              <th>Project Manager</th>
              <th>Programmer</th>
              <th>Support</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @if ($data['total'] == 0)
                  <tr>
                      <td colspan="6" align="center"><i><strong style="color:red;">Tidak Ada Data di Termukan !</strong></i></td>
                  </tr>
              @endif
            
              @foreach ($data['project'] as $item)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->code }}</td>
                  <td>{{ $item->JenisProject->name }}</td>
                  <td>
                    @foreach($item->ProjectManager as $projectmanager)
                     {{ $projectmanager->User->name  }}
                    @endforeach
                  </td>
                  <td>
                    @foreach($item->Programmer as $programmer)
                    <ul>
                        <li>{{ $programmer->User->name }}</li>
                    </ul>
                   
                    @endforeach
                  </td>
                  <td>
                  @foreach($item->Support as $support)
                    <ul>
                        <li>{{ $support->User->name }}</li>
                    </ul> 
                    @endforeach
                  </td>
                  <td>

                    <a href="{{ route('project.edit', ['id' => $item['id']]) }}" class="btn icon-btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="klik untuk edit project"><i class="fa fa-pen"></i></a>
                    <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger delete" data-toggle="tooltip" data-original-title="klik untuk hapus project"><i class="fa fa-trash-alt"></i>
                        <form action="{{ route('project.destroy', ['id' => $item['id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                      </a>
                   





                  </td>
              </tr>
              @endforeach
          </tbody>

         
           
        </table>
      </div>
      </div>
      {{ $data['project']->links() }}
    </div>

</div>
<!-- / Content -->
@endsection

@section('jsfoot')
<script src="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.js') }}"></script>

@endsection

@section('jsbody')

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
