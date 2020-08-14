@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{route('dashboard.user.update',$user->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label>name</label>
                <input class="form-control input mb-1 @error('name') is-invalid @enderror" value="{{  $user->name }}"  type="text" name="name"  placeholder="name" >
            </div>
            <div>
                <label>email</label>
                <input class="form-control input mb-1 @error('email') is-invalid @enderror" value="{{  $user->email }}"  type="email" name="email" placeholder="Email" autocomplete="off" >
            </div>
            <div>
                <label>@lang('site.permissions')</label><br>
                @foreach(\App\User::getPermission() as $role=>$number)
                    <input class="" type="checkbox" name="permissions[]" value="{{$number}}" {{$user->checkRole($role)?'checked':''}}> {{$role}}
                @endforeach()
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
            <button class="form-control mt-2">edit</button>
        </form>
    </div>
@endsection




