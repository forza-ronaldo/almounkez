@extends('layouts.app')
@section('content')
    <div class="card w-50 m-auto">
        <div class="card-header-pills">
            <h4>
                @lang('site.profile_settings')
            </h4>
        </div>
        <div class="card-body">
            <form action="{{route('user.update',$user->id)}}" method="post">
                @method("PUT")
                @csrf()
                <div>
                    <label>@lang('site.name')</label>
                    <input class="form-control @error('name') is-invalid @enderror()" type="text" name="name" value="{{$user->name}}">
                    @error('name')
                    <div class=" alert-sm alert-danger mt-1">
                        {{$message}}
                    </div>
                    @enderror()
                </div>
                <div>
                    <label> @lang('site.current_password')</label>
                    <input class="form-control @error('current_password') is-invalid @enderror()" type="password" name="current_password" >
                    @error('current_password')
                    <div class=" alert-sm alert-danger mt-1">
                        {{$message}}
                    </div>
                    @enderror()
                    @isset($msg_result_check_pass)
                        <div class="alert-sm alert-info mt-1">
                            {{ $msg_result_check_pass }}
                        </div>
                    @endisset()
                </div>
                <div>
                    <label>@lang('site.new_password')</label>
                    <input class="form-control @error('password') is-invalid @enderror()" type="password" name="password">
                    @error('password')
                    <div class=" alert-sm alert-danger mt-1">
                        {{$message}}
                    </div>
                    @enderror()
                </div>
                <div>
                    <label>@lang('site.confirme_pass')</label>
                    <input class="form-control" type="password" name="password_confirmation">
                </div>
                <div class=" d-flex ">
                    <input class="btn btn-outline-success mt-3 mr-1 form-control-sm " type="submit" value="حفظ">
                    <button class="btn btn-outline-danger mt-3 form-control-sm "><a href="{{url()->previous()}}" ></a>رجوع</button>
                </div>
            </form>
        </div>

    </div>

@endsection()
