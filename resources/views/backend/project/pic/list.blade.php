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
    @if($data['total'] == 0)
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-6 mx-auto">
                <div class="jumbotron">
                    <h3 class="text-center font-weight-bold py-3 mb-4">
                        Belum Ada Project !!
                    </h3>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        @foreach ($data['project'] as $key => $item)
            <div class="col-sm-6 col-xl-4">
                <div class="card mb-4">
                    <div class="card-body pb-0">
                    <div class="d-flex justify-content-center">
                        <div class="text-center">
                        <a href="" class="text-body text-big font-weight-semibold text-center"> Aplikasi {{ $item->Project->name }} </a>
                       
                        </div>
                        <div class="btn-group team-actions">
                            <button type="button" class="btn btn-sm btn-default icon-btn borderless rounded-pill md-btn-flat dropdown-toggle hide-arrow" data-toggle="dropdown" style="margin-left:130px;">
                                <i class="ion ion-ios-more"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                            <!-- @role('Programmer')
                                <a class="dropdown-item" href="{{ route('project.preview.programmer', ['id' => $item->Project->id ]) }}">Lihat Detail</a>
                            @endrole
                            @can('suport_preview') 
                                <a class="dropdown-item" href="{{ route('project.preview.support', ['id' => $item->Project->id ]) }}">Lihat Detail</a>
                            @endcan -->
                            @can('list_modul')
                            <a class="dropdown-item" href="{{ route('project.modul', ['id' => $item->Project->id ]) }}">Lihat Modul</a>
                            @endcan
                        
                                
                            </div>
                   
                        </div>
                    </div>
                    <hr class="m-2">
                    <div class="mt-3 text-justify">
                      {{ $item->Project->description }}
                    </div>
                    </div>
                     
                    
                    <div class="container">
                     <div class="row mt-5 mb-4" style="font-weight:bold;">
                        <div class="col-md-4 text-center">
                            {{ $item->Project->JenisProject->name }}
                        </div>
                        <div class="col-md-4 text-center">
                            {{ $item->Project->code }}
                        </div>
                        <div class="col-md-4 text-center">
                            <a data-toggle="modal" data-target="#modals-default--{{ $key }}" style="cursor:pointer;">
                                <i class="fa fa-eye"></i> View        
                            </a>                    
                        </div>
                     </div>
                     </div>
                    
                    <hr class="m-0">
                    <div class="card-body">
                    <!-- <div class="text-muted small">Current project</div> -->
                    <!-- <div class="mb-3"><a href="javascript:void(0)" class="text-body font-weight-semibold">Frontend Development</a></div> -->
                    <div class="d-flex justify-content-between align-items-center small">
                        @php
                            $jumlah_solved = $item->Project->jumlahSolved($item->Project->id);
                            $jumlah_modul  = $item->Project->jumlahModul($item->Project->id);
                            $persentase    =  $jumlah_solved == 0  ||  $jumlah_modul == 0 ?
                              0 : ($jumlah_solved / $jumlah_modul) * 100 ; 
                        @endphp
                        <div class="font-weight-bold">{{ round($persentase) }} %</div>
                        <div class="text-muted">{{ $jumlah_solved }} / {{ $jumlah_modul }} tasks completed</div>
                    </div>
                    <div class="progress mt-1" style="height: 4px;">
                        <div class="progress-bar" style="width: {{ round($persentase) }}%;"></div>
                    </div>
                    
                    </div>
                </div>
            </div>

            <!-- modal -->
            <div class="modal fade" id="modals-default--{{ $key }}">
                <div class="modal-dialog modal-lg">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                Aplikasi {{ $item->Project->name }} 
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>{{ $item->Project->description }} </p>
                                </div>
                      
                                <div class="col-md-4">
                                    Project Manager
                                        @foreach($item->Project->ProjectManager as $projectmanager)
                                            <a href="javascript:void(0)" class="d-block mr-1 mb-1">
                                                {{ $projectmanager->User->name  }},
                                            </a>
                                        @endforeach
                                </div>
                                <div class="col-md-4">
                                    Programmer
                                        @foreach($item->Project->Programmer as $programmer)
                                            <a href="javascript:void(0)" class="d-block mr-1 mb-1">
                                            {{ $programmer->User->name }},
                                            </a>
                                        @endforeach
                                </div>
                                <div class="col-md-4">
                                    Support
                                        @foreach($item->Project->Support as $support)
                                            <a href="javascript:void(0)" class="d-block mr-1 mb-1">
                                            {{ $support->User->name }},
                                            </a>
                                        @endforeach
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered table-striped sortable">
                                            <thead >
                                                <tr>
                                                <th width="10px">No</th>
                                                <th>Kode Project</th>
                                                <th>Nama Modul</th>
                                                <th>Pelapor</th>
                                                <th>Priority</th>
                                                <th>Url</th>
                                                <th>Status</th>
                                            
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($item->Project->listModulByUser($item->Project->id)->count() == 0)
                                                    <tr>
                                                        <td colspan="8" align="center"><i><strong style="color:red;">Tidak Ada Data di Termukan !</strong></i></td>
                                                    </tr>
                                                @endif
                                                
                                                @foreach($item->Project->listModulByUser($item->Project->id) as $project_issue)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->Project->code }}{{ $project_issue->code }}{{ $project_issue->code_index }}</td>
                                                    <td>{{ $project_issue->ProjectModul->name }}</td>
                                                    <td>{{ $project_issue->User->name }}</td>
                                                    <td>
                                                        @if($project_issue->priority == 0)
                                                            <div class="badge badge-warning">Low/Improvement</div>
                                                        @elseif($project_issue->priority == 1)
                                                            <div class="badge badge-secondary">Visual Error</div>
                                                        @elseif($project_issue->priority == 2)
                                                            <div class="badge badge-success">Bug</div>
                                                        @elseif($project_issue->priority == 3)
                                                            <div class="badge badge-primary">Error</div>
                                                        @else
                                                            <div class="badge badge-danger">Process-breaking Error</div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $project_issue->url }}</td>
                                                    <td>
                                                        @if($project_issue->status == 0)
                                                            <div class="badge badge-dark">Pending</div>
                                                        @elseif($project_issue->status == 1)
                                                            <div class="badge badge-info">Reissued</div>
                                                        @elseif($project_issue->status == 10)
                                                            <div class="badge badge-primary">Handled</div>
                                                        @elseif($project_issue->status == 11)
                                                            <div class="badge badge-warning">On Hold</div>
                                                        @elseif($project_issue->status == 20)
                                                            <div class="badge badge-primary">Fixed</div>
                                                        @elseif($project_issue->status == 21)
                                                            <div class="badge badge-secondary">Nothing Wrong</div>  
                                                        @elseif($project_issue->status == 30)
                                                            <div class="badge badge-success">Solved</div>  
                                                        @else
                                                            <div class="badge badge-danger">Closed</div>
                                                        @endif
                                                    </td>
                                                
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>

                        </div>
                    </form>
                </div>
                </div>
            
            <!-- end modal -->

        @endforeach
    </div>

   

</div>
<!-- / Content -->
@endsection

@section('jsfoot')
<script src="{{ asset('assets/temp_backend/bootstrap-sortable/bootstrap-sortable.js') }}"></script>

@endsection

@section('jsbody')

<script>

   
</script>
@endsection
