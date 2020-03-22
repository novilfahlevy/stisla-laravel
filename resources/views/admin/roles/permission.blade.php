@extends('layouts.admin.app', ['title' => 'Permissions (' . $role . ')'])

@section('content')
  <div class="row">
    <div class="col-12">  
      <div class="card">
        <div class="card-header">
          <h4>Permissions List</h4>
          <div class="card-header-form">
            <a href="#" class="btn btn-success mr-2">
              <i class="fas fa-pencil-alt mr-1"></i>
              Permission
            </a>
            <a href="{{ route('role.index') }}" class="btn btn-primary">
              <i class="fas fa-angle-left mr-1"></i>
              Back
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            @forelse ($permissions as $permission)
            <div class="col-md-4 col-lg-3">
              <h6 class="card border role">
                <h6 class="card-body d-flex align-items-center justify-content-center py-2 px-3">
                  <h6 class="mb-0 text-break text-capitalize text-center">{{ str_replace('_', ' ', $permission->name) }}</h6>
                </h6>
              </h6>
            </div>
            @empty
              <div class="col-12 py-5">
                <h5 class="mb-0 text-center">Tidak ada data</h5>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
<script>  
  const maxHeight = Math.max(
    ...$('.role').map(function(i, e) {
      return Number($(e).css('height').replace('px', ''));
    })
  );
  $('.role').css('height', `${maxHeight}px`);
</script>
@endpush