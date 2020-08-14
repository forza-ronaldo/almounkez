@extends('layouts.dashboard.app')
@section('content')
<div class="container">
    @if(session()->has('success'))
        <div class="alert alert-info">{{session()->get('success')}}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-3 text-center">@lang('site.admin') <small>{{ $users->total() }}</small></h3>
                    <div class="row">
                        <form class="row col-10" action="{{route('dashboard.admin.index')}}">
                        <input class="form-control col-9" type="text" name="search"  placeholder="search" value="{{ request()->search }}">
                        <button class=" btn-primary form-control col-2"><a>@lang('site.search')</a></button>
                        </form>
                        @if(auth()->user()->hasPermission('users_create'))
                          <a class="btn btn-primary form-control col-2 "  href="{{route('dashboard.admin.create')}}"><i class="fa fa-plus"></i>@lang('site.add') </a>
                        @endif()
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th scope="col">@lang('site.id')</th>
                            <th scope="col">@lang('site.name')</th>
                            <th scope="col">@lang('site.email')</th>
                            <th scope="col">@lang('site.created_at')</th>
                            <th scope="col">@lang('site.updated_at')</th>
                            <th scope="col">@lang('site.action')</th>
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
                                @if(auth()->user()->hasPermission('users_update'))
                                <button class="btn btn-sm btn-success">
                                        <a style="color: white;text-decoration: none" href={{route('dashboard.admin.edit',$user->id)}}><i class="fa fa-edit" aria-hidden="true"></i>@lang('site.edit')</a>
                                    </button>
                                @endif()

                                @if(auth()->user()->hasPermission('users_delete'))
                                    <form class="d-inline" action="{{route('dashboard.admin.destroy',$user->id)}}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-danger" onclick="confirm('are your sure')"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                                    </form>
                                @endif()
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">@lang('site.empty')</td></tr>
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


