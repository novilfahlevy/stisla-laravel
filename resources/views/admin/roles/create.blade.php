@extends('layouts.admin.app', ['title' => 'Tambah role'])

@section('content')
  <div class="row">
    <div class="col-12">  
      <div class="card">
        <div class="card-header">
          <h4>Form Role</h4>
          <div class="card-header-form">
            <a href="{{ route('role.index') }}" class="btn btn-primary">
              <i class="fas fa-angle-left mr-1"></i>
              Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <label for="name">Nama Role</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                </div>
              </div>
              <div class="col-12">
                <label>Hak Akses</label>
                <div class="border p-3 mb-3">
                  <button type="button" class="btn btn-success btn-sm mr-2" id="selectAllRole">Pilih Semua</button>
                  <button type="button" class="btn btn-success btn-sm" id="unselectAllRole">Batal Pilih Semua</button>
                  <hr>
                  <div class="row">
                    @foreach ($permissions as $permission)
                    <div class="col-md-4 col-lg-3">
                      <div class="card mb-3 border role selectable" style="cursor: pointer" data-permission="{{ $permission->name }}">
                        <div class="card-body d-flex align-items-center justify-content-center py-2 px-3">
                          <h6 class="mb-0 text-break text-center" style="user-select: none">{{ $permission->name }}</h6>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="form-check mb-3">
                  <input class="form-check-input" type="checkbox" id="isDeleteable" name="isDeleteable">
                  <label class="form-check-label" for="isDeleteable">
                    User dengan role ini tidak dapat dihapus
                  </label>
                </div>
              </div>
              <div class="col-12">
                <input type="hidden" name="permissions" id="permissions">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>  
  const roles = $('.role');

  function setRolesToSubmit() {
    const inputField = $('input#permissions');
    const roles = $('.role.is-selected').map(function(i, role) {
      return $(role).data('permission');
    });

    inputField.val(JSON.stringify(roles.toArray()));

    console.log(inputField.val());
  }


  $('#selectAllRole').on('click', function() {
    $('.role').addClass('bg-info is-selected');
    setRolesToSubmit();
  });

  $('#unselectAllRole').on('click', function() {
    $('.role').removeClass('bg-info is-selected');
    setRolesToSubmit();
  });

  roles.on('click', function() {
    $(this).toggleClass('bg-info is-selected');
    setRolesToSubmit();
  });
</script>
@endpush