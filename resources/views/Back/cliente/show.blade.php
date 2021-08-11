@extends('Back.master')
@section('title', __('idioma.gral_viendo').": ".$datos->nombre . ' ' . $datos->apellido )
@section('active-personas', 'active')<!--ACTIVE DROP-->
@section('active-personas-clientes', 'active')<!--ACTIVE LINK-->
@section('content')

<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php $permisos = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();?>
 <!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">


            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">@lang('idioma.gral_op_par'): <i> {{ $datos->nombre . ' ' . $datos->apellido }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ route('dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ route('clients') }}">@lang('idioma.nav_clientes')</a>
                            </li>
                            <li class="active">
                                @lang('idioma.gral_viendo'):  {{ $datos->cedula }}
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-sm-6">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b></b></h4>
                        <p class="text-muted m-b-30 font-13">
                          
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{session('status')}}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{session('error')}}
                                    </div>
                                @endif

                                @if($datos->status == 1)
                                    <div class="form-group">
                                        <label for="nombreCliente">{{'Status'}}</label>
                                        <input type="text" value="@lang('idioma.gral_activo')" class="form-control status_activo_letra" readonly>
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="nombreCliente">{{'Status'}}</label>
                                        <input type="text" value="@lang('idioma.gral_in_activo')" class="form-control status_inactivo_letra" readonly>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="nombreCliente">@lang('idioma.gral_nombre')</label>
                                    <input type="text" value="{{ $datos->nombre }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="apellidoCliente">@lang('idioma.gral_apellido')</label>
                                    <input type="text" value="{{ $datos->apellido }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="cedulaCliente">@lang('idioma.cliente_cr')</label>
                                    <input type="text" value="{{ $datos->cedula }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="empresaCliente">@lang('idioma.cliente_empresa')</label>
                                    <input type="text" value="{{ $datos->empresa }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="correoCliente">@lang('idioma.gral_correo')</label>
                                    <input type="text" value="{{ $datos->correo }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="telefonoCliente">@lang('idioma.cliente_telef')</label>
                                    <input type="text" value="{{ $datos->telefono }}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="direccionCliente">@lang('idioma.gral_direcci')</label>
                                    <textarea class="form-control" readonly>{{ $datos->direccion }}</textarea>
                                </div>
                                <a href="{{ route('clients') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>

                                <a href="{{ route('client.edit',$datos->id) }}"><button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> Edit </button></a>

                                {{-- <a href="{{ route('client.destroy',$datos->id) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete </button></a> --}}
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#clientDeleteModal"><i class="fa fa-trash"></i> Delete </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->

<div class="modal fade" id="clientDeleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="ModalLongTitle"><span class="required">Delete Customer</span><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h2>
      </div>
      <div class="modal-body text-center">
        <a href="{{ route('client.destroy',$datos->id) }}" class="btn btn-danger btn-lg">Click to Delete!</a>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> --}}
    </div>
  </div>
</div>
@endsection