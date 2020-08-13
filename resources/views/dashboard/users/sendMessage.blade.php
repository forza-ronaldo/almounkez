@extends('layouts.app')
@section('content')
    <div class="container">
        @if(session()->has('success'))

            <div class="alert alert-info">{{session()->get('success')}}</div>
        @endif
        <form action="{{route('dashboard.user.sendMessage',$user->id)}}" method="post">
            @csrf()
            <div>
                <div>
                    <textarea class="form-control input mb-1 @error('message') is-invalid @enderror" value="{{ old('message') }}" name="message"  placeholder="message" ></textarea>
                </div>
                @error('message')
                    <div class="alert alert-danger">
                        {{$message}}
                    </div>
                @enderror()
                <button class="form-control mt-2">send</button>
            </div>
        </form>
    </div>
@endsection
