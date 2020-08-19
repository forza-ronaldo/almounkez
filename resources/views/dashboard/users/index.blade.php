
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
                    <h3 class="mb-3 text-center">@lang('site.UserImage') <small>{{ $users->total() }}</small></h3>
                    <div class="row">
                        <form class="row col-10" action="{{route('dashboard.user.index')}}">
                            <input class="form-control col-9" type="text" name="search"  placeholder="search" value="{{ request()->search }}">
                            <button class=" btn-primary form-control col-2"><a>@lang('site.search')</a></button>
                        </form>

{{--                        @if(auth()->user()->hasPermission('users_create'))--}}
                            <a class="btn btn-primary form-control col-2 "  href="{{route('dashboard.user.create')}}"><i class="fa fa-plus"></i>@lang('site.add') </a>
{{--                        @endif()--}}
                    </div>
                    <form id="form_table_type" action="{{route('dashboard.user.index')}}">
                        <span>role</span> <select class="form-control-sm mt-2 select_table_type" name="role">
                            <option value="all">@lang('site.all')</option>
                            @foreach($roles as $role)
                            <option {{request()->role==$role->id?'selected':''}}  value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach()
                        </select>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th scope="col">@lang('site.image')</th>
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
                            <td>
                                <img src="{{asset('Uploads/UserImage/'.$user->image)}}" width="100" >
                            </td>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @lang('site.action')
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button class="dropdown-item" type="button">
                                            <a class="btn btn-primary" style="color: white;text-decoration: none" href={{route('dashboard.user.edit',$user->id)}}><i class="fa fa-edit" aria-hidden="true"></i>@lang('site.edit')</a>
                                        </button>
                                        <button class="dropdown-item" type="button">
                                            <a class="btn btn-success" style="color: white;text-decoration: none" href={{route('dashboard.user.showFormSendMessage',$user->id)}}><i class="fa fa-send-o" aria-hidden="true"></i>@lang('site.send_message')</a>
                                        </button>
                                        <button class="dropdown-item" type="button">
                                            <a class="btn btn-info" style="color: white;text-decoration: none" href={{route('dashboard.powersManagement.index',['user_id'=>$user->id])}}><i class="fa fa-send-o" aria-hidden="true"></i>@lang('site.show_permission')</a>
                                        </button>
                                        <form class="dropdown-item" action="{{route('dashboard.user.destroy',$user->id)}}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger" onclick="confirm('are your sure')"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>
                                        </form>
                                    </div>
                                </div>
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


