@extends('layouts.backend')

@section('title', $data['title'])
@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.css') }}">

@endsection

@section('content')

<div class="container-fluid container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">Jenis Project </span>
    </h4>

    <!-- / Filters -->

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
           
              <a  class="btn btn-outline-primary add" data-toggle="modal" data-target="#modalcreate"><i class="las la-plus"></i> Tambah</a>
         
        
        </div>

      <div class="card-body">
         
        <div class="table-responsive table-mobile-responsive"> 
        <table class="table table-hover table-bordered table-striped sortable">
          <thead >
            <tr>
              <th width="10px">No</th>
              <th>Jenis Project</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @if ($data['total'] == 0)
                  <tr>
                      <td colspan="6" align="center"><i><strong style="color:red;">Tidak Ada Data di Termukan !</strong></i></td>
                  </tr>
              @endif
            
              @foreach ($data['jenis_project'] as $item)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name }}</td>
                  <td>
                  
                    <a  class="btn icon-btn btn-sm btn-warning editbtn" data-toggle="modal" data-target="#modaledit" onclick="editdata({{ $item->id }})" data-name="{{ $item->name }}" >
                        <i class="fa fa-pen"></i>
                    </a>
                  
                    <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger delete" data-toggle="tooltip" data-original-title="klik untuk hapus project"><i class="fa fa-trash-alt"></i>
                        <form action="{{ route('jenis.project.destroy', ['id' => $item['id']]) }}" method="POST">
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
      {{ $data['jenis_project']->links() }}
    </div>


    <!-- modal edit -->
    <div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <div class="title-heading">
                <h6 class="m-0">Jenis Project Edit</h6>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span><i class="las la-times"></i></span>
            </button>
            </div>
            <form action="" method="POST" id="editform" >
            @csrf
            @method('PUT')
            <div class="modal-body">

            <div class="form-group">
                <label for="name">Jenis Project</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="" required>
            
            </div>

            <div class="form-group">
                <label for="name">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder=""></textarea>

            </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <!-- end modal edit -->

    <!-- modal create -->
    <div class="modal fade" id="modalcreate" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <div class="title-heading">
                <h6 class="m-0">Tambah Jenis Project</h6>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span><i class="las la-times"></i></span>
                </button>
            </div>
            <form action="{{ Route('jenis.project.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="modal-body scroll">
                <div class="container-fluid">
                    <div class="form-group">
                        <label for="name">Jenis Project</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            </div>
        </div>
        </div>
    <!-- end modal -->

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
        title: 'Hapus Report ?',
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

    function editdata(id)
    {
        var id = id;
        var url = '{{ route("jenis.project.update", ":id") }}';
        url = url.replace(':id', id);
        $("#editform").attr('action', url);
    }

    function editSubmit()
    {
        $("#editform").submit();
    }

    $('.editbtn').click(function(){
        var name = $(this).data('name');

        $('.modal-body #name').val(name);
    });


  $('.add').click(function(){
    $('.modal-body #name').val('');
  });

</script>
@endsection
