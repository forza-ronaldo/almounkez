
@extends('layouts.app')

@section('content')


<div class="container">
    @if(session()->has('success'))
        <div class="alert alert-info">{{session()->get('success')}}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-3 text-center">admin <small>{{ $users->total() }}</small></h3>
                    <div class="row">
                        <form class="row col-10" action="{{route('dashboard.user.index')}}">
                        <input class="form-control col-9" type="text" name="search"  placeholder="search" value="{{ request()->search }}">
                        <button class=" btn-primary form-control col-2"><a>search</a></button>
                        </form>
                          <a class="btn btn-primary form-control col-2 "  href="{{route('dashboard.user.create')}}"><i class="fa fa-plus"></i> add</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th scope="col">id</th>
                            <th scope="col">name</th>
                            <th scope="col">email</th>
                            <th scope="col">created_at</th>
                            <th scope="col">updated_at</th>
                            <th scope="col">action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>
                                <button class="btn btn-sm btn-success">
                                    <a style="color: white;text-decoration: none" href={{route('dashboard.user.edit',$user->id)}}><i class="fa fa-edit" aria-hidden="true"></i>edit</a>
                                </button>
                                <button class="btn btn-sm btn-info">
                                    <a style="color: white;text-decoration: none" href={{route('dashboard.user.showFormSendMessage',$user->id)}}><i class="fa fa-edit" aria-hidden="true"></i>send message</a>
                                </button>
                                <form class="d-inline" action="{{route('dashboard.user.destroy',$user->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" onclick="confirm('are your sure')"><i class="fa fa-trash-o" aria-hidden="true"></i> delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">empty</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{$users->appends(request()->query())->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection


