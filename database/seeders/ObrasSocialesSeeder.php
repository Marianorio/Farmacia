<?php
namespace Database\Seeders;
use App\Models\ObraSocial;
use Illuminate\Database\Seeder;
class ObrasSocialesSeeder extends Seeder
{
   public function run()
   {
       $obras_sociales = [
           [
               'nombre' => 'OSDE',
               'cuit' => '30-54674125-7',
               'fecha_convenio' => '2024-01-01',
               'fecha_vencimiento_convenio' => '2025-01-01',
               'descripcion' => 'Obra Social de Ejecutivos'
           ],
           [
               'nombre' => 'Swiss Medical',
               'cuit' => '30-65485795-8',
               'fecha_convenio' => '2024-01-15',
               'fecha_vencimiento_convenio' => '2025-01-15',
               'descripcion' => 'Prepaga con cobertura nacional'
           ],
           [
               'nombre' => 'IOMA',
               'cuit' => '30-62824842-9',
               'fecha_convenio' => '2024-02-01',
               'fecha_vencimiento_convenio' => '2025-02-01',
               'descripcion' => 'Instituto Obra Médico Asistencial'
           ],
           [
               'nombre' => 'PAMI',
               'cuit' => '30-52276392-2',
               'fecha_convenio' => '2024-01-10',
               'fecha_vencimiento_convenio' => '2025-01-10',
               'descripcion' => 'Programa de Atención Médica Integral'
           ],
           [
               'nombre' => 'Medifé',
               'cuit' => '30-68198892-0',
               'fecha_convenio' => '2024-02-15',
               'fecha_vencimiento_convenio' => '2025-02-15',
               'descripcion' => 'Servicios médicos prepagos'
           ],
           [
               'nombre' => 'Galeno',
               'cuit' => '30-52242816-3',
               'fecha_convenio' => '2024-03-01',
               'fecha_vencimiento_convenio' => '2025-03-01',
               'descripcion' => 'Cobertura médica integral'
           ]
       ];
        foreach ($obras_sociales as $obra) {
           ObraSocial::create($obra);
       }
   }
}
