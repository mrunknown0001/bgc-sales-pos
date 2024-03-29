@extends('Back.master')
@section('title',  'Processed Sales')
@section('active-ventas', 'active subdrop')
@section('active-ventas-aprobadas', 'active')
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
                        <h4 class="page-title">Processed Sales</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ route('dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li class="active">
                                Processed Sales
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
                                <h3 class="box-title"><a href="{{url('/pdf_ventas_aprobadas')}}" class="btn btn-danger pull-right"><i class="fa fa-file-pdf-o"></i>{{" PDF "}}</a></h3>
                                {{-- <h3 class="box-title"><a href="{{url('/csv_ventas_aprobadas')}}" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i>{{" CSV "}}</a></h3> --}}
                        @endif

                        <h4 class="m-t-0 header-title"><b>Processed Sales Lists</b></h4>
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
                                <th>{{"#"}}</th>
                                <th>{{"Code"}}</th>
                                <th>@lang('idioma.gral_cliente')</th>
                                <th>{{"Total ".$sistema->moneda}}</th>
                                <th>@lang('idioma.dash_fecha')</th>
                                <th>@lang('idioma.gral_opcions')</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($datos as $key => $d)
                                <tr>
                                   <td>{{++$key}}</td>
                                   <td class="fac_aprobadas">{{ $d->codigo_proceso }}</td>
                                   <td>{{ \App\Http\Controllers\GeneralController::getClientName($d->cliente->id) }}</td>
                                   <td>{{ number_format($d->total,2) }}</td>
                                   <td>{{ $d->created_at }}</td>
                                   <td>
                                       <a title="@lang('idioma.gral_descargar')" href="{{route('sales.pdf.download',$d->id)}}" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i></a>
                                       
                                    </td>
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