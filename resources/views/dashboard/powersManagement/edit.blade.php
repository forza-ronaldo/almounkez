@extends('layouts.app')
@section('content')
    <div class="container">
        <form action="{{route('dashboard.powersManagement.update',$admin->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label>name</label>
                <input class="form-control input mb-1 @error('name') is-invalid @enderror" value="{{  $admin->name }}"  type="text" name="name"  placeholder="name" >
            </div>
            <div>
                <label>email</label>
                <input class="form-control input mb-1 @error('email') is-invalid @enderror" value="{{  $admin->email }}"  type="email" name="email" placeholder="Email" autocomplete="off" >
            </div>

            {{--start permissions section--}}
            <?php $models=['UserImage','admins'];?>
            <?php $options=['create','read','update','delete'];?>
            <div class="row">
                <div class="col-md-12">
                    <div class="tabbable-panel">
                        <div class="tabbable-line">
                            <h6>@lang('site.permissions')</h6>
                            <ul class="nav nav-tabs">
                                @foreach($models as $index=>$model)
                                    <li>
                                        <a href="#{{$model}}" data-toggle="tab" class={{$index==0?"active mr-2 ":'mr-2'}}  >{{$model}} </a>
                                    </li>&nbsp;
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach($models as $index=>$model)
                                    <div class="{{$index==0?'active' :''}} tab-pane " id="{{$model}}">
                                        @foreach($options as $option)
                                            <label>@lang('site.'.$option)</label>
                                            <input type="checkbox" name="permissions[]" value="{{$model}}_{{$option}}" {{$admin->hasPermission($model.'_'.$option)?'checked':''}}>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end permissions section-->
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
