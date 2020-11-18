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

    <div class="card">
      <div class="card-header">
        <div class="title-heading">
              <h6 class="m-0">Create Report </h6>
        </div>
      </div>
      <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

        <input type="text" name="project_id" value="{{ Request::segment('3') }}" hidden>
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
                    <option value="{{ $project->Project->id }}">{{ $project->Project->name }}</option>
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
                      <option value="" ></option>
                  </select>
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
                     <option value="0">Low/Improvemen</option>
                     <option value="1">Visual Error</option>
                     <option value="2">Bug</option>
                     <option value="3">Error</option>
                     <option value="4">Process-breaking Error</option>
                  </select>
              </div>
            </div>
          </div>


          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">URL / References</label>
              </div>
              <div class="col-md-10">
                <input type="text" required class="form-control @error('url') is-invalid @enderror" name="url"  placeholder="enter url...">
              
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Reproduction Steps</label>
              </div>
              <div class="col-md-10">
              <textarea name="reproduction_steps" class="form-control" id="tinymce"></textarea>
              </div>
            </div>
          </div>


          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <label for="">Attachments</label>
              </div>
              <div class="col-md-10">
                
                <div id="inputFormRow"> 
                  <input type="file" name="attachments[]" class="form-control">
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
      </form>
    </div>

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
      html += ' <input type="file" name="attachments[]" class="form-control">';
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