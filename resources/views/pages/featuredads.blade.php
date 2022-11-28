@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Featured Ads</h6>
            </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{url('/')}}/addad" class="btn btn-sm btn-neutral">Add New Banner</a>
        </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col">
          <div class="card">
            <!-- Card header -->
            <div class="card-header border-0">
              <h3 class="mb-0">Featured Ads</h3>
            </div>
            <!-- Light table -->
            <div class="list-group">
          @foreach($featuredads as $ad)
          <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <a href="{{$ad['url']}}" class="flex-grow-1">
              <img src="{{asset('storage/assets/img/ads/'.$ad['banner'])}}" style="border-radius: 10px;max-width:350px;margin-right: 20px;">
            {{$ad['url']}}</a>
            @if($ad['status']==0)
                Disabled
                @else
                Enabled
                @endif<a href="featuredads/{{$ad['id']}}" class="btn ml-5"><i class="ni ni-settings"></i>&nbsp;&nbsp;Edit</a>
          </div>
          @endforeach
        </div>
          </div>
        </div>
      </div>
        @include('layouts.footers.auth')
</div>@endsection