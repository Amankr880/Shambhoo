@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Shops</h6>
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
              <h3 class="mb-0">Shops</h3>
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
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
              @foreach($shops as $shop)
                  <tr>
                    <td>
                {{$shop['id']}}
                    </td>
                    <th scope="row">
                      <div class="align-items-center">
                        <a href="{{Request::path()}}/{{$shop['id']}}">
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
                    <td class="text-right">
                     <!--  <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </div> -->
                    </td>
                  </tr>
              @endforeach
                </tbody>
              </table>
            </div>
            <!-- Card footer -->
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fas fa-angle-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
        @include('layouts.footers.auth')
</div>@endsection