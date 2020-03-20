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
                  <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-success">
                    Edit
                  </a>
                  <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-none" id="delete_user_form">
                    @csrf @method('delete')
                  </form>
                  <button type="button" onclick="document.getElementById('delete_user_form').submit();" class="btn btn-sm btn-danger">
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
