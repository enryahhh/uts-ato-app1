@extends('layouts.app')
@section('content')
<div class="main-wrapper container">
@include('layouts.navbar')
    <div class="main-content">
        <section class="section">
        

          <div class="section-body">
            @yield('content-kasir')
          </div>
        </section>
    </div>
    @include('utilities.footer')
</div>

@endsection
@push('script')
    <script>
        $('body').attr("class",'layout-3');
    </script>
@endpush