@extends('layouts.backend')

@section('title', 'Modul '.$data['title']->name )
@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.css') }}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
@endsection

@section('content')

<div class="container-fluid container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">List Modul {{ $data['title']->name }} </span>
    </h4>



    <!-- / Filters -->

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
            <a href="{{ route('project.modul.create',['id' => Request::segment('2') ]) }}" class="btn btn-outline-primary" data-toggle="tooltip" data-original-title="click to add modul"><i class="las la-plus"></i> Tambah</a>
        </div>

      <div class="card-body">
         
        <div class="table-responsive table-mobile-responsive"> 
        <table class="table table-hover table-bordered table-striped sortable">
          <thead >
            <tr>
              <th width="10px">No</th>
              <th>Nama Modul</th>
              <th>Kode Modul</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @if ($data['total'] == 0)
                  <tr>
                      <td colspan="5" align="center"><i><strong style="color:red;">Tidak Ada Data di Termukan !</strong></i></td>
                  </tr>
              @endif
            
              @foreach ($data['modul'] as $item)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->code }}</td>
                  <td>
                    <input data-id="{{ $item->id }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->test_ready ? 'checked' : '' }}>
                  </td>
                  
                  <td>

                    <a href="{{ route('project.modul.edit', ['id' => $item['id']]) }}" class="btn icon-btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="klik untuk edit modul"><i class="fa fa-pen"></i></a>
                    <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger delete" data-toggle="tooltip" data-original-title="klik untuk hapus modul"><i class="fa fa-trash-alt"></i>
                        <form action="{{ route('project.modul.destroy', ['id' => $item['id']]) }}" method="POST">
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
      {{ $data['modul']->links() }}
    </div>

</div>
<!-- / Content -->
@endsection

@section('jsfoot')
<script src="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
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


    $(function() {
    $('.toggle-class').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var project_id = $(this).data('id'); 
         
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/project/change/modul/status',
            data: {'status': status, 'project_id': project_id},
            success: function(data){
                if (data.success === true) {
                    swal("Sukses!", data.message, "success");
                }
            }
        });
    })
  })
</script>
@endsection
