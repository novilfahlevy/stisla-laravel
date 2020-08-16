@extends('layouts.admin.app', ['title' => 'Role'])

@section('content')
<div class="row">
  <div class="col-12">
    @include('partials.alert')
    <div class="card">
      <div class="card-header">
        <h4>Daftar Role</h4>
        @can('Menambah role')
        <div class="card-header-form">
          <a href="{{ route('role.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>
            Role
          </a>
        </div>
        @endcan
      </div>
      <div class="card-body">
        <h6>
          <i class="fas fa-backspace text-danger"></i> = User dengan role tersebut tidak dapat dihapus (undeleteable).
        </h6>
        <hr>
        <div class="row">
          @foreach ( $roles as $role )
          <div class="col-6 col-lg-3">
            <div class="card role border shadow-sm">
              <div class="card-body py-0 pl-3 pr-2 d-flex align-items-center justify-content-between">
                <h6 class="my-3 text-primary text-uppercase">
                  {{ $role->name }}
                  {!! $role->is_deleteable ? '' : '<i class="fas fa-backspace text-danger"></i>' !!}
                </h6>
                <div class="text-right mx-1">
                  <div class="dropdown">
                    <i class="btn btn-light btn-sm border-0 shadow-none bg-transparent fas fa-ellipsis-v" id="roleMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer"></i>
                    <div class="dropdown-menu pt-0" aria-label="roleMenu">
                      <p class="dropdown-header mb-0 pl-3">Total: {{ $role->users->count() }}</p>
                      <hr class="my-0">
                      @can('Mengubah data role')
                      <a href="{{ route('role.edit', $role->id) }}" class="dropdown-item" id="editRole">
                        Edit
                      </a>
                      @endcan
                      @can('Menghapus role')
                      <a href="/" class="dropdown-item" id="deleteRole" data-id="{{ $role->id }}">
                        Delete
                      </a>
                      @endcan
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<form action="#" method="POST" class="d-none" id="deleteRoleForm">
  @csrf @method('delete')
</form>

<form action="{{ route('role.store') }}" class="d-none" method="POST" id="addRoleForm">
  @csrf
  <input type="text" name="name" id="name">
</form>

<form action="/" class="d-none" method="POST" id="toggleDeleteableRoleForm">
  @csrf @method('put')
  <input type="text" name="roleId" id="roleId">
</form>
@endsection

@push('js')
<script>
  $('a#deleteRole').on('click', function(e) {
    e.preventDefault();

    const userId = $(this).data('id');
    const form = $('form#deleteRoleForm');

    form.attr('action', `${baseURL}/role/${userId}`);
    swalDelete(result => result && form.submit());
  });

  $('a#toggleDeleteableRole').on('click', function(e) {
    e.preventDefault();

    const roleId = $(this).data('id');
    const form = $('form#toggleDeleteableRoleForm');

    form.attr('action', `${baseURL}/role/${roleId}/deleteable`);
    form.submit();
  });
</script>
@endpush