@extends('Back.master')
@section('title', __('idioma.nav_subcateg'))
@section('active-clasificacion', 'active subdrop')<!--ACTIVE DROP-->
@section('active-clasificacion-subcategoria', 'active')<!--ACTIVE LINK-->
@section('content')
<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php $permisos = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();?>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.subcateg_titulo')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ route('dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                 @lang('idioma.subcateg_titulo')
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
       
            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="card-box table-responsive">

                        @if(Session::get("rol_id"))
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->subcatego_r == 1)
                                <h3 class="box-title"><a href="{{url ('/nueva-subcategoria')}}" class="btn btn-primary" style="float:right;"><i class="fa fa-plus-circle"></i> @lang('idioma.gral_nueva') </a></h3>
                            @endif
                        @endif

                        <h4 class="m-t-0 header-title"><b>@lang('idioma.subcateg_list')</b></h4>
                        <p class="text-muted font-13 m-b-30">
                        </p>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>{{"#"}}</th>
                                <th>@lang('idioma.nav_subcateg')</th>
                                <th>@lang('idioma.nav_categ')</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td><a href="{{ url('/show_subcategoria', $d->id) }}">{{ $d->nombre }}</a></td>
                                    <td><a href="{{ url('/show_subcategoria', $d->id) }}">{{ $d->categoria->nombre }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- content -->
@endsection