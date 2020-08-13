
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
            <input class="form-control input mb-1 @error('name') is-invalid @enderror" value="{{ old('name') }}"  type="text" name="name"  placeholder="name" >
            </div>
            <div>
            <input class="form-control input mb-1 @error('email') is-invalid @enderror" value="{{ old('email') }}"  type="email" name="email" placeholder="Email" autocomplete="off" >
            </div>
            <div>
            <input class="form-control input mb-1 @error('password') is-invalid @enderror" value="{{ old('password') }}"  type="password" name="password" placeholder="Password" autocomplete="new-password" >
            </div>
            <div>
            <input class="form-control input mb-1 @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmed') }}"  type="password" name="password_confirmation" placeholder="Re-Password" >
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
        <button class="form-control mt-2">add</button>
        </div>
    </form>
</div>
@endsection
