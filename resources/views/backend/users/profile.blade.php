@extends('layouts.backend')

@section('title', $data['title'])

@section('content')
<!-- Content -->

<div class="container-fluid  container-p-y">
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

   
  <h4 class="font-weight-bold py-3 mb-4">
    <span class="text-muted font-weight-light">Pengaturan Akun /</span> {{ Auth::user()['name'] }}
  </h4>

  <div class="card overflow-hidden">
    <div class="row no-gutters row-bordered row-border-light">
      <div class="col-md-3 pt-0">
        <div class="list-group list-group-flush account-settings-links">
          <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Umum</a>
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Ganti Kata Sandi</a>
          @if(Auth::user()['level'] == 5 || Auth::user()['level'] == 6)
          <a class="list-group-item list-group-item-action" data-toggle="list" href="#alamat">Alamat</a>
          @endif
        </div>
      </div>
      <div class="col-md-9">
        <form action="{{ route('users.update-profile', ['id' => Auth::user()['id']]) }}" method="POST">
          @csrf
          @method('PUT')
        <div class="tab-content">
          <div class="tab-pane fade show active" id="account-general">

            <div class="card-body media align-items-center">
              <img src="{{ Auth::user()['profile_photo_path'] != null ? asset('userfile/photo/'.Auth::user()['profile_photo_path']) : asset('assets/temp_backend/img/avatars/1.png')  }}" alt class="d-block ui-w-80">
            
              <div class="media-body ml-4 mb-1">
                <a class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="#modals-default">
                  Ganti Foto Profil
                </a> &nbsp;
                @if (Auth::user()['avatar'] != null)
                <a href="javascript:void(0);" class="btn btn-outline-danger md-btn-flat delete"> Hapus
                <form action="{{ route('users.remove-photo', ['id' => Auth::user()['id']]) }}" method="POST">
                  @csrf
                  @method('PUT')
                </form>
                </a>
                @endif
                <div class="text-light small mt-1"></div>
              </div>
            </div>
            <hr class="border-light m-0">
            </form>


            <form action="{{ route('users.update-profile', ['id' => Auth::user()['id']]) }}" method="POST">
            @csrf
            <div class="card-body">

              <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control mb-1 @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::user()['name']) }}" placeholder="your name...">
                @error('name')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control mb-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()['email']) }}" placeholder="your email...">
                @error('email')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror

              </div>
              <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-control mb-1 @error('username') is-invalid @enderror" name="username" value="{{ old('username', Auth::user()['username']) }}" placeholder="your username...">
                @error('username')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>
            </div>

          </div>

          <div class="tab-pane fade" id="account-change-password">
            <div class="card-body pb-2">

              <div class="form-group">
                <label class="form-label">Kata Sandi Baru</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Ketik sandi baru...">
                @error('password')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

              <div class="form-group">
                <label class="form-label">Ulangi Kata Sandi Baru</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Ketik sandi konfirmasi...">
                @error('password_confirmation')
                <small class="invalid-feedback">{{ $message }}</small>
                @enderror
              </div>

            </div>
          </div>
        </div>
        <div class="d-flex justify-content-center">
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        <br>

      </div>
      </form>






    </div>
  </div>


</div>
<!-- / Content -->

<div class="modal fade" id="modals-default">
  <div class="modal-dialog">
      <form class="modal-content" action="{{ route('users.change-photo', ['id' => Auth::user()['id']]) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="modal-header">
          <h6 class="modal-title mb-0">Ganti Foto Profil</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
      </div>
      <div class="modal-body">
          <div class="form-row">
          <div class="form-group col">
              <label class="form-label">Pilih Foto :</label><br>
              <input type="hidden" name="oldphoto" value="{{ Auth::user()['avatar'] }}">
              <input type="file" name="photo" required>
          </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
  </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/temp_backend/vendor/css/pages/account.css') }}">
@endsection

@section('jsbody')
<script src="{{ asset('assets/temp_backend/js/ui_modals.js') }}"></script>
<script>
    $('.delete').click(function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
        title: 'Apa anda yakin ingin menghapus foto profil ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Hapus!'
        }).then((result) => {
        if (result.value) {
            $(this).find('form').submit();
        }
        })
    });


</script>
@endsection
