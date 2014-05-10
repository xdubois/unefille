@if ($errors->any())
  <p class="bg-info">
    @lang('auth.error_message')
  </p>
@endif

@if ($message = Session::get('success'))
  <p class="bg-success">
    {{ $message }}
  </p>
@endif

@if ($message = Session::get('error'))
  <p class="bg-danger">
    {{ $message }}
  </p>
@endif

@if ($message = Session::get('warning'))
  <p class="bg-warning">
    {{ $message }}
  </p>
@endif

@if ($message = Session::get('info'))
  <p class="bg-info">
    {{ $message }}
  </p>
@endif





