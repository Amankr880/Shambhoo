@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => 'Edit Category',
        'description' => $category[0]['category_name']
    ])  
    <div class="container-fluid mt--7">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-0">Edit Category</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="" class="text-danger"><u>Delete</u></a>
                                </div>
                            </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('updatecategory')}}" enctype="multipart/form-data" method="post">
                            @csrf
                        @foreach($category[0] as $key=>$value)
                          @if($key=='id')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}" readonly>
                                </div>
                            </div>
                            @elseif($key=='icon')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="icon_hash" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/category_icons/'.$value)}}" style="max-height: 100px;max-width:100px;margin-right: 20px;"><div>Change icon:<br><br><input type="file" name="icon_file"></div>
                                </div>
                            </div>
                            @elseif($key=='parent_category')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" name="{{$key}}">
                                        <option value="">Set Parent</option>
                                        @foreach($parent_categories as $parent_categories)
                                        <option value="{{$parent_categories['id']}}" @if($value==$parent_categories['id'])selected @endif>{{$parent_categories['category_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @else
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}">
                                </div>
                            </div>
                            @endif
                        @endforeach
                            <button type="submit" class="btn btn-success mt-4">Save</button>
                            <button type="button" class="btn mt-4">Cancel</button>
                        </form>
                    </div>
                </div>
            <!-- </div> -->
        
        @include('layouts.footers.auth')
        </div>
    </div>
@endsection
