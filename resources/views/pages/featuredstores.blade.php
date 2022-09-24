@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Featured Stores</h6>
            </div>
          </div>
        </div>
      </div>
    </div>
   <div class="container-fluid mt--6">
<div class="row">
  <div class="col">
    <div class="card mb-3">
      <!-- Card header -->
      <div class="card-header border-0">
        <h3 class="mb-0">Featured Stores</h3>
      </div>
      <!-- Light table -->
      <div class="table-responsive text-center">
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="sort" data-sort="name">Id</th>
              <th scope="col" class="sort" data-sort="budget">Shop</th>
              <th scope="col" class="sort" data-sort="budget">Vendor</th>
              <th scope="col" class="sort" data-sort="status">Status</th>
              <th scope="col">Availability</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach($featuredstores as $shop)
            <tr>
              <td>
                {{$shop['id']}}
              </td>
              <th scope="row">
                <div class="align-items-center">
                  <a href="shops/{{$shop['id']}}">
                  <img alt="Image placeholder" src="{{asset('storage/assets/img/logo/'.$shop['logo_image'])}}" class="avatar mr-3">
                  <span class="name mb-0 text-sm">{{$shop['shopName']}}</span>
                  </a>
                </div>
              </th>
              <td>
                <a href="#">{{$shop['first_name']}} {{$shop['last_name']}}</a>
              </td>
              <td class="budget">
                @if($shop['status']==0)
                Unverified
                @elseif($shop['status']==1)
                Verified<br>Non Premium
                @elseif($shop['status']==2)
                Verified<br>Premium<br>Non Featured
                @else
                Verified<br>Premium<br>Featured
                @endif
              </td>
              <td>
                <span class="badge badge-dot mr-4">
                <i class="bg-success"></i>
                <span class="status">@if($shop['visibility']==0)
                Unavailable
                @else
                Available
                @endif</span>
                </span>
              </td>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="card">
      <!-- Card header -->
      <div class="card-header border-0">
        <h3 class="mb-0">Eligible to Feature</h3>
      </div>
      <!-- Light table -->
      <div class="table-responsive text-center">
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col" class="sort" data-sort="name">Id</th>
              <th scope="col" class="sort" data-sort="budget">Shop</th>
              <th scope="col" class="sort" data-sort="budget">Vendor</th>
              <th scope="col" class="sort" data-sort="status">Status</th>
              <th scope="col">Availability</th>
            </tr>
          </thead>
          <tbody class="list">
            @foreach($eligible as $shop)
            <tr>
              <td>
                {{$shop['id']}}
              </td>
              <th scope="row">
                <div class="align-items-center">
                  <a href="shops/{{$shop['id']}}">
                  <img alt="Image placeholder" src="{{asset('storage/assets/img/logo/'.$shop['logo_image'])}}" class="avatar mr-3">
                  <span class="name mb-0 text-sm">{{$shop['shopName']}}</span>
                  </a>
                </div>
              </th>
              <td>
                <a href="#">{{$shop['first_name']}} {{$shop['last_name']}}</a>
              </td>
              <td class="budget">
                @if($shop['status']==0)
                Unverified
                @elseif($shop['status']==1)
                Verified<br>Non Premium
                @elseif($shop['status']==2)
                Verified<br>Premium<br>Non Featured
                @else
                Verified<br>Premium<br>Featured
                @endif
              </td>
              <td>
                <span class="badge badge-dot mr-4">
                <i class="bg-success"></i>
                <span class="status">@if($shop['visibility']==0)
                Unavailable
                @else
                Available
                @endif</span>
                </span>
              </td>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
        @include('layouts.footers.auth')
</div>@endsection
    <!-- Page content -->