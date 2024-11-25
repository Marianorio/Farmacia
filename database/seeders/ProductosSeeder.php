<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductosSeeder extends Seeder
{
    public function run()
    {
        $productos = [
            // Medicamentos (id_categoria: 1)
            [
                'nombre' => 'Paracetamol 500mg',
                'descripcion' => 'Analgésico y antipirético',
                'id_categoria' => 1,
                'precio_compra' => 150.00,
                'precio_venta' => 250.00,
                'stock_inicial' => 100,
                'stock_actual' => 100,
                'stock_minimo' => 20,
                'caducidad' => '2025-12-31'
            ],
            [
                'nombre' => 'Ibuprofeno 400mg',
                'descripcion' => 'Antiinflamatorio no esteroideo',
                'id_categoria' => 1,
                'precio_compra' => 180.00,
                'precio_venta' => 300.00,
                'stock_inicial' => 80,
                'stock_actual' => 80,
                'stock_minimo' => 15,
                'caducidad' => '2025-10-15'
            ],
            [
                'nombre' => 'Amoxicilina 500mg',
                'descripcion' => 'Antibiótico de amplio espectro',
                'id_categoria' => 1,
                'precio_compra' => 250.00,
                'precio_venta' => 400.00,
                'stock_inicial' => 50,
                'stock_actual' => 50,
                'stock_minimo' => 10,
                'caducidad' => '2025-06-30'
            ],
            [
                'nombre' => 'Omeprazol 20mg',
                'descripcion' => 'Protector gástrico',
                'id_categoria' => 1,
                'precio_compra' => 200.00,
                'precio_venta' => 350.00,
                'stock_inicial' => 60,
                'stock_actual' => 60,
                'stock_minimo' => 12,
                'caducidad' => '2025-08-20'
            ],
            [
                'nombre' => 'Loratadina 10mg',
                'descripcion' => 'Antihistamínico',
                'id_categoria' => 1,
                'precio_compra' => 120.00,
                'precio_venta' => 220.00,
                'stock_inicial' => 70,
                'stock_actual' => 70,
                'stock_minimo' => 15,
                'caducidad' => '2025-11-30'
            ],
            // Higiene Personal (id_categoria: 2)
            [
                'nombre' => 'Jabón Neutro',
                'descripcion' => 'Jabón de tocador suave',
                'id_categoria' => 2,
                'precio_compra' => 80.00,
                'precio_venta' => 150.00,
                'stock_inicial' => 100,
                'stock_actual' => 100,
                'stock_minimo' => 20,
                'caducidad' => '2026-01-15'
            ],
            [
                'nombre' => 'Shampoo Anticaspa',
                'descripcion' => 'Para cuero cabelludo sensible',
                'id_categoria' => 2,
                'precio_compra' => 180.00,
                'precio_venta' => 320.00,
                'stock_inicial' => 40,
                'stock_actual' => 40,
                'stock_minimo' => 10,
                'caducidad' => '2025-12-31'
            ],
            [
                'nombre' => 'Cepillo Dental Suave',
                'descripcion' => 'Cerdas suaves para limpieza dental',
                'id_categoria' => 2,
                'precio_compra' => 100.00,
                'precio_venta' => 180.00,
                'stock_inicial' => 150,
                'stock_actual' => 150,
                'stock_minimo' => 30,
                'caducidad' => null
            ],
            [
                'nombre' => 'Desodorante Roll-on',
                'descripcion' => '48 horas de protección',
                'id_categoria' => 2,
                'precio_compra' => 150.00,
                'precio_venta' => 280.00,
                'stock_inicial' => 60,
                'stock_actual' => 60,
                'stock_minimo' => 15,
                'caducidad' => '2025-09-30'
            ],
            [
                'nombre' => 'Pasta Dental Blanqueadora',
                'descripcion' => 'Con flúor y agentes blanqueadores',
                'id_categoria' => 2,
                'precio_compra' => 120.00,
                'precio_venta' => 220.00,
                'stock_inicial' => 80,
                'stock_actual' => 80,
                'stock_minimo' => 20,
                'caducidad' => '2025-11-15'
            ],
            // Cuidado de Niños (id_categoria: 3)
            [
                'nombre' => 'Pañales Talla M',
                'descripcion' => 'Para bebés de 6-10 kg',
                'id_categoria' => 3,
                'precio_compra' => 500.00,
                'precio_venta' => 800.00,
                'stock_inicial' => 50,
                'stock_actual' => 50,
                'stock_minimo' => 15,
                'caducidad' => '2025-12-31'
            ],
            [
                'nombre' => 'Toallitas Húmedas',
                'descripcion' => 'Sin alcohol, hipoalergénicas',
                'id_categoria' => 3,
                'precio_compra' => 150.00,
                'precio_venta' => 280.00,
                'stock_inicial' => 100,
                'stock_actual' => 100,
                'stock_minimo' => 20,
                'caducidad' => '2025-10-15'
            ],
            [
                'nombre' => 'Talco para Bebés',
                'descripcion' => 'Suave y delicado',
                'id_categoria' => 3,
                'precio_compra' => 120.00,
                'precio_venta' => 220.00,
                'stock_inicial' => 40,
                'stock_actual' => 40,
                'stock_minimo' => 10,
                'caducidad' => '2026-01-31'
            ],
            // Cosméticos (id_categoria: 4)
            [
                'nombre' => 'Base de Maquillaje',
                'descripcion' => 'Larga duración, tono natural',
                'id_categoria' => 4,
                'precio_compra' => 300.00,
                'precio_venta' => 550.00,
                'stock_inicial' => 30,
                'stock_actual' => 30,
                'stock_minimo' => 8,
                'caducidad' => '2025-08-31'
            ],
            [
                'nombre' => 'Máscara de Pestañas',
                'descripcion' => 'Volumen y longitud',
                'id_categoria' => 4,
                'precio_compra' => 200.00,
                'precio_venta' => 380.00,
                'stock_inicial' => 40,
                'stock_actual' => 40,
                'stock_minimo' => 10,
                'caducidad' => '2025-06-30'
            ],
            // Perfumería (id_categoria: 5)
            [
                'nombre' => 'Perfume Floral',
                'descripcion' => 'Fragancia femenina 50ml',
                'id_categoria' => 5,
                'precio_compra' => 800.00,
                'precio_venta' => 1500.00,
                'stock_inicial' => 20,
                'stock_actual' => 20,
                'stock_minimo' => 5,
                'caducidad' => '2026-12-31'
            ],
            [
                'nombre' => 'Colonia Masculina',
                'descripcion' => 'Aroma amaderado 100ml',
                'id_categoria' => 5,
                'precio_compra' => 600.00,
                'precio_venta' => 1200.00,
                'stock_inicial' => 25,
                'stock_actual' => 25,
                'stock_minimo' => 6,
                'caducidad' => '2026-10-31'
            ],
            // Cuidado Facial (id_categoria: 6)
            [
                'nombre' => 'Crema Hidratante',
                'descripcion' => 'Para todo tipo de piel',
                'id_categoria' => 6,
                'precio_compra' => 250.00,
                'precio_venta' => 450.00,
                'stock_inicial' => 45,
                'stock_actual' => 45,
                'stock_minimo' => 10,
                'caducidad' => '2025-09-30'
            ],
            [
                'nombre' => 'Protector Solar FPS 50',
                'descripcion' => 'Protección UVA/UVB',
                'id_categoria' => 6,
                'precio_compra' => 350.00,
                'precio_venta' => 600.00,
                'stock_inicial' => 50,
                'stock_actual' => 50,
                'stock_minimo' => 12,
                'caducidad' => '2025-12-15'
            ],
            // Otros productos variados
            [
                'nombre' => 'Vitamina C 1000mg',
                'descripcion' => 'Suplemento dietario',
                'id_categoria' => 1,
                'precio_compra' => 280.00,
                'precio_venta' => 480.00,
                'stock_inicial' => 40,
                'stock_actual' => 40,
                'stock_minimo' => 10,
                'caducidad' => '2025-11-30'
            ],
            [
                'nombre' => 'Alcohol en Gel',
                'descripcion' => 'Antiséptico 250ml',
                'id_categoria' => 2,
                'precio_compra' => 150.00,
                'precio_venta' => 280.00,
                'stock_inicial' => 100,
                'stock_actual' => 100,
                'stock_minimo' => 20,
                'caducidad' => '2025-12-31'
            ],
            [
                'nombre' => 'Termómetro Digital',
                'descripcion' => 'Medición precisa',
                'id_categoria' => 7,
                'precio_compra' => 400.00,
                'precio_venta' => 700.00,
                'stock_inicial' => 30,
                'stock_actual' => 30,
                'stock_minimo' => 8,
                'caducidad' => null
            ],
            [
                'nombre' => 'Tensiómetro Digital',
                'descripcion' => 'Automático de brazo',
                'id_categoria' => 7,
                'precio_compra' => 2500.00,
                'precio_venta' => 4000.00,
                'stock_inicial' => 10,
                'stock_actual' => 10,
                'stock_minimo' => 3,
                'caducidad' => null
            ],
            [
                'nombre' => 'Glucómetro',
                'descripcion' => 'Medidor de glucosa en sangre',
                'id_categoria' => 7,
                'precio_compra' => 1800.00,
                'precio_venta' => 3000.00,
                'stock_inicial' => 15,
                'stock_actual' => 15,
                'stock_minimo' => 4,
                'caducidad' => null
            ],
            [
                'nombre' => 'Nebulizador',
                'descripcion' => 'Uso familiar',
                'id_categoria' => 7,
                'precio_compra' => 3000.00,
                'precio_venta' => 5000.00,
                'stock_inicial' => 8,
                'stock_actual' => 8,
                'stock_minimo' => 2,
                'caducidad' => null
            ],
            [
                'nombre' => 'Muletas Ajustables',
                'descripcion' => 'Aluminio ligero',
                'id_categoria' => 7,
                'precio_compra' => 1500.00,
                'precio_venta' => 2500.00,
                'stock_inicial' => 6,
                'stock_actual' => 6,
                'stock_minimo' => 2,
                'caducidad' => null
            ],
            [
                'nombre' => 'Vendas Elásticas',
                'descripcion' => '10cm x 1.5m',
                'id_categoria' => 7,
                'precio_compra' => 100.00,
                'precio_venta' => 180.00,
                'stock_inicial' => 50,
                'stock_actual' => 50,
                'stock_minimo' => 10,
                'caducidad' => '2026-12-31'
            ],
            [
                'nombre' => 'Suero Fisiológico',
                'descripcion' => 'Solución salina 500ml',
                'id_categoria' => 1,
                'precio_compra' => 120.00,
                'precio_venta' => 200.00,
                'stock_inicial' => 60,
                'stock_actual' => 60,
                'stock_minimo' => 15,
                'caducidad' => '2025-12-31'
            ],
            [
                'nombre' => 'Agua Oxigenada',
                'descripcion' => '10 volúmenes 100ml',
                'id_categoria' => 2,
                'precio_compra' => 50.00,
                'precio_venta' => 90.00,
                'stock_inicial' => 80,
                'stock_actual' => 80,
                'stock_minimo' => 20,
                'caducidad' => '2025-06-30'
            ],
            [
                'nombre' => 'Algodón',
                'descripcion' => 'Paquete 500g',
                'id_categoria' => 2,
                'precio_compra' => 150.00,
                'precio_venta' => 250.00,
                'stock_inicial' => 40,
                'stock_actual' => 40,
                'stock_minimo' => 10,
                'caducidad' => '2026-12-31'
            ]
        ];

        foreach ($productos as $producto) {
            Producto::create($producto);
        }
    }
}
