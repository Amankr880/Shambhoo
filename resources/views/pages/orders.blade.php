@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Orders</h6>
          <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
              <li class="breadcrumb-item">
                <a href="#"></a>
              </li>
              <li class="breadcrumb-item">
                <a href="#">Orders</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">Orders</li>
            </ol>
          </nav>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="#" class="btn btn-sm btn-neutral">New</a> <a href="#" class="btn btn-sm btn-neutral">Filters</a>
        </div>
      </div>
    </div>
  </div>
</div><!-- Page content -->
<div class="container-fluid mt--6">
  <div class="card">
    <!-- Card header -->
    <div class="card-header border-0">
      <h3 class="mb-0">Orders</h3>
    </div><!-- Light table -->
    <div class="table-responsive text-center">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="sort" data-sort="name">Order Id</th>
                <th scope="col" class="sort" data-sort="budget">User</th>
                <th scope="col" class="sort" data-sort="budget">Vendor</th>
                <th scope="col" class="sort" data-sort="status">Total</th>
                <th scope="col">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach($orders as $order)
              <tr>
                <th scope="row">
                  <a href="{{Request::path()}}/{{$order['id']}}"><span class="name mb-0 text-sm">{{$order['order_no']}}</span></a>
                </th>
                <td>
                  {{$order['first_name']}} {{$order['last_name']}}
                </td>
                <td class="budget">{{$order['shopName']}}</td>
                <td>₹{{$order['total_order']}}</td>
                <td><span class="badge badge-dot mr-4"><span class="status">{{$order['order_status']}}</span></span></td>
                
                    <td class="text-right">
                      <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </div>
                    </td>
              </tr>
              @endforeach
            </tbody>
          </table>
    </div><!-- Card footer -->
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
  @include('layouts.footers.auth')
</div>@endsection