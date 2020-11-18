@extends('layouts.backend')

@section('title', $data['title'])

@section('css')
<script src="{{ asset('assets/temp_backend/wysiwyg/tinymce.min.js') }}"></script>
@endsection

@section('content')

<div class="container-fluid flex-grow-1 container-p-y">

    <h4 class="d-flex flex-wrap justify-content-between align-items-center pt-3 mb-4">
        <ol class="breadcrumb font-weight-bold mb-3">
        <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="ion ion-ios-chatbubbles"></i></a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Report</a></li>
        <li class="breadcrumb-item active">Comment </li>
        </ol>
        
    </h4>

    <div class="card mb-4">
        <div class="card-header">
        <div class="media flex-wrap align-items-center">
           
            <div class="media-body ml-3">
            <a href="javascript:void(0)">{{ $data['report']->ProjectModul->Project->name }} - {{ $data['report']->code }}</a>
            
            </div>
          
        </div>
        </div>
        
        <div class="card-body">
            {!! $data['report']->reproduction_steps !!}
        </div>
        
        <div class="card-footer d-flex flex-wrap justify-content-between align-items-center px-0 pt-0 pb-3">

        </div>
    </div>
    

    @foreach($data['comment'] as $comment)

    <div class="card mb-3">
        <div class="card-body">
        <div class="media">
            <img src="{{ $comment->User->profile_photo_path != null ? asset('userfile/photo/'.$comment->User->profile_photo_path) : asset('assets/temp_backend/img/avatars/1.png')  }}" class="d-block ui-w-40 rounded-circle" alt>
            <div class="media-body ml-4">
            
            <a href="javascript:void(0)">{{ $comment->User->name }}</a>
            <div class="text-muted small">{{ Carbon\Carbon::parse($comment->created_at)->translatedFormat('D, d F Y')  }}</div>
            <div class="mt-2">
                {!! $comment->message !!}
            </div>
           
            </div>
        </div>
        </div>
    </div>

    @endforeach

    <div class="card">
        <div class="card-body">
            
                <form action="{{ route('report.comment.post',['issue_id' => Request::segment('2') ]) }}" method="post">
                @csrf
                   
                    <textarea name="message" class="form-control" id="tinymce"></textarea>
                   
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="ion ion-md-create"></i>&nbsp; Reply</button>
                    </div>
                   
                   
                   
                </form>
               

        </div>
    </div>
           

   

</div>

@endsection


@section('jsbody')
<script type="text/javascript">
  tinymce.init({
    selector: '#tinymce',
    height : 350
  });
</script>
@endsection


