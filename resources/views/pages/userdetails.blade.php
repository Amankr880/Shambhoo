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
                             @elseif($key=='user_status')
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
                             @elseif($key=='user_type')
                            <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                     <select class="form-select" name="{{$key}}">
                                        <option value="0" @if($value==0)selected @endif>User</option>
                                        <option value="1" @if($value==1)selected @endif>Vendor</option>
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
                    <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Products</h3>
                    </div>
                    
                    <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="name">Id</th>
                    <th scope="col" class="sort" data-sort="budget">Product Name</th>
                    <th scope="col" class="sort" data-sort="budget">Price</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
              @foreach($products as $product)
                  <tr>
                    <td>
                        {{$product['id']}}
                    </td>
                    <td>
                        {{$product['product_name']}}
                    </td>
                    <td>
                        {{$product['MSRP']}}
                    </td>
                  </tr>
              @endforeach
                </tbody>
              </table>
                </div>
            <!-- </div> -->
        
        @include('layouts.footers.auth')
        </div>
    </div>
@endsection
