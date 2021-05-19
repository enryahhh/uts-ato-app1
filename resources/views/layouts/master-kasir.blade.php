@extends('layouts.app')
@section('content')
<div class="main-wrapper container">
@include('layouts.navbar')
    <div class="main-content">
        <section class="section">
        <div class="section-header">
            <h1>@yield('section-header')</h1>
            <div class="section-header-breadcrumb">
              <!-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Forms</a></div>
              <div class="breadcrumb-item">Advanced Forms</div> -->
            </div>
          </div>

          <div class="section-body">
            @yield('content-kasir')
          </div>
        </section>
    </div>
</div>
@endsection
@push('script')
    <script>
    $('body').attr("class",'layout-3');
    </script>
@endpush