@extends('layouts.admin.app', ['title' => 'Permissions'])

@section('content')
<div class="row">
  <div class="col-12">  
    <div class="card">
      <div class="card-header">
        <h4>Permission List</h4>
      </div>
      <div class="card-body">
        <div class="row">
          @forelse ($permissions as $permission)
          <div class="col-md-4 col-lg-3">
            <div class="card border role">
              <div class="card-body d-flex align-items-center justify-content-center py-2 px-3">
                <h6 class="mb-0 text-break text-capitalize text-center">{{ str_replace('_', ' ', $permission->name) }}</h6>
              </div>
            </div>
          </div>
          @empty
          <div class="col-12 py-5">
            <h5 class="mb-0 text-center">Data empty</h5>
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