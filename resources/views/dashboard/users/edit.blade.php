@extends('layouts.dashboard.app')
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
            <td>
                <img src="{{asset('Uploads/UserImage/'.$user->image)}}" width="200">
            </td>
            <div class="mt-3">
                <label>@lang('site.image')</label>
                <input class="mb-1 @error('image') is-invalid @enderror" value="{{ old('image') }}"  type="file" name="image"  >
            </div>
            @foreach($roles_available as $role)
                {{$role->name}} <input type="checkbox" {{$role->users->find($user->id)->pivot->activation==1?'checked':''}}    value="{{$role->id}}" name="role[]">
            @endforeach()
            @foreach($roles_not_available as $role)
                {{$role->name}} <input type="checkbox"   value="{{$role->id}}" name="role[]">
            @endforeach()
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




