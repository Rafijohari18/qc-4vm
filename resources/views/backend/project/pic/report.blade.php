@extends('layouts.backend')

@section('title', $data['title'])
@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.css') }}">

@endsection

@section('content')

<div class="container-fluid container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
        <span class="text-muted font-weight-light">Report Project </span>
    </h4>

    <!-- / Filters -->

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="text-lighter">Total Record : <div class="badge badge-primary">{{ $data['total'] }}</div></div>
            @can('tambah_report')
              <a href="{{ route('report.create',['id' => Request::segment('4') ]) }}" class="btn btn-outline-primary" data-toggle="tooltip" data-original-title="click to add report"><i class="las la-plus"></i> Tambah</a>
            @endcan
        
        </div>

      <div class="card-body">
         
        <div class="table-responsive table-mobile-responsive"> 
        <table class="table table-hover table-bordered table-striped sortable">
          <thead >
            <tr>
              <th width="10px">No</th>
              <th>Nama Modul</th>
              <th>Priority</th>
              <th>URL / References</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
              @if ($data['total'] == 0)
                  <tr>
                      <td colspan="6" align="center"><i><strong style="color:red;">Tidak Ada Data di Termukan !</strong></i></td>
                  </tr>
              @endif
            
              @foreach ($data['report'] as $item)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->ProjectModul->name }}</td>
                  <td>
                    @if($item->priority == 0)
                      <div class="badge badge-warning">Low/Improvement</div>
                    @elseif($item->priority == 1)
                      <div class="badge badge-secondary">Visual Error</div>
                    @elseif($item->priority == 2)
                      <div class="badge badge-success">Bug</div>
                    @elseif($item->priority == 3)
                      <div class="badge badge-primary">Error</div>
                    @else
                      <div class="badge badge-danger">Process-breaking Error</div>
                    @endif
                  </td>
                  <td>{{ $item->url }}</td>
                  <td>
                      @if($item->status == 0)
                        <div class="badge badge-dark">Pending</div>
                      @elseif($item->status == 1)
                        <div class="badge badge-info">Reissued</div>
                      @elseif($item->status == 10)
                        <div class="badge badge-primary">Handled</div>
                      @elseif($item->status == 11)
                        <div class="badge badge-warning">On Hold</div>
                      @elseif($item->status == 20)
                        <div class="badge badge-primary">Fixed</div>
                      @elseif($item->status == 21)
                        <div class="badge badge-secondary">Nothing Wrong</div>  
                      @elseif($item->status == 30)
                        <div class="badge badge-success">Solved</div>  
                      @else
                        <div class="badge badge-danger">Closed</div>
                      @endif

                  </td>
                
                  <td>
                    @can('edit_report')
                    <a href="{{ route('report.edit', ['id' => $item['id']]) }}" class="btn icon-btn btn-sm btn-warning" data-toggle="tooltip" data-original-title="klik untuk edit report"><i class="fa fa-pen"></i></a>
                    @endcan
                    @can('hapus_report')
                    
                    <a href="javascript:void(0);" class="btn icon-btn btn-sm btn-danger delete" data-toggle="tooltip" data-original-title="klik untuk hapus project"><i class="fa fa-trash-alt"></i>
                        <form action="{{ route('report.destroy', ['id' => $item['id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                      </a>
                    @endcan
                  

                  </td>
              </tr>
              @endforeach
          </tbody>

         
           
        </table>
      </div>
      </div>
      {{ $data['report']->links() }}
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
</script>
@endsection
