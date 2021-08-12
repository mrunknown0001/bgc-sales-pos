@extends('Back.master')
@section('title', $datos->nombre )
@section('active-clasificacion', 'active')<!--ACTIVE DROP-->
@section('active-clasificacion-subcategoria', 'active')<!--ACTIVE LINK-->
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
                        <h4 class="page-title">@lang('idioma.gral_op_par'): <i> {{ $datos->nombre }} </i> </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="{{ route('dash') }}">{{$sistema->nombre_empresa}}</a>
                            </li>
                            <li>
                                <a href="{{ route('subcat') }}">@lang('idioma.subcateg_titulo')</a>
                            </li>
                            <li class="active">
                              @lang('idioma.gral_viendo'): {{ $datos->nombre }}
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
                                <div class="form-group">
                                    <label for="nombreCategoria">@lang('idioma.categ_titulo')</label>
                                    <input type="text" value="{{ $datos->categoria->nombre }}" class="form-control" readonly></input>
                                </div>
                                <div class="form-group">
                                    <label for="nombreSubCategoria">@lang('idioma.gral_nombre')</label>
                                    <input type="text" value="{{ $datos->nombre }}" class="form-control" readonly></input>
                                </div>
                                <a href="{{ route('subcat') }}"><button type="button" class="btn btn-default"><i class="fa fa-chevron-left"></i> @lang('idioma.gral_btn_atras') </button></a>

                                @if(Session::get("rol_id"))
                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->subcatego_e == 1)
                                        <a href="{{ route('subcat.edit',$datos->id) }}"><button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> @lang('idioma.gral_btn_edit') </button></a>
                                    @endif

                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->subcatego_b == 1)
                                        {{-- <a href="{{ route('subcat.destroy',$datos->id) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('idioma.gral_btn_borr') </button></a> --}}
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#subcatDeleteModal"><i class="fa fa-trash"></i> Delete </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->
<div class="modal fade" id="subcatDeleteModal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title text-center" id="ModalLongTitle"><span class="required">Delete Sub-Category</span><button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button></h2>
      </div>
      <div class="modal-body text-center">
        <p>Sub-Category to Delete: <b>{{ $datos->nombre }}</b></p>
        <a href="{{ route('subcat.destroy',$datos->id) }}"] class="btn btn-danger btn-lg">Click to Delete</a>
      </div>
      {{-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div> --}}
    </div>
  </div>
</div>
@endsection