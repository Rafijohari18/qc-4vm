@extends('layouts.backend')

@section('title', $data['title'])
@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.css') }}">

@endsection

@section('content')

<div class="container-fluid container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">All Report</span>
    </h4>


    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
           
            @can('tambah_report')
              <a href="{{ route('report.create') }}" class="btn btn-outline-primary" data-toggle="tooltip" data-original-title="click to add report"><i class="las la-plus"></i> Tambah</a>
            @endcan
        </div>

      <div class="card-body">
         
        <div class="table-responsive table-mobile-responsive"> 
        <table class="table table-hover table-bordered table-striped sortable">
          <thead >
            <tr>
              <th width="10px">No</th>
              <th>Kode Project</th>
              <th>Nama Project</th>
              <th>Nama Modul</th>
              <th>Priority</th>
              <th>URL / References</th>
              <th>Status</th>
              <th>Pelapor</th>
              @can('aksi_all_report')
              <th>Aksi</th>
              @endcan
            </tr>
          </thead>
          <tbody>
              @if($data['total'] == 0)
                  <tr>
                      <td colspan="9" align="center"><i><strong style="color:red;">Tidak Ada Data di Termukan !</strong></i></td>
                  </tr>
              @endif
              
              @if(isset($data['report']))
              @foreach($data['report'] as $key => $item)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->ProjectIssues->code }}</td>
                  <td>{{ $item->ProjectModul->Project->name }}</td>
                  <td>{{ $item->ProjectModul->name }}</td>
                  <td>
                    @if($item->ProjectIssues->priority == 0)
                      <div class="badge badge-warning">Low/Improvement</div>
                    @elseif($item->ProjectIssues->priority == 1)
                      <div class="badge badge-secondary">Visual Error</div>
                    @elseif($item->ProjectIssues->priority == 2)
                      <div class="badge badge-success">Bug</div>
                    @elseif($item->ProjectIssues->priority == 3)
                      <div class="badge badge-primary">Error</div>
                    @else
                      <div class="badge badge-danger">Process-breaking Error</div>
                    @endif
                  </td>
                  <td>{{ $item->ProjectIssues->url }}</td>
                  <td>

                      @if($item->closed_at != null)
                      <div class="badge badge-danger">Closed</div>
                      @elseif($item->solved == 1)
                      <div class="badge badge-success">Solved</div>  
                      @elseif($item->ProjectIssues->status == 0)
                        <div class="badge badge-dark">Pending</div>
                      @elseif($item->ProjectIssues->status == 1)
                        <div class="badge badge-info">Reissued</div>
                      @elseif($item->ProjectIssues->status == 10)
                        <div class="badge badge-primary">Handled</div>
                      @elseif($item->ProjectIssues->status == 11)
                        <div class="badge badge-warning">On Hold</div>
                      @elseif($item->ProjectIssues->status == 20)
                        <div class="badge badge-primary">Fixed</div>
                      @elseif($item->ProjectIssues->status == 21)
                        <div class="badge badge-secondary">Nothing Wrong</div>  
                      @elseif($item->ProjectIssues->status == 30)
                        <div class="badge badge-success">Solved</div>  
                      @elseif($item->ProjectIssues->status == 31)
                        <div class="badge badge-danger">Closed</div>
                      @endif

                  </td>
                  <td>{{ $item->User->name }}  </td>
                  @can('aksi_all_report')
                    <td>  
                     
                        @if($item->ProjectIssues->status == 0 || $item->ProjectIssues->status == 1 || $item->ProjectIssues->status == 11)
                        <a href="{{ route('report.handled', ['id' => $item['id'],'issue_id' => $item['issue_id']]) }}" class="btn icon-btn btn-sm btn-success" data-toggle="tooltip" data-original-title="klik untuk ambil report">
                          <i class="fas fa-hand-paper"></i>
                        </a>

                        <a data-toggle="modal" data-target="#modalfixed" class="btn mt-1 icon-btn btn-sm btn-danger">
                          <i class="fas fa-check"></i>
                        </a>
                        
                        @elseif($item->ProjectIssues->status == 10)
                        <a  class="btn icon-btn btn-sm btn-secondary" data-toggle="tooltip" data-original-title="report telah di handle">
                          <i class="fas fa-handshake"></i>
                        </a>

                  
                        @endif

                        @if($item->ProjectIssues->cekStatus($item->id) == Auth::user()['id'] && $item->ProjectIssues->status != 11)
                        <a href="{{ route('report.hold', ['id' => $item['id'],'issue_id' => $item['issue_id']]) }}" class="btn mt-2 icon-btn btn-sm btn-info" data-toggle="tooltip" data-original-title="on hold report">
                          <i class="fas fa-hands"></i>
                        </a>
                        @endif

                        
                        
                    </td>
                    
                    
                  @endcan
                 

                    <!-- modal -->
                    <div class="modal fade" id="modalfixed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <form class="modal-content" action="{{ route('report.fixed',['id' => $item->id,'issue_id' => $item['issue_id']]) }}" method="POST">
                          @method('PUT')
                          @csrf
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Report Fixed</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="formGroupExampleInput">Handler Note</label>
                                <textarea name="handler_note" class="form-control" id="tinymce"></textarea>

                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                          </form>

                        </div>
                      </div>
                    </div>
                    <!-- end modal -->
              </tr>
              @endforeach
              @endif
          </tbody>

         
           
        </table>
      </div>
      </div>
      @if(isset($data['report']))
        {{ $data['report']->links() }}
      @endif
    </div>



</div>
<!-- / Content -->
@endsection

@section('jsfoot')
<script src="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.js') }}"></script>
<script src="https://cdn.tiny.cloud/1/hfi2umaf9u3p8olyawvd7ab6yi3g7n2mm3mpk5k6gqpxjitu/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

@endsection

@section('jsbody')

<script>

    tinymce.init({
        selector: '#tinymce',
        height : 350,
      });

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
