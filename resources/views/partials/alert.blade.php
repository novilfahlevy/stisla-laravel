@if (request()->session()->has('alert'))
  @php $alert = request()->session()->get('alert') @endphp
  <x-alert :type="$alert['type']" :message="$alert['message']" />
@endif