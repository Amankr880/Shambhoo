@extends('layouts.app', ['title' => __('User Profile')])
@section('content')
<div class="header bg-primary pb-6">
  <div class="container-fluid">
    <div class="header-body">
      <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
          <h6 class="h2 text-white d-inline-block mb-0">Categories</h6>
        </div>
        <div class="col-lg-6 col-5 text-right">
          <a href="{{url('/')}}/addcategory" class="btn btn-sm btn-neutral">Add New Category</a>
        </div>
      </div>
    </div>
  </div>
</div><!-- Page content -->
<div class="container-fluid mt--6">
      <div class="card">
        <!-- Card header -->
        <div class="card-header border-0">
          <h3 class="mb-0">Categories</h3>
          @if(isset($parent))
          Subcategories under <a href="{{url('/')}}/categories/{{$parent[0]['id']}}">{{$parent[0]['category_name']}}</a>:
          @endif
        </div><!-- Light table -->
        @if(count($allcategories)!=0)
        <div class="list-group">
          @foreach($allcategories as $category)
          <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <a href="{{url('/')}}/categories/{{$category['id']}}" class="flex-grow-1">
              <img src="{{asset('storage/assets/img/category_icons/'.$category['icon'])}}" class="avatar mr-5">
              {{$category['category_name']}}
            </a>
            <a href="{{url('/')}}/editcategory/{{$category['id']}}"><u>Edit</u></a>
          </div>
          @endforeach
        </div>
        @else
        <div class="p-5">No subcategories.</div>
        @endif
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
      </div>@include('layouts.footers.auth')
</div>@endsection