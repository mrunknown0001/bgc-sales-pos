@extends('Back.master')
@section('title', __('idioma.product_titulo'))
@section('active-producto', 'active')
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
                        <h4 class="page-title">@lang('idioma.product_titulo')</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ route('dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                 @lang('idioma.product_titulo')
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
                            @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->venta_r == 1)
                                <h3 class="box-title"><a href="{{route('product.new')}}" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> ADD </a></h3>
                            
                            @endif
                                <h3 class="box-title"><a href="{{ route('products.pdf') }}" class="btn btn-danger pull-right"><i class="fa fa-file-pdf-o"></i> PDF</a></h3>
                                {{-- <h3 class="box-title"><a href="{{ route('products.csv')}}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i>CSV</a></h3> --}}
                        @endif
                        <h4 class="m-t-0 header-title"><b> @lang('idioma.products_list') </b></h4>
                        <p class="text-muted font-13 m-b-30">
                            &nbsp;
                        </p>
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{session('status')}}
                                </div>
                            @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Stock</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Sub-Category</th>
                                <th>UOM</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td><a href="{{ route('product.show', $d->id) }}">{{ $d->codigo }}</a></td>
                                   
                                   @if($d->cantidad < 1)
                                    <td><a href="{{ route('product.show', $d->id) }}">@lang('idioma.gral_agotado')</a></td>
                                   @else
                                    <td><a href="{{ route('product.show', $d->id) }}">{{$d->cantidad}}</a></td>
                                   @endif

                                   <td><a href="{{ route('product.show', $d->id) }}">{{ $d->nombre }}</a></td>
                                   <td><a href="{{ route('product.show', $d->id) }}">{{ $d->categoria->nombre }}</a></td>
                                   <td><a href="{{ route('product.show', $d->id) }}">{{ $d->subcategoria->nombre }}</a></td>
                                   <td><a href="{{ route('product.show', $d->id) }}">{{ $d->uom->uom }}</a></td>
                                    @if($d->status == 1)
                                        <td><a href="{{ route('product.show', $d->id) }}"><font color="green"><b>@lang('idioma.gral_activo')</b></font></a></td>
                                    @else
                                        <td><a href="{{ route('product.show', $d->id) }}"><font color="red"><b>@lang('idioma.gral_in_activo')</b></font></a></td>
                                    @endif
                                    <td><a href="{{ route('product.pdf',$d->id)}}" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="@lang('idioma.gral_descargar')"><i class="fa fa-file-pdf-o"></i></td>
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