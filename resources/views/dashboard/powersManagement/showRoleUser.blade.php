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
                        <h3 class="mb-3 text-center">@lang('site.powersManagement') {{--<small>{{ $UserImage->total() }}</small>--}}</h3>
                        <div class="row">
                            <form class="row col-10" action="{{route('dashboard.powersManagement.index')}}">
                                <input class="form-control col-9" type="text" name="search"  placeholder="search" value="{{ request()->search }}">
                                <button class=" btn-primary form-control col-2"><a>@lang('site.search')</a></button>
                            </form>
                            {{--                        @if(auth()->user->hasPermission('admins_create'))--}}
                            <a class="btn btn-primary form-control col-2 "  href="{{route('dashboard.powersManagement.create')}}"><i class="fa fa-plus"></i>@lang('site.add') </a>
                            {{--                        @endif()--}}
                        </div>


                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <thead>
                            <tr>
                                <th scope="col">@lang('site.user_id')</th>
                                <th scope="col">@lang('site.user_name')</th>
                                <th scope="col">@lang('site.role_id')</th>
                                <th scope="col">@lang('site.role_name')</th>
                                <th scope="col">@lang('site.activation')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <form id="form_edit_permission{{$row->pivot->user_id}}{{$row->id}}" method="post" action="{{route('dashboard.powersManagement.update.role_user',$row->id)}}">
                                            @csrf()
                                            @method('PUT')
                                            <input type="hidden" name="role_id" value="{{$row->pivot->role_id}}">
                                            <input class="checkbox_edit" type="checkbox" data-user_id="{{$row->pivot->user_id}}"  data-permission_id="{{$row->id}}"  {{$row->pivot->activation==1?'checked':''}}>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">@lang('site.empty')</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


