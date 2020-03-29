@extends('layouts.admin.app', ['title' => 'Roles'])

@section('content')
<div class="row">
  <div class="col-12">
    @include('partials.alert')
    <div class="card">
      <div class="card-header">
        <h4>Role List</h4>
        @can('add_role')
        <div class="card-header-form">
          <button type="button" class="btn btn-primary" id="addRole">
            <i class="fas fa-plus mr-1"></i>
            Role
          </button>
        </div>
        @endcan
      </div>
      <div class="card-body">
        <ul class="list-group">
          @foreach ($roles as $role)
          <li class="list-group-item d-flex align-items-center justify-content-between">
            <h6 class="mb-0">{{ $role->name }}</h6>
            <div>
              @can('see_role_permissions')
              <a href="{{ route('role.show', $role->id) }}" class="btn btn-sm btn-warning mr-1">
                Permission
              </a>
              @endcan
              <button type="button" class="btn btn-sm btn-success mr-1" id="editRole" data-id="{{ $role->id }}" data-role="{{ $role->name }}">
                Edit
              </button>
              @can('delete_role')
              <button type="button" class="btn btn-sm btn-danger" id="deleteRole" data-id="{{ $role->id }}">
                Delete
              </button>
              @endcan
            </div>
          </li>
          @endforeach
        </ul>
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

<form action="#" class="d-none" method="POST" id="editRoleForm">
  @csrf @method('put')
  <input type="text" name="name" id="name">
</form>
@endsection

@push('js')
<script>
  $('button#addRole').on('click', async function() {
    const userId = $(this).data('id');
    const form = $('form#addRoleForm');

    const { value: roleName } = await Swal.fire({
      title: 'Enter role name',
      input: 'text',
      showCancelButton: true,
      inputValidator: value => !value && 'The role name field is required.'
    })

    if ( roleName ) {
      form.find('input#name').val(roleName);
      form.submit();
    }
  });

  $('button#deleteRole').on('click', function() {
    const userId = $(this).data('id');
    const form = $('form#deleteRoleForm');

    form.attr('action', `${baseURL}/role/${userId}`);
    swalDelete(result => result && form.submit());
  });

  $('button#editRole').on('click', async function() {
    const roleId = $(this).data('id');
    const form = $('form#editRoleForm');

    form.attr('action', `${baseURL}/role/${roleId}`);

    const { value: roleName } = await Swal.fire({
      title: 'Edit role name',
      input: 'text',
      inputValue: $(this).data('role'),
      showCancelButton: true,
      inputValidator: value => !value && 'The role name field is required.'
    })

    if ( roleName ) {
      form.find('input#name').val(roleName);
      form.submit();
    }
  });
</script>
@endpush