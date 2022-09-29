@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => 'Add Category',
        'description' => ''
    ])  
    <div class="container-fluid mt--7">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Add Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('addcategory')}}" enctype="multipart/form-data" method="post">
                            @csrf
                        @foreach($category as $value)
                            @if($value=='id' || $value=='created_at' || $value=='updated_at')

                            @elseif($value=='icon')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$value}}</label>
                                </div>
                                <div class="col"><input type="file" name="icon_file"></div>
                            </div>
                            @elseif($value=='parent_category')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$value}}</label>
                                </div>
                                <div class="col">
                                    <select class="form-select" name="{{$value}}">
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
                                    <label class="form-control-label" for="input-name">{{$value}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$value}}" class="form-control form-control-alternative">
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
