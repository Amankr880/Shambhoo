@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => 'View User',
        'description' => $user[0]['first_name'].' '.$user[0]['last_name']
    ])  
    <div class="container-fluid mt--7">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <h3 class="mb-0">User Details</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('updateuser')}}" enctype="multipart/form-data" method="post">
                            @csrf
                        @foreach($user[0] as $key=>$value)
                         @if($key=='id')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}" readonly>
                                </div>
                            </div>
                            @elseif($key=='image')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="image" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/users/'.$value)}}" style="max-height: 100px;max-width:100px;margin-right: 20px;"><div>Change icon:<br><br><input type="file" name="image_file"></div>
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
