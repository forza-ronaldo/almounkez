@extends('layouts.app')
@section('content')
<div class="container">
 <div style="height:100px"></div>
    <div class="row content">

        <div class="col-lg-7 col-md-7 col-sm-12 mb-3  position-relative " style="width: 18rem;">
             <form class="login position-absolute"  action="{{ route('setNewPassword',$user->id) }}" method="post">
                @csrf()
                <div class="login-top"><h2 class="text-center">Reset password</h2></div>
                <div class="card-body  ">
                    <div>
                        <input class="form-control input mb-1" type="password" name="password" placeholder="new password " autocomplete="new-password">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        @error('password')
                        <div class="alert alert-danger @error('password') is-invalid @enderror">{{$message}}</div>
                        @enderror
                    </div>
                    <div>
                        <input class="form-control input mb-1" type="password" name="password_confirmation" placeholder="re new password" autocomplete="new-password">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </div>
                    <input type="submit" value="reset" class="form-control mt-3 btn-submit" >
                </div>
                <div class="login-bottom">  </div>
            </form>
        </div>
    </div>
</div>
@endsection()


