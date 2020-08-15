@extends('layouts.admin.app', ['title' => 'Dasbor'])

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-primary">
        <i class="fas fa-users-cog"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Jumlah Admin</h4>
        </div>
        <div class="card-body">
          10
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
      <div class="card-icon bg-warning">
        <i class="fas fa-users"></i>
      </div>
      <div class="card-wrap">
        <div class="card-header">
          <h4>Jumlah User</h4>
        </div>
        <div class="card-body">
          20
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
