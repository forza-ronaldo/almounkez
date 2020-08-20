@extends('layouts.dashboard.app')
@section('content')
    <?php
        $data=isset($role_permission)?$role_permission:$user_permissions;
    ?>
<div class="container">
    @if(session()->has('success'))
        <div class="alert alert-info">{{session()->get('success')}}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-3 text-center">@lang('site.powers_management') {{--<small>{{ $UserImage->total() }}</small>--}}</h3>
                    <div class="row">
                        <form class="row col-10" action="{{route('dashboard.powersManagement.index')}}">
                        <input  type="hidden" name="table_type" value="{{ request()->table_type }}">
                        <input class="form-control col-9" type="text" name="search"  placeholder="search" value="{{ request()->search }}">
                        <button class=" btn-primary form-control col-2"><a>@lang('site.search')</a></button>
                        </form>
{{--                        @if(auth()->user->hasPermission('admins_create'))--}}
                          <a class="btn btn-primary form-control col-2 "  href="{{route('dashboard.powersManagement.create',request()->query())}}"><i class="fa fa-plus"></i> {{request()->table_type=='role'?__('site.add_role'):__('site.add_permission')  }}</a>
{{--                        @endif()--}}
                    </div>
                    <form id="form_table_type" action="{{route('dashboard.powersManagement.index')}}">
                        <select class="form-control-sm mt-2 select_table_type" name="table_type">
                            <option {{request()->table_type=='permission'?'selected':''}}  value="permission">Permission</option>
                            <option {{request()->table_type=='role'?'selected':''}} value="role">Role</option>
                        </select>
                    </form>
{{--                    <div class="dropdown">--}}
{{--                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                            @lang('site.action')--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">--}}
{{--                            <button class="dropdown-item" type="button">--}}
{{--                                <a style="color: black;text-decoration: none" href={{route('dashboard.powersManagement.index')}}>@lang('site.all')</a>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <a id="pdf" href="#">pdf</a>--}}
                </div>
                <div class="card-body">
                    <table class="table table-striped text-center">
                        <thead>
                        <tr>
                            <th scope="col">{{isset($user_permissions)?__('site.user_id'):__('site.role_id')}}</th>
                            <th scope="col">{{isset($user_permissions)?__('site.user_name'):__('site.role_name')}}</th>
                            <th scope="col">@lang('site.permission_id')</th>
                            <th scope="col">@lang('site.permission_name')</th>
                            <th scope="col">@lang('site.permission_description')</th>
                            <th scope="col">{{isset($user_permissions)?__('site.activation'):__('site.role')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td>{{$row->pivot->user_id!=null?$row->pivot->user_id:$row->pivot->role_id}}</td>
                            <td>{{$row->pivot->pivotParent->name}}</td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->description}}</td>
                            <td>
                                @isset($user_permissions)
                                <form id="form_edit_permission{{$row->pivot->user_id}}{{$row->id}}" method="post" action="{{route('dashboard.powersManagement.update',$row->id)}}">
                                    @csrf()
                                    @method('PUT')
                                    <input type="hidden" name="user_id" value="{{$row->pivot->user_id}}">
                                    <input class="checkbox_edit" type="checkbox" data-user_id="{{$row->pivot->user_id}}"  data-permission_id="{{$row->id}}"  {{$row->pivot->activation==1?'checked':''}}>
                                </form>
                                @else()
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            @lang('site.action')
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button class="dropdown-item" type="button">
                                                <a style="color: black;text-decoration: none" href={{route('dashboard.powersManagement.show',$row->pivot->role_id)}}>@lang('site.show user')</a>
                                            </button>
                                            <button class="dropdown-item" type="button">
                                                <a style="color: black;text-decoration: none" href={{route('dashboard.powersManagement.show.form.update.role_permission',$row->pivot->role_id)}}>@lang('site.Modify his powers')</a>
                                            </button>

                                        </div>
                                    </div>
                                @endisset()
                            </td>
                            <td>
{{--                                @if(auth()->user()->hasPermission('admins_update'))--}}
{{--                                <button class="btn btn-sm btn-success">--}}
{{--                                        <a style="color: white;text-decoration: none" href={{route('dashboard.powersManagement.edit',$user->id)}}><i class="fa fa-edit" aria-hidden="true"></i>@lang('site.edit')</a>--}}
{{--                                    </button>--}}
{{--                                @endif()--}}

{{--                                @if(auth()->user()->hasPermission('admins_delete'))--}}
{{--                                    <form class="d-inline" action="{{route('dashboard.powersManagement.destroy',$user->id)}}" method="post">--}}
{{--                                    @method('DELETE')--}}
{{--                                    @csrf--}}
{{--                                    <button class="btn btn-sm btn-danger" onclick="confirm('are your sure')"><i class="fa fa-trash-o" aria-hidden="true"></i> @lang('site.delete')</button>--}}
{{--                                    </form>--}}
{{--                                @endif()--}}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">@lang('site.empty')</td></tr>
                        @endforelse
                        </tbody>
                    </table>
{{--                    {{$data->appends(request()->query())->links()}}--}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


