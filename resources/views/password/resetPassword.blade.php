@extends('layouts.app')
@section('content')
<div class="container">
<div style="height:100px"></div>
    <div class="row content">
        <div class="col-lg-7 col-md-7 col-sm-12 mb-3  position-relative " style="width: 18rem;">
            <form class="login position-absolute"  action="{{ route('searchYourAccount') }}" method="post">
                @csrf()
                <div class="login-top"><h2 class="text-center">Reset password</h2></div>
                <div class="card-body  ">
                    <div>
                        <input class="form-control input mb-1" type="email" name="email" placeholder="Email" autocomplete="off">
                        <i class="fa fa-envelope-square" aria-hidden="true"></i>
                        @error('email')
                        <div class="alert alert-danger @error('email') is-invalid @enderror">{{$message}}</div>
                        @enderror
                    </div>
                    @if(session()->has('sendEmailToResetPassword'))
                        <div class="alert alert-info">
                            {{session()->get('sendEmailToResetPassword')}}
                        </div>
                    @endif()
                    <input type="submit" value="search" class="form-control-sm mt-3 btn-primary">
                    <button class="form-control-sm mt-3 btn-primary"><a class="text-white" href="{{route('login')}}" >back</a></button>
                </div>
                <div class="login-bottom">  </div>
            </form>
        </div>
    </div>
</div>

@endsection()


