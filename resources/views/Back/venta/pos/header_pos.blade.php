<!--CONSULTA DE PERMISOS SEGUN EL ROL-->
<?php 

    $permisos     = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();//PERMISOS
    $img_usuario  = \DB::table('users')->where('id', Session::get("usuario_id"))->first();//IMAGEN DE USUARIO
    $sistema      = \DB::table('configuracion')->where('id', 1)->first();//CONFIGURACION DEL SISTEMA
    $u_pendientes = \DB::table('users')->where('status', 2)->count();//CANTIDAD DE USUARIOS PENDIENTES
    $usuario_id   = Session::get("usuario_id");//ID DEL USUARIO EN LA SESSIOn

?>

<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container">

            <!-- Logo container-->
            <div class="logo">
            <!-- LOGO -->
            <div class="topbar-left">
                <a href="{{ route('dash') }}" class="logo"><span>{{$sistema->nombre_empresa}}</span></a>
            </div>

            </div>
            <!-- End Logo container-->

            <div class="menu-extras">
                
                @include('Back.common.sales_transfer_button')
                
                <ul class="nav navbar-nav navbar-right pull-right">
                   
                    <li class="dropdown navbar-c-items">
                        @if($img_usuario->imagen)
                            <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="{{ url('/storage/img_usuarios/'.$img_usuario->imagen) }}" alt="user-img" class="img-circle"> </a>

                        @else
                            <a href="" class="dropdown-toggle waves-effect waves-light profile" data-toggle="dropdown" aria-expanded="true"><img src="{{ url('/storage/img_usuarios/default.png') }}" alt="user-img" class="img-circle"> </a>
                        @endif
                        
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li>
                                <h5>{{Session::get("nombre")}}</h5>
                            </li>
                            <li><a href="{{ route('user.show',$usuario_id ) }}"><i class="ti-user m-r-5"></i> @lang('idioma.mi_perfil') </a></li>
                            <li><a href="{{ route('logout') }}"><i class="ti-power-off m-r-5"></i> @lang('idioma.salir') </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- end menu-extras -->

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
</header>
<!-- End Navigation Bar-->


