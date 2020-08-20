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
                        <h3 class="mb-3 text-center">@lang('site.powers_management') {{--<small>{{ $UserImage->total() }}</small>--}}</h3>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('site.action')
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <button class="dropdown-item" type="button">
                                    <a style="color: black;text-decoration: none" href={{route('dashboard.powersManagement.index')}}>@lang('site.all')</a>
                                </button>
                            </div>
                        </div>
                        <a id="pdf" href="#">pdf</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped text-center">
                            <thead>
                            <tr>
                                <th scope="col">{{__('site.role_id')}}</th>
                                <th scope="col">{{__('site.role_name')}}</th>
                                <th scope="col">@lang('site.permission_id')</th>
                                <th scope="col">@lang('site.permission_name')</th>
                                <th scope="col">@lang('site.permission_description')</th>
                                <th scope="col">{{__('site.role')}}</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            {{dump($permissions_available)}}--}}
{{--                            {{dd($permissions_not_available)}}--}}
                            @foreach($permissions_available as $row)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->description}}</td>
                                    <td>
                                            <form id="form_edit_permission{{$row->id}}{{$role->id}}" method="post" action="{{route('dashboard.powersManagement.update.role_permission',$role->id)}}">
                                            @csrf()
                                            @method('PUT')
                                            <input type="hidden" name="permission_id" value="{{$row->id}}">
                                            <input class="checkbox_edit" type="checkbox" data-user_id="{{$row->id}}"  data-permission_id="{{$role->id}}" {{$row->roles->find($role->id)->pivot->activation==1?'checked':''}}>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            @foreach($permissions_not_available as $row)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->description}}</td>
                                    <td>
                                        <form id="form_edit_permission{{$row->id}}{{$role->id}}" method="post" action="{{route('dashboard.powersManagement.update.role_permission',$role->id)}}">
                                            @csrf()
                                            @method('PUT')
                                            <input type="hidden" name="permission_id" value="{{$row->id}}">
                                            <input class="checkbox_edit" type="checkbox" data-user_id="{{$row->id}}"  data-permission_id="{{$role->id}}" >
                                        </form>
                                    </td>
                                </tr>
                            @endforeach()
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


