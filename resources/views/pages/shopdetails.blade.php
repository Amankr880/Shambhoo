@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => $shop[0]['shopName'],
        'description' => 'Owner: '.$shop[0]['first_name'].' '.$shop[0]['last_name'],
        'image' => $shop[0]['logo_image']
    ])  
    <div class="container-fluid mt--7">
        <!--<div class="row form-group">
             <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row form-group justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">
                                <a href="#">
                                    <img src="{{ asset('argon') }}/img/theme/team-4-800x800.jpg" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-sm btn-info mr-4">{{ __('Connect') }}</a>
                            <a href="#" class="btn btn-sm btn-default float-right">{{ __('Message') }}</a>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row form-group">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                    <div>
                                        <span class="heading">22</span>
                                        <span class="description">{{ __('Friends') }}</span>
                                    </div>
                                    <div>
                                        <span class="heading">10</span>
                                        <span class="description">{{ __('Photos') }}</span>
                                    </div>
                                    <div>
                                        <span class="heading">89</span>
                                        <span class="description">{{ __('Comments') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3>
                                {{ auth()->user()->name }}<span class="font-weight-light">, 27</span>
                            </h3>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i>{{ __('Bucharest, Romania') }}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{ __('Solution Manager - Creative Tim Officer') }}
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i>{{ __('University of Computer Science') }}
                            </div>
                            <hr class="my-4" />
                            <p>{{ __('Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music.') }}</p>
                            <a href="#">{{ __('Show more') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">-->
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Edit Store Details</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{url('updateshop')}}" method="post" enctype="multipart/form-data">
                            @csrf
                        @foreach($shop[0] as $key=>$value)
                            @if($key=='first_name')
                            @elseif($key=='last_name')
                            @elseif($key=='id')
                                <div class="row form-group d-flex align-items-center">
                                    <div class="col-3">
                                        <label class="form-control-label" for="input-name">{{$key}}</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}" readonly>
                                    </div>
                                </div>
                                @elseif($key=='delivery_slot')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">Registrar ID:</label>
                                </div>
                                <div class="col">
                                        <input type="text" name="{{$key}}" class="form-control form-control-alternative" value="{{$value}}">
                                    </div>
                            </div>
                            @elseif($key=='id_proof_photo')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="id_proof_photo" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/id_proof/'.$value)}}" style="max-height: 150px;max-width:150px;margin-right: 20px;"><div>Change image:<br><br><input type="file" name="id_proof_photo_file"></div>
                                </div>
                            </div>
                            @elseif($key=='pancard_photo')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="pancard_photo" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/pancard/'.$value)}}" style="max-height: 150px;max-width:150px;margin-right: 20px;"><div>Change image:<br><br><input type="file" name="pancard_photo_file"></div>
                                </div>
                            </div>
                            @elseif($key=='business_doc_photo')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="business_doc_photo" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/business_doc/'.$value)}}" style="max-height: 150px;max-width:150px;margin-right: 20px;"><div>Change image:<br><br><input type="file" name="business_doc_photo_file"></div>
                                </div>
                            </div>
                            @elseif($key=='logo_image')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="logo_image" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/logo/'.$value)}}" style="max-height: 100px;max-width:100px;margin-right: 20px;"><div>Change image:<br><br><input type="file" name="logo_image_file"></div>
                                </div>
                            </div>
                            @elseif($key=='header_image')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="header_image" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/header/'.$value)}}" style="max-height: 150px;max-width:150px;margin-right: 20px;"><div>Change image:<br><br><input type="file" name="header_image_file"></div>
                                </div>
                            </div>
                            @elseif($key=='gallery')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                    <input type="hidden" name="gallery" value="{{$value}}">
                                    <img src="{{asset('storage/assets/img/gallery/'.$value)}}" style="max-height: 150px;max-width:150px;margin-right: 20px;"><div>Change image:<br><br><input type="file" name="gallery_file"></div>
                                </div>
                            </div>
                            @elseif($key=='status')
                                <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">{{$key}}</label>
                                </div>
                                <div class="col d-flex align-items-center gx-4">
                                     <select class="form-select" name="{{$key}}">
                                        <option value="0" @if($value==0)selected @endif>Unverified</option>
                                        <option value="1" @if($value==1)selected @endif>Verfied but Not Premium</option>
                                        <option value="2" @if($value==2)selected @endif>Verified & Premium</option>
                                        <!-- <option value="3" @if($value==3)selected @endif>Verified, Premium, Featured</option> -->
                                    </select>
                                </div>
                            </div>
                            @elseif($key=='visibility')
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
                            @elseif($key=='validity')
                             <div class="row form-group d-flex align-items-center">
                                <div class="col-3">
                                    <label class="form-control-label" for="input-name">Validity:</label>
                                </div>
                                <div class="col">
                                        <input type="date" name="{{$key}}" class="form-control form-control-alternative" value="{{substr($value,0,10)}}">
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
                        </form></div>
                        <div class="card-header bg-white border-0">
                            <h3 class="mb-0">Shop Items</h3>
                    </div>
                     <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="sort" data-sort="budget">Product Name</th>
                    <th scope="col" class="sort" data-sort="budget">Description</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody class="list">
              @foreach($products as $product)
                  <tr>
                    <td>
                        <div class="row" style="width:300px">
                            <div class="col">
                                <img src="{{asset('storage/assets/img/product_img/'.$product['picture'])}}" width="100%">
                            </div>
                            <div class="col d-flex align-items-center">
                                {{$product['product_name']}}
                            </div>
                        </div>

                    </td>
                    <td>
                        {{$product['product_desc']}}
                    </td>
                  </tr>
              @endforeach
                </tbody>
              </table>
                </div>
            </div>
            <!-- </div> -->
        
        @include('layouts.footers.auth')
        </div>
    </div>
@endsection
