@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => 'Edit Ad Details',
        'description' => $featuredads[0]['url']
    ])
    <div class="container-fluid mt--7">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-0">Edit Ad Details</h3>
                                </div>
                                <div class="col text-right">
                                    <a href="" class="text-danger"><u>Delete</u></a>
                                </div>
                            </div>
                    </div>
                    <div class="card-body">
                        <form action="{{url('updatead')}}" enctype="multipart/form-data" method="post">
                            @csrf
                        @foreach($featuredads[0] as $key=>$value)
                          @if($key=='id')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}" readonly>
                                </div>
                            </div>
                            @elseif($key=='banner')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="{{$key}}_hash" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/ads/'.$value)}}" style="max-height: 100px;max-width:500px;margin-right: 20px;"><div>Change icon:<br><br><input type="file" name="banner_file"></div>
                                </div>
                            </div>
                            @elseif($key=='status')
                            <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                     <select class="form-select" name="{{$key}}">
                                        <option value="0" @if($value==0)selected @endif>Unavailable</option>
                                        <option value="1" @if($value==1)selected @endif>Available</option>
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
