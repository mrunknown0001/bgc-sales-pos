<!DOCTYPE html>
<html>
     <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Inventario POO">
        <meta name="author" content="Oswaldo Gerardino">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('/Back/pos/images/favicon.ico') }}">
        <!-- App title -->
        <title>@yield('title')</title>

        <!-- Custom box css -->
        <link href="{{ asset('/Back/pos/custombox/css/custombox.min.css') }}" rel="stylesheet">

        <!-- App css -->
        <link href="{{ asset('/Back/pos/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/Back/pos/css/core.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/Back/pos/css/components.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/Back/pos/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/Back/pos/css/menu.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/Back/pos/css/estilos_pos.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/Back/pos/css/pages.css') }}" rel="stylesheet" type="text/css" />


        <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">

        <!--Fuente Robotica POS-->
        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One" rel="stylesheet">

        <!--ALERTAS-->
        <link rel="stylesheet" href="{{asset('/Back/alertifyjs/css/alertify.css')}}"></link>
        <link rel="stylesheet" href="{{asset('/Back/alertifyjs/css/themes/bootstrap.css')}}"></link>

        <!--Permisos-->
        <?php $permisos = \DB::table('permisos')->where('rol_id', Session::get("rol_id"))->first();?>

        <!--Sistema-->
        <?php $sistema  = \DB::table('configuracion')->where('id', 1)->first();?>
        
    </head>
    <body class="fixed-left" onload="reload()">
        <!-- Begin page -->
        <div id="wrapper">
            @include('Back.venta.pos.header_pos')

                @yield('content')
            
            @include('Back.venta.pos.footer_pos')
        </div>

        <!-- jQuery  -->
        <script src="{{ asset('/Back/pos/js/jquery.min.js') }}"></script>
        <script src="{{ asset('/Back/pos/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
        <!-- Realtime Js 
        <script src="{{ asset('/Back/pos/js/real_time_date.js') }}"></script>-->

        <!--
        ************************************************************************************
        ************************************************************************************
                                   _____           _       _       
                                  / ____|         (_)     | |      
                                 | (___   ___ _ __ _ _ __ | |_ ___ 
                                  \___ \ / __| '__| | '_ \| __/ __|
                                  ____) | (__| |  | | |_) | |_\__ \
                                 |_____/ \___|_|  |_| .__/ \__|___/
                                                    | |            
                                                    |_|

        DescripciÃ³n: CÃ³digos RAMDOM para la funcionalidad general del sistema.         
        ************************************************************************************
        ************************************************************************************
        -->

        <!--Limpiar todo al finalizar proceso-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#continuar').click(function (e) {

                    e.preventDefault();

                    //Vaciar elementos
                    $().load(vaciar_elementos());

                    //Recargar elementos vista principal
                    $("#proceso_exitoso").modal('hide');
                    $('#lista_productos_temporal tbody').load(reload());

                    //Refrescar vista
                    location.reload(true);

                });//Final Boton "Continuar"

            });//Final Ajax

        </script>

        <!--Activar/Desactivar boton "Pagar"-->
        <script type="text/javascript">
            $(document).ready(function() {
                $('#pagar').click(function (e) {

                    e.preventDefault();

                    //Variables
                    var cantidad           = $( "#cantidad_total" ).val();
                    var descuento          = $( "#descuento" ).val();
                    var forma_pago         = $( "#forma_pago" ).val();
                    var subtotal_cf        = $( "#subtotal_general" ).val();
                    var subtotal_sf        = $( "#subtotal_general_sf" ).val();
                    var div_total_modal_cf = $( "#div_total" ).text();
                    var total_sf           = $( "#total" ).val();
                    var cliente            = $( "#cliente" ).val();

                    //Vaciar valores modal
                    $('#modal_cantidad_productos').val('');
                    $('#modal_descuento').val('');
                    $('#modal_forma_pago').val('');
                    $('#modal_subtotal_cf').val('');
                    $('#modal_subtotal_sf').val('');
                    $('#modal_div_total_modal_cf').text('');
                    $('#modal_total_sf').val('');

                    //Cargar valores en la modal
                    $('#modal_cantidad_productos').val(cantidad);
                    $('#modal_descuento').val(descuento);
                    $('#modal_forma_pago').val(forma_pago);
                    $('#modal_subtotal_cf').val(subtotal_cf);
                    $('#modal_subtotal_sf').val(subtotal_sf);
                    $('#modal_div_total_modal_cf').append(div_total_modal_cf);
                    $('#modal_total_sf').val(total_sf);

                    //Si el total es mayor a 0.00 mostrar la modal del proceso, sino mostrar la modal de alerta
                    if(total_sf > 0.00 && cliente != null){

                        //Dar atributos de modal al boton pagar
                        $('#pagar').attr({
                            'data-toggle': 'modal',
                            'data-target': '#con-close-modal'
                        });

                    }else{
                        //Quitar atributos del botÃ³n pagar y mostrar la modal
                        $('#pagar').removeAttr('data-toggle');
                        $('#pagar').removeAttr('data-target');
                        $('#modal_cero').modal({
                            show: 'true'
                        });

                    }//Final Else

                });//Final Ajax

            });//Final Ajax

        </script>

        <!--VALIDAR SOLO NUMEROS EN EL INPUT-->
        <script type="text/javascript">
            function valida(e){
                tecla = (document.all) ? e.keyCode : e.which;

                //Tecla de retroceso para borrar, siempre la permite
                if (tecla==8){
                    return true;
                }
                    
                // Patron de entrada, en este caso solo acepta numeros
                patron =/[0-9]/;
                tecla_final = String.fromCharCode(tecla);
                return patron.test(tecla_final);
            }
        </script>

         <!--VALIDAR SOLO NUMEROS DE PRECIOS EN EL INPUT-->
        <script type="text/javascript">

            function filterFloat(evt,input){
                // Backspace = 8, Enter = 13, â€˜0â€² = 48, â€˜9â€² = 57, â€˜.â€™ = 46, â€˜-â€™ = 43
                var key = window.Event ? evt.which : evt.keyCode;    
                var chark = String.fromCharCode(key);
                var tempValue = input.value+chark;
                if(key >= 48 && key <= 57){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
                }else{
                      if(key == 8 || key == 13 || key == 0) {     
                          return true;              
                      }else if(key == 46){
                            if(filter(tempValue)=== false){
                                return false;
                            }else{       
                                return true;
                            }
                      }else{
                          return false;
                      }
                }
            }
            function filter(__val__){
                var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
                if(preg.test(__val__) === true){
                    return true;
                }else{
                   return false;
                }
                
            }

        </script>

        <!--
        ************************************************************************************
        ************************************************************************************
                             
                      ______ _             _    _____           _       _       
                     |  ____(_)           | |  / ____|         (_)     | |      
                     | |__   _ _ __   __ _| | | (___   ___ _ __ _ _ __ | |_ ___ 
                     |  __| | | '_ \ / _` | |  \___ \ / __| '__| | '_ \| __/ __|
                     | |    | | | | | (_| | |  ____) | (__| |  | | |_) | |_\__ \
                     |_|    |_|_| |_|\__,_|_| |_____/ \___|_|  |_| .__/ \__|___/
                                                                 | |            
                                                                 |_|            

        ************************************************************************************
        ************************************************************************************
        -->

        <!--
        ************************************************************************************
        ************************************************************************************       
                                               _                
                                         /\   (_)               
                                        /  \   _  __ ___  _____ 
                                       / /\ \ | |/ _` \ \/ / __|
                                      / ____ \| | (_| |>  <\__ \
                                     /_/    \_\ |\__,_/_/\_\___/
                                             _/ |               
                                            |__/                
      
        DescripciÃ³n: Funciones ajax del sistema.
        ************************************************************************************
        ************************************************************************************
        -->


         <!--
            *******************************************************************
                                    EVENTOS DEL AJAX:

            1- FunciÃ³n: BotÃ³n Agregar Productos.
                * DescripciÃ³n: Al dar click en el botÃ³n, te carga un listado de los Ãºltimos 10 productos registrados dentro de la ventana modal.

            2- FunciÃ³n: BotÃ³n Insertar Productos.
                * DescripciÃ³n: Registra productos dentro de la TABLA TEMPORALES para listar las selecciones del usuario, e irlas mostrando en el listado de facturaciÃ³n de la vista principal.

            3- FunciÃ³n: Input Buscar Productos.
                * DescripciÃ³n: Busca coincidencias de los productos registrados y los muestra en la lista de productos de la ventana modal.

            4- FunciÃ³n: BotÃ³n Agregar nuevo producto.
                * DescripciÃ³n: Da la opciÃ³n al usuario de registrar un nuevo producto, Ãºnicamente si el usuario tiene los permisos para registrar productos, de lo contrario, no muestra nada.

            5- FunciÃ³n: Input Descuento.
                * DescripciÃ³n: Permite ingresar en forma numÃ©rica un valor porcentual, en base al cual serÃ¡ calculado un nuevo "Total" luego de una operaciÃ³n matemÃ¡tica.

            6- FunciÃ³n: BotÃ³n Eliminar producto.
                * DescripciÃ³n: Elimina el producto seleccionado del listado de la vista principal y de la BD TEMPORALES.

            7- FunciÃ³n: Boton Procesar ahora.
                * DescripciÃ³n: Se procesan los datos calculados y registrados en el formulario de facturaciÃ³n.

            8- FunciÃ³n: Boton Confirmar Vaciar.
            * DescripciÃ³n: Se procesan los datos calculados y registrados en el formulario de facturaciÃ³n.

            9- Funciones Complementarias con AJAX.
                * DescripciÃ³n: Comprenden las funciones que son llamadas desde dentro de las otras las funcionalidades.

            *******************************************************************
        -->
        <script type="text/javascript">

            $(document).ready(function() {

                /*
                     
                *******************************************************************
                *******************************************************************
                                 1- FunciÃ³n: BotÃ³n Agregar Productos.
                *******************************************************************
                *******************************************************************

                */
                $('#agregar_productos').click(function (e) {

                    e.preventDefault();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'get',
                        url: "{{url('/venta_cargar_lista_productos')}}",

                        beforeSend: function(){
                            // DescripciÃ³n: Limpia el TBODY y mostrar un loading
                            $('#tabla_productos_pos tbody').empty();//Vaciar
                            $('#tabla_productos_pos tbody').append('<tr><td colspan="5" style="text-align:center; font-size:30pt;"><i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span></td></tr>');//Loading

                        },
                        success: function(data) {

                            //Quitar el loading
                            $('#tabla_productos_pos tbody').empty();//Vaciar

                            var  productos = $.parseJSON(data);

                            //Si se encuentran productos mostrar
                            if(productos.length > 0){

                                $.each(productos, function(i, d) {

                                    //Mostrar en la modal los Ãºltimos 10 productos registrados
                                    $('#tabla_productos_pos tbody').append('<tr><td><input type="text" value="'+d.codigo+'" id="codigo'+i+'" class="form-control input_codigo" readonly></td><td><div id="factura_producto" class="input_nombre">'+d.nombre+'<input type="hidden" value="'+d.id+'" id="producto_id'+i+'"><input type="hidden" value="'+d.tributo_id+'" id="tributo_id'+i+'"></div></td><td>'+d.cantidad+'</td><td>'+d.uom.uom+'</td><td><input type="text" value="1" id="cantidad'+i+'" class="form-control input_cantidad" onkeypress="return valida(event)"></td><td><input type="text" value="'+d.precio_publico+'" id="precio_publico'+i+'" class="form-control input_costo_unidad" readonly></td><td><a href="javascript:void" value="'+i+'" id="boton_insertar'+i+'" class="btn btn-info waves-effect"><i class="fa fa-plus"></i></a></td></tr><tr class="validacion_productos_modal_error" display:none" id="error'+i+'"><td colspan="7"></td></tr><tr class="validacion_productos_modal_success" display:none" id="success'+i+'"><td colspan="7"></td></tr>');

                                    /*
                     
                                    *******************************************************************
                                    *******************************************************************
                                                     2- funciÃ³n: BotÃ³n Insertar Productos.
                                    *******************************************************************
                                    *******************************************************************

                                    */
                                    $('#boton_insertar'+i).on('click', function(evt) {
                                            
                                            evt.preventDefault();

                                            var producto_id    = $( "#producto_id"+i ).val();
                                            var tributo_id     = $( "#tributo_id"+i ).val();
                                            var cantidad       = $( "#cantidad"+i ).val();
                                            var precio_publico = $( "#precio_publico"+i ).val();

                                            $.ajaxSetup({
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });

                                            $.ajax({

                                                type: 'get',
                                                url: "{{url('/venta_insertar_producto_temporal')}}",
                                                data: {

                                                    'producto_id'    : producto_id,
                                                    'tributo_id'     : tributo_id,
                                                    'cantidad'       : cantidad,
                                                    'precio_publico' : precio_publico,

                                                },
                                                beforeSend: function(){
                                                    // DescripciÃ³n: Limpia el TBODY y mostrar un loading
                                                    $('#boton_insertar'+i).empty();//Vaciar
                                                    $('#boton_insertar'+i).append('<i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span>');//Loading
                                                },
                                                success: function(data) {

                                                    //Si el valor de la cantidad esta vacio
                                                    if(data == "cantidad_vacia"){

                                                         $('#error'+i).css('display', '');//Mostrar elemento
                                                         $('#error'+i+' td').empty();//Vaciar
                                                         $('#error'+i+' td').append("@lang('idioma.pos_cant_vacia')");//Mostrar texto error

                                                         //Esperar 3 segundos y ocultar elemento
                                                         setTimeout(function(){
                                                            $('#error'+i).css('display', 'none');
                                                         }, 3000);

                                                    }//Si la cantidad ingresada es superior al stock
                                                    else if(data == "stock"){

                                                        $('#error'+i).css('display', '');//Mostrar elemento                 
                                                        $('#error'+i+' td').empty();//Vaciar
                                                        $('#error'+i+' td').append("@lang('idioma.pos_no_stock')");//Mostrar texto mensaje

                                                        //Esperar 3 segundos y ocultar elemento
                                                        setTimeout(function(){
                                                            $('#error'+i).css('display', 'none');
                                                        }, 3000);

                                                    }

                                                    //Si el ingreso del producto a la factura es exitoso
                                                    else if(data == "ok"){

                                                         //Recargar elementos vista principal
                                                         $('#lista_productos_temporal tbody').load(reload());

                                                         $('#success'+i).css('display', '');//Mostrar elemento                   
                                                         $('#success'+i+' td').empty();//Vaciar
                                                         $('#success'+i+' td').append("@lang('idioma.pos_agregado')");//Mostrar texto mensaje
                                                         // new code added value to discount
                                                         posdiscount();
                                                         //Esperar medio segundos y ocultar elemento
                                                         setTimeout(function(){
                                                            $('#success'+i).css('display', 'none');
                                                         }, 500);

                                                    }

                                                },
                                                complete:function(data){

                                                    $('#boton_insertar'+i).empty();//Vaciar 
                                                    $('#boton_insertar'+i).append('<i class="fa fa-check"></i>');//Mostrar un check
                                                    // when adding item on card
                                                    posdiscount();
                                                    //Esperar 3 segundos y mostrar elemento con plus (+)
                                                    setTimeout(function(){
                                                        $('#boton_insertar'+i).empty();//Vaciar 
                                                        $('#boton_insertar'+i).append('<i class="fa fa-plus"></i>');//PLUS
                                                    }, 3000);

                                                }

                                            });//Final Ajax

                                     });//Final Ajax BotÃ³n "Insertar"
                                    
                                });//Final Each
                            
                            /*
                     
                            *******************************************************************
                            *******************************************************************
                                         4- FunciÃ³n: BotÃ³n Agregar nuevo producto.
                            *******************************************************************
                            *******************************************************************

                            */
                            }else{

                                @if(Session::get("rol_id"))

                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->producto_r == 1)

                                        $('#tabla_productos_pos tbody').append('<tr><td colspan="5"><div class="no_encontrados col-md-12"> @lang("idioma.pos_no_exis_r") <a href="{{ route('product.new') }}" class="btn btn-primary"><i class="mdi mdi-plus"></i>@lang("idioma.gral_registrar")</a></div></td></tr>');

                                    @else

                                        $('#tabla_productos_pos tbody').append('<tr><td colspan="5"><div class="no_encontrados col-md-12">@lang("idioma.pos_no_exis")</div></td></tr>');//Mostrar mensaje sin botÃ³n

                                    @endif

                                @endif
                            }//Final Else

                        }//Final Success

                    });//Final Ajax

                });//Final BotÃ³n "AGREGAR PRODUCTOS"

                /*
                     
                    *******************************************************************
                    *******************************************************************
                                    3- FunciÃ³n: Input Buscar Productos.
                    *******************************************************************
                    *******************************************************************

                */

                $('#buscar_producto').keyup(function (e) {

                    e.preventDefault();

                    var busqueda = $( "#buscar_producto" ).val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'get',
                        url: "{{url('/venta_buscar_productos')}}",
                        data: {
                            'busqueda' : busqueda,
                        },
                        beforeSend: function(){

                           //Tabla de la ventana modal
                            $('#tabla_productos_pos tbody').empty();//Vaciar
                            $('#tabla_productos_pos tbody').append('<tr><td colspan="5" style="text-align:center; font-size:30pt;"><i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span></td></tr>');//Loading

                        },
                        success: function(data) {
                            
                            //Quitar el Loading
                            $('#tabla_productos_pos tbody').empty();//Vaciar

                            var  productos = $.parseJSON(data);

                            if(productos.length > 0){

                                $.each(productos, function(i, d) {

                                    //Mostrar listado de productos encontrados en el Seach, en la ventana modal
                                    $('#tabla_productos_pos tbody').append('<tr><td><input type="text" value="'+d.codigo+'" id="codigo'+i+'" class="form-control input_codigo" readonly></td><td><div id="factura_producto" class="input_nombre">'+d.nombre+'<input type="hidden" value="'+d.id+'" id="producto_id'+i+'"><input type="hidden" value="'+d.tributo_id+'" id="tributo_id'+i+'"></div></td><td>'+d.cantidad+'</td><td>'+d.uom.uom+'</td><td><input type="text" value="1" id="cantidad'+i+'" class="form-control input_cantidad" onkeypress="return valida(event)"></td><td><input type="text" value="'+d.precio_publico+'" id="precio_publico'+i+'" class="form-control input_costo_unidad" readonly></td><td><a href="javascript:void" value="'+i+'" id="boton_insertar'+i+'" class="btn btn-info waves-effect"><i class="fa fa-plus"></i></a></td></tr><tr class="validacion_productos_modal_error" display:none" id="error'+i+'"><td colspan="7"></td></tr><tr class="validacion_productos_modal_success" display:none" id="success'+i+'"><td colspan="7"></td></tr>');

                                    /*
                     
                                        *******************************************************************
                                        *******************************************************************
                                                         2- funciÃ³n: BotÃ³n Insertar Productos.
                                        *******************************************************************
                                        *******************************************************************

                                    */

                                    $('#boton_insertar'+i).on('click', function(evt) {
                                            
                                        evt.preventDefault();

                                        var producto_id    = $( "#producto_id"+i ).val();
                                        var tributo_id     = $( "#tributo_id"+i ).val();
                                        var cantidad       = $( "#cantidad"+i ).val();
                                        var precio_publico = $( "#precio_publico"+i ).val();

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({

                                            type: 'get',
                                            url: "{{url('/venta_insertar_producto_temporal')}}",
                                            data: {

                                                'producto_id'    : producto_id,
                                                'tributo_id'     : tributo_id,
                                                'cantidad'       : cantidad,
                                                'precio_publico' : precio_publico,

                                            },
                                            beforeSend: function(){
                                               // DescripciÃ³n: Limpia el TBODY y mostrar un loading
                                                $('#boton_insertar'+i).empty();//Vaciar
                                                $('#boton_insertar'+i).append('<i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span>');//Loading
                                            },
                                            success: function(data) {

                                                //Si el valor de la cantidad esta vacio
                                                if(data == "cantidad_vacia"){

                                                     $('#error'+i).css('display', '');//Mostrar elemento                  
                                                     $('#error'+i+' td').empty();//Vaciar
                                                     $('#error'+i+' td').append("@lang('idioma.pos_cant_vacia')");//Mostrar texto mensaje

                                                     //Esperar 3 segundos y ocultar elemento
                                                     setTimeout(function(){
                                                        $('#error'+i).css('display', 'none');
                                                     }, 3000);

                                                }
                                                //Si la cantidad ingresada es superior al stock
                                                else if(data == "stock"){

                                                     $('#error'+i).css('display', '');//Mostrar elemento                 
                                                     $('#error'+i+' td').empty();//Vaciar
                                                     $('#error'+i+' td').append("@lang('idioma.pos_no_stock')");//Mostrar texto mensaje

                                                     //Esperar 3 segundos y ocultar elemento
                                                     setTimeout(function(){
                                                        $('#error'+i).css('display', 'none');
                                                     }, 3000);

                                                }
                                                //Si el ingreso del producto a la factura es exitoso
                                                else if(data == "ok"){

                                                     //actualizar la lista de productos
                                                     $('#lista_productos_temporal tbody').load(reload());

                                                     $('#success'+i).css('display', '');                     
                                                     $('#success'+i+' td').empty();//Vaciar
                                                     $('#success'+i+' td').append("@lang('idioma.pos_agregado')");//Mostrar texto mensaje

                                                     //Esperar medio segundo y ocultar elemento
                                                     setTimeout(function(){
                                                        $('#success'+i).css('display', 'none');
                                                     }, 500);

                                                }

                                            },
                                            complete:function(data){

                                                $('#boton_insertar'+i).empty();//Vaciar
                                                $('#boton_insertar'+i).append('<i class="fa fa-check"></i>');//Mostrar Check
                                                
                                                //Esperar 3 segundos y mostrar elemento con plus (+)
                                                setTimeout(function(){
                                                    $('#boton_insertar'+i).empty();//Vaciar
                                                    $('#boton_insertar'+i).append('<i class="fa fa-plus"></i>');//Mostr
                                                }, 3000);

                                            }//Final Complete

                                        });//Final Ajax

                                    });//Final Ajax BotÃ³n "Insertar"

                                });//Final Each

                            /*
                     
                            *******************************************************************
                            *******************************************************************
                                         4- FunciÃ³n: BotÃ³n Agregar nuevo producto.
                            *******************************************************************
                            *******************************************************************

                            */
                            }else{

                                @if(Session::get("rol_id"))

                                    @if(Session::get("rol_id") == 1 or Session::get("rol_id") == 2 or $permisos->producto_r == 1)

                                        $('#tabla_productos_pos tbody').append('<tr><td colspan="5"><div class="no_encontrados col-md-12"> @lang("idioma.pos_no_exis_r") <a href="{{url ('/nuevo-producto')}}" class="btn btn-primary "><i class="mdi mdi-plus"></i>@lang("idioma.gral_registrar")</a></div></td></tr>');

                                    @else

                                        $('#tabla_productos_pos tbody').append('<tr><td colspan="5"><div class="no_encontrados col-md-12">@lang("idioma.pos_no_exis")</div></td></tr>');//Mostrar mensaje sin botÃ³n

                                    @endif

                                @endif
                            
                            }//Final Else

                        },//Final Success

                    });//Final Ajax

                });//Final Input "BUSCAR PRODUCTOS"

                /*
                     
                    *******************************************************************
                    *******************************************************************
                                       5- FunciÃ³n: Input Descuento.
                    *******************************************************************
                    *******************************************************************

                */
                $('#descuento').change(function (e) {

                    e.preventDefault();

                    var descuento  = $( "#descuento" ).val();
                    var usuario_id = {{Session::get("usuario_id")}};

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'get',
                        url: "{{url('/venta_descuento')}}",
                        data: {
                            'descuento'           : descuento,
                            'usuario_id'          : usuario_id
                        },

                        beforeSend: function(){  
                           
                            $('#div_total').empty();//Vaciar
                            $('#div_total').append('@lang("idioma.pos_calculando")');//Mostrar texto en el Total
                            $('#total').val();//Vaciar valor del input

                        },

                        success: function(data) {

                           //Si el Input Descuento estÃ¡ vacio o es cero, muestra el valor subtotal en el total
                           if(data['total'] == "vacio"){
                                $('#descuento').val(0);
                                $('#div_total').empty();//Vaciar
                                $('#total').val();//Vaciar
                                $('#div_total').append(data['total_con_formato']);
                                $('#total').val(data['total_sin_formato']);

                           }
                           //Si el Input Descuento es correcto, mostrar calculo en el total
                           else if(data['total'] == "ok"){

                                $('#div_total').empty();//Vaciar
                                $('#total').val();//Vaciar
                                $('#div_total').append(data['total_con_formato']);
                                $('#total').val(data['total_sin_formato']);

                                // add discount here
                                $('#descuento').val(data['discount']);

                           }//Final Else


                        },//Final Success

                    });//Final Ajax

                });//Final Input "DESCUENTO"

                // custom discountfunction

                /*
                *******************************************************************
                *******************************************************************
                                7- FunciÃ³n: Boton Procesar ahora
                *******************************************************************
                *******************************************************************
                */

                 $('#procesarAhora').click(function (e) {

                    e.preventDefault();

                    codigo_proceso = $( "#codigo_proceso" ).val();
                    cliente_id     = $( "#cliente" ).val();
                    usuario_id     = {{Session::get("usuario_id")}};
                    subtotal       = $( "#modal_subtotal_sf" ).val();
                    descuento      = $( "#modal_descuento" ).val();
                    total          = $( "#modal_total_sf" ).val();
                    tipo_pago      = $( "#modal_forma_pago" ).val();
                    comentario     = $( "#modal_comentario" ).val();
                    items_totales  = $( "#items_totales" ).val();
                    regis_totales  = $( "#registros_totales" ).val();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'get',
                        url: "{{url('/venta_procesar_compra')}}",
                        data: {

                            'codigo_proceso': codigo_proceso,
                            'cliente_id'    : cliente_id,
                            'usuario_id'    : usuario_id,
                            'subtotal'      : subtotal,
                            'descuento'     : descuento,
                            'total'         : total,
                            'tipo_pago'     : tipo_pago,
                            'comentario'    : comentario,
                            'items_totales' : items_totales,
                            'regis_totales' : regis_totales

                        },

                        beforeSend: function(){  
                           
                           $('#procesarAhora').empty();//Vaciar
                           $('#procesarAhora').append('@lang("idioma.dat_procesa") <i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span>');//Loading

                        },

                        success: function(data) {

                            if(data == "procesada"){

                               $("#con-close-modal").modal('hide');

                               $('#proceso_exitoso').modal({
                                    show: 'true',
                                    backdrop: 'static',
                                    keyboard: false
                               });



                            }else{


                            }


                        },//Final Success

                        complete: function(data){

                           $('#procesarAhora').empty();//Vaciar
                           $('#procesarAhora').append('Completado <i class="fa fa-check"></i>');//Loading

                        }//Final Complete

                    });//Final Ajax

                });//Final Input "Procesar ahora"

            /*
            *******************************************************************
            *******************************************************************
                           7- Final FunciÃ³n: Boton Procesar ahora
            *******************************************************************
            *******************************************************************
            */

            /*
            *******************************************************************
            *******************************************************************
                            7- FunciÃ³n: Boton Procesar ahora
            *******************************************************************
            *******************************************************************
            */

             $('#confirmar_vaciar').click(function (e) {

                e.preventDefault();

                var usuario_id     = {{Session::get("usuario_id")}};

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({

                    type: 'get',
                    url: "{{url('/venta_vaciar_lista_principal')}}",
                    data: {

                        'usuario_id'    : usuario_id

                    },

                    beforeSend: function(){  
                       
                       $('#confirmar_vaciar').empty();//Vaciar
                       $('#confirmar_vaciar').append('<i class="fa fa-spinner fa-spin fa-x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span>');//Loading

                    },

                    success: function(data) {

                        if(data == "vacia"){

                            //Mostrar Check
                            $('#confirmar_vaciar').empty();//Vaciar
                            $('#confirmar_vaciar').append('<i class="fa fa-check"></i>');//Check

                            //Cerrar modal
                            $("#modal_vaciar").modal('hide');

                            //Recagar elementos
                            $('#lista_productos_temporal tbody').load(reload());

                            //Vaciar elementos
                            $().load(vaciar_elementos());
                
                        }

                    },//Final Success

                    complete: function(data){

                       $('#confirmar_vaciar').empty();//Vaciar
                       $('#confirmar_vaciar').append('<i class="fa fa-thumbs-up"></i>');//like

                    }//Final Complete

                });//Final Ajax

            });//Final Input "Procesar ahora"

            /*
            *******************************************************************
            *******************************************************************
                           7- Final FunciÃ³n: Boton Procesar ahora
            *******************************************************************
            *******************************************************************
            */

            });//Final "DOCUMENT READY"

        </script>

        <!--
            *******************************************************************
            *******************************************************************
                            8- Funciones Complementarias con AJAX
            *******************************************************************
            *******************************************************************
        -->

          <script type="text/javascript">

            function reload(){

                $(document).ready(function(e) {

                    //e.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'get',
                        url: "{{url('/venta_cargar_lista_productos_temporal')}}",

                        beforeSend: function(){

                            //Elementos listado de productos de la vista principal
                            $('#lista_productos_temporal tbody').empty();//Vaciar
                            $('#lista_productos_temporal tbody').append('<tr><td colspan="6" style="text-align:center; font-size:30pt;"><i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span></td></tr>');//Loading

                        },
                        success: function(data) {
                            //Quitar el loading
                            
                            $('#lista_productos_temporal tbody').empty();//VARIAR LOS ELEMENTOS

                            var  productos    = $.parseJSON(data);
                            // console.log(productos);
                            if(productos){
                                $.each(productos, function(i, d) {//d = valor - i = indice
                                    //separador de elementos en un array
                                    var datos = d.split("|");
                                    
                                    //Simbolo del triburo
                                    if(datos[7] == "Percentage"){
                                        simbolo = "%";
                                    }else{
                                        simbolo = "bsf";
                                    }

                                    //Limpiar y mostrar cantidades

                                    $('#descuento').val(0);//Vaciar inpur descuento


                                    if(datos[10] > 0){
                                        $('#cantidad_total').val();
                                        $('#cantidad_total').val(datos[10]+' ('+datos[11]+')')

                                        //Llena inputs individuales
                                        $('#items_totales').val();
                                        $('#items_totales').val(datos[11]);
                                        $('#registros_totales').val();
                                        $('#registros_totales').val(datos[10]);

                                    }else{
                                        $('#cantidad_total').val(0);
                                    }


                                    //Mostrar productos en la lista de la vista principal
                                    $('#lista_productos_temporal tbody').append('<tr><td>'+datos[0]+'</td><td>'+datos[1]+'</td><td>'+datos[16]+'</td><td>'+datos[2]+'</td><td>'+datos[3]+'</td><td>'+datos[4]+' '+simbolo+'</td><td>'+datos[13]+'</td><td>'+datos[6]+'</td><td><a href="javascript:void" id="boton_eliminar'+datos[5]+'" class="btn btn-danger waves-effect"><i class="fa fa-minus"></i></a></td></tr>');

                                    //Carga de los valores para el subtotal
                                    $('#subtotal_general').val(datos[8]);
                                    $('#subtotal_general_sf').val(datos[9]);

                                    //Actualizar cÃ³digo
                                    $('#codigo').empty();
                                    $('#codigo').append(datos[12]);
                                    $('#codigo_proceso').val('');
                                    $('#codigo_proceso').val(datos[12]);

                                    //total de impuestos
                                    $('#impuestos_totales').val();
                                    $('#impuestos_totales').val(datos[14]);
                                    
                                    //total sin impuestos
                                    $('#subtotal_general_si').val();
                                    $('#subtotal_general_si').val(datos[15]);

                                    //Cargar funcion reload_total
                                    $().load(reload_total());
                                    // on load of page
                                    posdiscount();

                                    //6- FunciÃ³n: BotÃ³n Eliminar producto.
                                    $('#boton_eliminar'+datos[5]).on('click', function(e) {

                                        e.preventDefault();

                                        var id = datos[5];

                                        $.ajaxSetup({
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            }
                                        });

                                        $.ajax({

                                            type: 'get',
                                            url: "{{url('/venta_eliminar_producto_temporal')}}",
                                            data: {

                                                'id' : id,

                                            },
                                            beforeSend: function(){
                                               
                                                $('#boton_eliminar'+datos[5]).empty();//Vaciar
                                                $('#boton_eliminar'+datos[5]).append('<i class="fa fa-spinner fa-spin fa-1x fa-fw margin-bottom"></i><span class="sr-only">@lang("idioma.dat_cargando")...</span>');//Loading
                                            },
                                            success: function(data) {

                                                //Si el producto es eliminado exitosamente
                                                if(data == "eliminado"){

                                                     //Actualizar la lista de productos de la vista principal, y los campos total, subtotal y cantidad
                                                     $('#div_total').empty();//Vaciar
                                                     $('#div_total').append('0.00');//Vaciar
                                                     $('#total').val('');//Vaciar input 
                                                     $('#total').val("0.00");//Vaciar input total
                                                     $('#cantidad_total').val(0);
                                                     $('#subtotal_general').val('');
                                                     $('#subtotal_general_sf').val('');
                                                     $('#subtotal_general').val('0.00');
                                                     $('#subtotal_general_sf').val('0.00');
                                                     $('#descuento').val(0);//Vaciar inpur descuento
                                                     $('#impuestos_totales').val('0.00');
                                                     $('#subtotal_general_si').val('0.00');
                                                     $('#lista_productos_temporal tbody').load(reload());

                                                }//Final If
                                                // remove item on cart
                                                posdiscount();
                                            }//Final Success

                                        });//Final Ajax

                                    });//Final Ajax BotÃ³n "Eliminar"

                                });//Final Each

                            }//Final IF existencia productos en la lista



                        },//Final Success

                    });//Final Ajax
                    
                });//Final "DOCUMENT READY"

            }//Final funcion REALOAD
          </script>

          <script type="text/javascript">

            function reload_total(){

                $(document).ready(function() {

                    var usuario_id = {{Session::get("usuario_id")}};
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({

                        type: 'get',
                        url: "{{url('/venta_total')}}",
                        data: {

                            'usuario_id' : usuario_id,

                        },

                        beforeSend: function(){
                           
                            $('#div_total').empty();//Vaciar
                            $('#total').val('');//Vaciar valor del input
                            $('#div_total').append('@lang("idioma.pos_calculando")');//Mostrar texto en el Total

                        },
                        success: function(data) {

                            $('#div_total').empty();//Vaciar
                            $('#total').val('');//Vaciar valor del input
                            $('#div_total').append(data.total_cf);
                            $('#total').val(data.total_sf);

                        }//Final Success

                    });//Final Ajax

                });//Final "DOCUMENT READY"

            }//Final Funcion reload_total
          </script>


        <!--Vaciar elementos-->
        <script type="text/javascript">
            function vaciar_elementos(){

                $(document).ready(function() {

                    //Vaciar valores modal
                    $('#modal_cantidad_productos').val('');
                    $('#modal_descuento').val('');
                    $('#modal_forma_pago').val('');
                    $('#modal_subtotal_cf').val('');
                    $('#modal_subtotal_sf').val('');
                    $('#modal_div_total_modal_cf').text('');
                    $('#modal_total_sf').val('');
                    $('#modal_comentario').val('');

                    //Vaciar right side
                    $('#subtotal_general').val('');
                    $('#subtotal_general').val('0.00');
                    $('#subtotal_general_sf').val('');
                    $('#subtotal_general_sf').val('0.00');
                    $('#forma_pago').val('');
                    $("#forma_pago").val("efectivo").change();
                    $('#cantidad_total').val('');
                    $('#cantidad_total').val(0);
                    $('#items_totales').val('');
                    $('#items_totales').val(0.00);
                    $('#registros_totales').val('');
                    $('#registros_totales').val(0);
                    $('#div_total').empty();
                    $('#div_total').append('0.00');
                    $('#total').val('');
                    $('#total').val(0.00); 
                    $('#impuestos_totales').val('0.00');
                    $('#subtotal_general_si').val('0.00');

                });//Final "DOCUMENT READY"

            }//Cierre funcion vaciar_elementos
        </script>


        <script>
            function posdiscount() {
                // alert();
                // e.preventDefault();

                var descuento  = 1;
                var usuario_id = {{Session::get("usuario_id")}};

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({

                    type: 'get',
                    url: "{{url('/venta_descuento')}}",
                    data: {
                        'descuento'           : descuento,
                        'usuario_id'          : usuario_id
                    },

                    beforeSend: function(){  
                       
                        $('#div_total').empty();//Vaciar
                        $('#div_total').append('@lang("idioma.pos_calculando")');//Mostrar texto en el Total
                        $('#total').val();//Vaciar valor del input

                    },

                    success: function(data) {

                       //Si el Input Descuento estÃ¡ vacio o es cero, muestra el valor subtotal en el total
                       if(data['total'] == "vacio"){
                            $('#descuento').val(0);
                            $('#div_total').empty();//Vaciar
                            $('#total').val();//Vaciar
                            $('#div_total').append(data['total_con_formato']);
                            $('#total').val(data['total_sin_formato']);

                       }
                       //Si el Input Descuento es correcto, mostrar calculo en el total
                       else if(data['total'] == "ok"){

                            $('#div_total').empty();//Vaciar
                            $('#total').val();//Vaciar
                            $('#div_total').append(data['total_con_formato']);
                            $('#total').val(data['total_sin_formato']);

                            // add discount here
                            $('#descuento').val(data['discount']);

                       }//Final Else


                    },//Final Success

                });//Final Ajax

            }//end custom discount function
        </script>


        <!--
            *******************************************************************
            *******************************************************************
                         Final Funciones Complementarias con AJAX
            *******************************************************************
            *******************************************************************
        -->

        <!--
        ************************************************************************************
        ************************************************************************************                          
                          ______ _             _            _            
                         |  ____(_)           | |     /\   (_)           
                         | |__   _ _ __   __ _| |    /  \   _  __ ___  __
                         |  __| | | '_ \ / _` | |   / /\ \ | |/ _` \ \/ /
                         | |    | | | | | (_| | |  / ____ \| | (_| |>  < 
                         |_|    |_|_| |_|\__,_|_| /_/    \_\ |\__,_/_/\_\
                                                          _/ |           
                                                         |__/           
        ************************************************************************************
        ************************************************************************************
        -->

    </body>
</html>