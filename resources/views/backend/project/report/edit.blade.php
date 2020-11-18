@extends('layouts.backend')

@section('title', $data['title'])

@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection

@section('content')
<!-- Content -->
<div class="container-fluid  container-p-y">

    <h4 class="font-weight-bold py-3 mb-4">
      <span class="text-muted font-weight-light">Report /</span> {{ $data['title'] }} 
    </h4>
    <form action="{{ route('report.update', ['id' => $data['report']['id']]) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
    <div class="card">
      <div class="card-header">
        <div class="title-heading">
              <h6 class="m-0">Create Report </h6>
        </div>
      </div>
      
        <div class="card-body">

         <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Nama Project</label>
              </div>
              <div class="col-md-10">
                <select name="project_id" id="project_id" class="form-control">
                   <option selected disabled>Pilih Project</option>
                  @foreach($data['project'] as $project)
                    <option value="{{ $project->Project->id }}" {{ $data['report']->project_id  == $project->Project->id  ? 'selected' : ''}}>{{ $project->Project->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
         </div>


         <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Nama Modul</label>
              </div>
              <div class="col-md-10">
                  <select class="form-control" name="module_id" id="module_id" required>
                     <option selected disabled>Pilih Modul</option>

                      @foreach ($data['modul'] as $modul)
                          <option value="{{ $modul['id'] }}" {{ $data['report']->module_id  == $modul->id  ? 'selected' : ''}}> {{ $modul['name'] }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
         </div>
          
        <div class="form-group">
          <div class="row">
              <div class="col-md-2">
                <label for="">Kode Report</label>
              </div>
              <div class="col-md-10">
                <input type="text" readonly required class="form-control @error('code') is-invalid @enderror" name="code" value="{{ $data['report']->ProjectIssues->code }}"  placeholder="enter code...">
              </div>
          </div>
      </div>

      

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Priority</label>
              </div>
              <div class="col-md-10">
                  <select class="form-control" name="priority" required>
                     <option selected disabled>Pilih Priority</option>
                     <option value="0" {{ $data['report']->ProjectIssues->priority  == 0  ? 'selected' : ''}} >Low/Improvemen</option>
                     <option value="1" {{ $data['report']->ProjectIssues->priority  == 1  ? 'selected' : ''}} >Visual Error</option>
                     <option value="2" {{ $data['report']->ProjectIssues->priority  == 2  ? 'selected' : ''}} >Bug</option>
                     <option value="3" {{ $data['report']->ProjectIssues->priority  == 3  ? 'selected' : ''}} >Error</option>
                     <option value="4" {{ $data['report']->ProjectIssues->priority  == 4  ? 'selected' : ''}} >Process-breaking Error</option>
                  </select>
              </div>
            </div>
          </div>


          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">URL</label>
              </div>
              <div class="col-md-10">
                <input type="text" value="{{ $data['report']->ProjectIssues->url }}"  required class="form-control @error('url') is-invalid @enderror" name="url"  placeholder="enter url...">
              
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Reproduction Steps</label>
              </div>
              <div class="col-md-10">
              <textarea name="reproduction_steps" class="form-control" id="tinymce">{{ $data['report']->ProjectIssues->reproduction_steps }}</textarea>
              </div>
            </div>
          </div>


        <div class="form-group">
          <div class="row">
              <div class="col-md-2">
                  <label for="">Attachments</label>
              </div>

              <div class="col-md-10">
              <div id="inputFormRow" class="row">
                  @if($data['report']->ProjectIssues->attachments != null)
               
                  @for($i=0; $i < count($data['report']->ProjectIssues->attachments) ; $i++)
                  @php
                  $extension = pathinfo(storage_path($data['report']->ProjectIssues->attachments[$i]), PATHINFO_EXTENSION);
                  @endphp
                  <input type="hidden" name="attachments_dulu[]" value="{{ $data['report']->ProjectIssues->attachments[$i] }}">
                  
                 
                    <div class="col-md-11">
                          @if($extension == 'jpg' || $extension == 'JPG' || $extension == 'png' || $extension == 'gif')
                          <img src="{{ asset($data['report']->ProjectIssues->attachments[$i]) }}" class="img-thumbnail mb-5 w-50">
                          @elseif($extension == 'mp4')
                          <video width='100%' height='600px' controls>
                            <source src="{{ $data['report']->ProjectIssues->attachments[$i] }}" type="video/mp4">
                          
                              Your browser does not support HTML video.
                          </video>
                          @endif

                    </div>
                    <div class="col-md-1">
                      <a href="{{ route('report.remove.photo', ['id' =>$data['report']->id, 'attachments_key' => $i]) }}" class="btn icon-btn btn-danger" onclick="return confirm('Hapus Foto ?')" data-toggle="tooltip" data-original-title="klik untuk hapus project">
                        <i class="fa fa-trash-alt"></i>
                
                      </a>
                        
                    </div>
               

                  @endfor   
                 
                  @endif     
                  </div>

                  <div id="newRow" class="mt-2"></div>
                    <button id="addRow" type="button" class="btn btn-info mt-2">
                        <i class="fa fa-plus"></i>
                    </button>
                  </div>
              </div>

            </div>
        



        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-10 ml-sm-auto">
              <button type="submit" class="btn btn-primary">Simpan</button>
        
            </div>
          </div>
        </div>
     
    </div>
    </form>
</div>
<!-- / Content -->
@endsection
@section('jsfoot')
<script src="https://cdn.tiny.cloud/1/hfi2umaf9u3p8olyawvd7ab6yi3g7n2mm3mpk5k6gqpxjitu/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script src="{{ asset('assets/temp_backend/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('assets/temp_backend/vendor/libs/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/temp_backend/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/temp_backend/js/forms_selects.js') }}"></script>


@endsection

@section('jsbody')
<script type="text/javascript">
  tinymce.init({
    selector: '#tinymce',
    height : 350
  });

  $("#addRow").click(function () {
      var i = 1;
      b = i++;
      var html = '';
      html += '<div id="inputFormRow" class="row mt-2"> ';

      html += '<div class="col-md-11">';
      html += ' <input type="file" name="attachments[]" class="form-control mb-3">';
      html += '</div>';
      html += '<div class="col-md-1">';
      html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>';
      html += '</div>';
      html += '</div>';
      $('#newRow').append(html);
      $('.total').number( true);
      $('.harga').number( true);
  
      
      return false;
    });

    $(document).on('click', '#removeRow', function () {
          $(this).parents("#inputFormRow").remove();
    });

    $('.delete').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: 'Hapus Photo ?',
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

    $('#project_id').change(function(){
    
    var cid = $(this).val();
    
    if(cid){
        $.ajax({
          type:"get",
          url:'/report/getModul/' + cid,
          success:function(res)
          {
            if(res)
            {
                $("#module_id").empty();
                $("#module_id").append('<option>Pilih Modul</option>');
                $.each(res,function(key,value){
                    $("#module_id").append('<option value="'+key+'">'+value+'</option>');
                });
                $('#module_id').selectpicker('refresh');
            }
          }

        });
      }
    });

  </script>
@endsection