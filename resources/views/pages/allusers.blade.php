@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Customers</h6>
        </div>
      </div>
    </div>
  </div>
</div><!-- Page content -->
<div class="container-fluid mt--6">
  <div class="row">
    <div class="col">
      <div class="card">
        <!-- Card header -->
        <div class="card-header border-0">
          <h3 class="mb-0">Customers</h3>
        </div><!-- Light table -->
        <div class="table-responsive text-center">
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col" class="sort" data-sort="name">Name</th>
                <th scope="col" class="sort" data-sort="budget">Email</th>
                <th scope="col" class="sort" data-sort="budget">Phone</th>
                <th scope="col" class="sort" data-sort="status">Status</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody class="list">
              @foreach($users as $user)
              <tr>
                <th scope="row">
                  <a href="{{Request::path()}}/{{$user['id']}}"><span class="name mb-0 text-sm">{{$user['first_name']}} {{$user['last_name']}}</span></a>
                </th>
                <td>
                  {{$user['email']}}
                </td>
                <td class="budget">{{$user['phone_no']}}</td>
                <td><span class="badge badge-dot mr-4"><span class="status">@if($user['user_status']==0)
                        Unavailable
                        @else
                        
                        Available
                        @endif</span></span></td>
                
                    <td class="text-right">
                      <!-- <div class="dropdown">
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
    </div>
  </div>@include('layouts.footers.auth')
</div>@endsection