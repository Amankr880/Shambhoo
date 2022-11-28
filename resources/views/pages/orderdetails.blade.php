@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => 'View Order',
        'description' => '#'.$orderDetails[0]['order_no'],
    ])  
    <div class="container-fluid mt--7">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Order Details</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('updateorder')}}" method="post">
                            @csrf
                            @foreach($orderDetails[0] as $key=>$value)
                            @if($key=='id' || $key=='order_no' || $key=='user_id')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col">
                                    <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}" readonly>
                                </div>
                            </div>
                             @elseif($key=='order_status')
                            <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                     <select class="form-select" name="{{$key}}">
                                        <option value="0" @if($value==0)selected @endif>Pending</option>
                                        <option value="1" @if($value==0)selected @endif>Confirmed</option>
                                        <option value="2" @if($value==0)selected @endif>Out for Delivery</option>
                                        <option value="3" @if($value==0)selected @endif>Delivered</option>
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
