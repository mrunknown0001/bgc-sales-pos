<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('configuracion')->insert([
            'id'                       => 1,
            'nombre_empresa'           => "EGG STORE",
            'branch'                   => "BUROT",
            'branch_code'              => "E1", // Egg Store 1
            'slogan'                   => "Inventory, POS & Stock Control",
            'codigo_empresa'           => "1",
            'telefono'                 => "000000000",
            'idioma'                   => "en",
            'correo'                   => "eggstore@bfcgroup.org",
            'moneda'                   => "PHP",
            'tributo'                  => "Inactivo", //Activo e Inactivo
            'recuperar_clave_login'    => "off",
            'registro_usuario_login'   => "off",
        ]);

        DB::table('roles')->insert([
            'id'       => 1,
            'nombre'   => "SUPERADMIN",
            'status'   => 1,
        ]);

        DB::table('roles')->insert([
        'id'       => 2,
        'nombre'   => "ADMINISTRADOR",
        'status'   => 1,
        ]);

        DB::table('roles')->insert([
            'id'       => 3,
            'nombre'   => "User",
            'status'   => 1,
        ]);

        DB::table('permisos')->insert([
            'id'          => 1,
            'catego_i'    => 1,
            'catego_r'    => 1,
            'catego_e'    => 1,
            'catego_b'    => 1,
            'subcatego_i' => 1,
            'subcatego_r' => 1,
            'subcatego_e' => 1,
            'subcatego_b' => 1,
            'producto_i'  => 1,
            'producto_r'  => 1,
            'producto_e'  => 1,
            'producto_b'  => 1,
            'gasto_i'     => 1,
            'gasto_r'     => 1,
            'gasto_e'     => 1,
            'gasto_b'     => 1,
            'kardex_i'    => 1,
            'venta_i'     => 1,
            'venta_r'     => 1,
            'compra_i'    => 1,
            'compra_r'    => 1,
            'persona_i'   => 1,
            'reporte_i'   => 1,
            'rol_id'      => 1,
        ]);

        DB::table('permisos')->insert([
            'id'          => 2,
            'catego_i'    => 1,
            'catego_r'    => 1,
            'catego_e'    => 1,
            'catego_b'    => 1,
            'subcatego_i' => 1,
            'subcatego_r' => 1,
            'subcatego_e' => 1,
            'subcatego_b' => 1,
            'producto_i'  => 1,
            'producto_r'  => 1,
            'producto_e'  => 1,
            'producto_b'  => 1,
            'gasto_i'     => 1,
            'gasto_r'     => 1,
            'gasto_e'     => 1,
            'gasto_b'     => 1,
            'kardex_i'    => 1,
            'venta_i'     => 1,
            'venta_r'     => 1,
            'compra_i'    => 1,
            'compra_r'    => 1,
            'persona_i'   => 1,
            'reporte_i'   => 1,
            'rol_id'      => 2,
        ]);

        DB::table('permisos')->insert([
            'id'          => 3,
            'catego_i'    => 1,
            'catego_r'    => 1,
            'catego_e'    => 1,
            'catego_b'    => 1,
            'subcatego_i' => 1,
            'subcatego_r' => 1,
            'subcatego_e' => 1,
            'subcatego_b' => 1,
            'producto_i'  => 1,
            'producto_r'  => 1,
            'producto_e'  => 1,
            'producto_b'  => 1,
            'gasto_i'     => 1,
            'gasto_r'     => 1,
            'gasto_e'     => 1,
            'gasto_b'     => 1,
            'kardex_i'    => 1,
            'venta_i'     => 1,
            'venta_r'     => 1,
            'compra_i'    => 1,
            'compra_r'    => 1,
            'persona_i'   => 1,
            'reporte_i'   => 1,
            'rol_id'      => 3,
        ]);

        DB::table('users')->insert([
            'id'        => 1,
            'nombre'    => "Adam",
            'apellido'  => "Super Admin",
            'cedula'    => "12345678",
            'email'     => 'adam@adam.com',
            'sexo'      => 'M',
            'telefono'  => '+000000000',
            'direccion' => 'SUPER ADMIN',
            'rol_id'    => 1,
            'status'    => 1,
            'password'  => bcrypt('12345678'),
        ]);

        DB::table('users')->insert([
            'id'        => 2,
            'nombre'    => "ADMIN",
            'apellido'  => "ADMIN",
            'cedula'    => "00000000",
            'email'     => 'admin@admin.com',
            'sexo'      => "M",
            'telefono'  => '0000',
            'direccion' => '0000',
            'rol_id'    => 2,
            'status'    => 1,
            'password'  => bcrypt('123456'),
        ]);

        DB::table('tributos')->insert([
            [
                'id'        => 1,
                'nombre'    => "Tax Free",
                // 'tipo'      => "PORCENTAJE",
                'tipo'      => "Percentage",
                'monto'     => "0",
            ],
            // [
            //     'id'        => 2,
            //     'nombre'    => "12 Percent Tax",
            //     // 'tipo'      => "PORCENTAJE",
            //     'tipo'      => "Percentage",
            //     'monto'     => "12",
            // ]
        ]);


        DB::table('unit_of_measurements')->insert([
            [
                'uom' => 'TRAY',
                'code' => 'TRAY',
                'description' => '30 pcs = 1 Tray'
            ],
            [
                'uom' => 'CASE',
                'code' => 'CASE',
                'description' => '12 Tray = 1 Case'
            ],
            [
                'uom' => 'DOZEN',
                'code' => 'DOZEN',
                'description' => '12 pcs = 1 Dozen'
            ],
            [
                'uom' => 'Piece(s)',
                'code' => 'PCS',
                'description' => '1 Egg'
            ],
        ]);

    }
}
