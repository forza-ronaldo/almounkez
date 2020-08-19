
@extends('layouts.app')
@section('content')
<div class="container">
    @if(session()->has('success'))

        <div class="alert alert-info">{{session()->get('success')}}</div>
    @endif
    <div>
        <form action="{{route('dashboard.powersManagement.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type_added" value="{{isset($roles)?'permission':'role'}}">
                <div>
                <label>@lang('site.name')</label>
                <input class="form-control input mb-1 @error('name') is-invalid @enderror" value="{{ old('name') }}"  type="text" name="name"  placeholder="name" >
                </div>
                @isset($roles)
                <div>
                <label>@lang('site.description')</label>
                <input class="form-control input mb-1 @error('description') is-invalid @enderror" value="{{ old('description') }}"  type="text" name="description"  placeholder="name" >
                </div>
                <div>
                <label>@lang('site.to_role')</label>
                    <select class="form-control"  multiple name="role_id[]">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}"> {{$role->name}}</option>
                        @endforeach()
                    </select>
                @else
                <label>@lang('site.to_permission')</label>
                    <select class="form-control"  multiple name="permission_id[]">
                        @foreach($permission as $perm)
                            <option value="{{$perm->id}}"> {{$perm->name}}</option>
                        @endforeach()
                    </select>
                @endisset()
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

            <button class="form-control mt-2">@lang('site.add')</button>
            </div>
        </form>
    </div>
@endsection
@push('style')
    <style>

        .tabbable-panel {
            border:1px solid #eee;
            padding: 10px;
        }

        /* Default mode */
        .tabbable-line > .nav-tabs {
            border: none;
            margin: 0px;
        }
        .tabbable-line > .nav-tabs > li a.active {
            border-bottom: 3px solid red;
        }
        .tabbable-line > .nav-tabs > li {
            margin-right: 15px;
        }
        .tabbable-line > .nav-tabs > li > a {
            border: 0;
            margin-right: 0;
            color: #737373;
        }
        .tabbable-line > .nav-tabs > li > a > i {
            color: #a6a6a6;
        }

        .tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {

            text-decoration: none;
        }
        .tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
            color: #a6a6a6;
        }
        .tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
            margin-top: 0px;
        }
        .tabbable-line > .nav-tabs > li.active {
            position: relative;
        }
        .tabbable-line > .nav-tabs > li.active > a {
        }
        .tabbable-line > .nav-tabs > li.active > a > i {
            color: #404040;
        }
        .tabbable-line > .tab-content {
            margin-top: -3px;
            background-color: #fff;
            border: 0;
            border-top: 1px solid #eee;
            padding: 15px 0;
        }
        .portlet .tabbable-line > .tab-content {
            padding-bottom: 0;
        }

        /* Below tabs mode */

        .tabbable-line.tabs-below > .nav-tabs > li {
            border-top: 4px solid transparent;
        }
        .tabbable-line.tabs-below > .nav-tabs > li > a {
            margin-top: 0;
        }
        .tabbable-line.tabs-below > .nav-tabs > li:hover {

        }
        .tabbable-line.tabs-below > .nav-tabs > li.active {
            margin-bottom: -2px;
            border-bottom: 0;
            border-top: 4px solid #f3565d;
        }
        .tabbable-line.tabs-below > .tab-content {
            margin-top: -10px;
            border-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }
    </style>
@endpush()
