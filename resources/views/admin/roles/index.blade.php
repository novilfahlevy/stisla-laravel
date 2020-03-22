@extends('layouts.admin.app', ['title' => 'Roles']);

@section('content')
  <div class="row">
    <div class="col-12">
      @if (request()->session()->has('alert'))
        @php $alert = request()->session()->get('alert') @endphp
        <x-alert :type="$alert['type']" :message="$alert['message']" />
      @endif
      <div class="card">
        <div class="card-header">
          <h4>Role List</h4>
        </div>
        <div class="card-body">
          <ul class="list-group">
            @foreach ($roles as $role)
            <li class="list-group-item d-flex align-items-center justify-content-between">
              <h6 class="mb-0">{{ $role->name }}</h6>
              <div>
                @can('manage_role_permissions')
                <a href="{{ route('role.show', $role->id) }}" class="btn btn-sm btn-success mr-1">
                  Permission
                </a>
                @endcan
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteRoleModal" id="deleteRoleModalButton" data-id="{{ $role->id }}">
                  Delete
                </button>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="deleteRoleModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="#" method="POST" id="deleteRoleForm">
        @csrf @method('delete')
        <div class="modal-body pt-5">
          <h5 class="mb-0 text-center">Are you sure you want to delete this role?</h5>
        </div>
        <div class="modal-footer py-3">
          <div class="row w-100">
            <div class="col-6">
              <button type="submit" class="btn btn-danger w-100">Delete</button>
            </div>
            <div class="col-6">
              <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endpush

@push('js')
<script>
  $('button#deleteRoleModalButton').on('click', function() {
    const userId = $(this).data('id');
    $('form#deleteRoleForm').attr('action', `${baseURL}/role/${userId}`);
  });
</script>
@endpush