@extends('layouts.admin.app', ['title' => 'Users'])

@section('content')
<div class="row">
  <div class="col-12">
    @include('partials.alert')
    <div class="card">
      <div class="card-header">
        <h4>User List</h4>
        @can('add_user')
        <div class="card-header-form">
          <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>
            User
          </a>
        </div>
        @endcan
      </div>
      <div class="card-body">
        <table class="table datatable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Role</th>
              <th scope="col">Created At</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $i => $user)
              <tr>
                <th scope="row">{{ $i + 1 }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->roles->pluck('name')->first() }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                  @can('see_user')
                  <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-info mr-1">
                    Detail
                  </a>
                  @endcan
                  @can('edit_user')
                  <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-success mr-1">
                    Edit
                  </a>
                  @endcan
                  @can('delete_user')
                  <button type="button" class="btn btn-sm btn-danger" id="deleteModalButton" data-id="{{ $user->id }}">
                    Delete
                  </button>
                  @endcan
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<form action="#" method="POST" class="d-none" id="deleteUserForm">
  @csrf @method('delete')
</form>
@endsection

@push('js')
<script>
  $('button#deleteModalButton').on('click', function() {
    const userId = $(this).data('id');
    const form = $('form#deleteUserForm');

    form.attr('action', `${baseURL}/user/${userId}`);

    swalDelete(result => result && form.submit());
  });
</script>
@endpush