
@extends('layouts.app')

@section('content')
<div class="container">
    @if(session()->has('success'))

        <div class="alert alert-info">{{session()->get('success')}}</div>
    @endif
    <form action="{{route('dashboard.user.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div>
            <div>
            <label>@lang('site.name')</label>
            <input class="form-control input mb-1 @error('name') is-invalid @enderror" value="{{ old('name') }}"  type="text" name="name"  placeholder="name" >
            </div>
            <div>
            <label>@lang('site.email')</label>
            <input class="form-control input mb-1 @error('email') is-invalid @enderror" value="{{ old('email') }}"  type="email" name="email" placeholder="Email" autocomplete="off" >
            </div>
            <div>
            <label>@lang('site.password')</label>
            <input class="form-control input mb-1 @error('password') is-invalid @enderror" value="{{ old('password') }}"  type="password" name="password" placeholder="Password" autocomplete="new-password" >
            </div>
            <div>
                <label>@lang('site.confirme_pass')</label>
                <input class="form-control  mb-1 @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmed') }}"  type="password" name="password_confirmation" placeholder="Re-Password" >
            </div>
            <div>
                <label>@lang('site.image')</label>
                <input class="mb-1 @error('image') is-invalid @enderror" value="{{ old('image') }}"  type="file" name="image"  >
            </div>
            <div>
                <label>@lang('site.role')</label><br>
                <select class=" form-control-sm" name="role">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach()
                </select>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <button class="form-control mt-2">@lang('site.add')</button>
        </div>
    </form>
</div>
@endsection
