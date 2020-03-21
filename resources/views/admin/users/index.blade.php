@extends('layouts.admin.app', ['title' => 'Users'])

@section('content')
<div class="row">
  <div class="col-12">
    @if (request()->session()->has('user_alert'))
      @php $alert = request()->session()->get('user_alert') @endphp
      <x-alert :type="$alert['type']" :message="$alert['message']" />
    @endif
    <div class="card">
      <div class="card-header">
        <h4>User List</h4>
        <div class="card-header-form">
          <a href="{{ route('user.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i>
            User
          </a>
        </div>
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
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
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                  <a href="{{ route('user.show', $user->id) }}" class="btn btn-sm btn-info mr-1">
                    Detail
                  </a>
                  <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-success mr-1">
                    Edit
                  </a>
                  <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" id="deleteModalButton" data-id="{{ $user->id }}">
                    Delete
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="{{ route('user.destroy', 1) }}" method="POST" id="deleteUserForm">
        @csrf @method('delete')
        <div class="modal-body pt-5">
          <h5 class="mb-0 text-center">Are you sure you want to delete this user?</h5>
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
  $('button#deleteModalButton').on('click', function() {
    const userId = $(this).data('id');
    $('form#deleteUserForm').attr('action', `${baseURL}/user/${userId}`);
  });
</script>
@endpush