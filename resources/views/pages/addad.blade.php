@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => 'Add Ad',
        'description' => ''
    ])
    <div class="container-fluid mt--7">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-0">Add Ad Details</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="" class="text-danger"><u>Delete</u></a>
                                </div>
                            </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('insertad')}}" enctype="multipart/form-data" method="post">
                            @csrf
                        @foreach($ad as $key)
                          @if($key=='id')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative" readonly>
                                </div>
                            </div>
                            @elseif($key=='banner')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="file" name="banner_file">
                                </div>
                            </div>
                            @else
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative">
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
