<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use App\Models\Donation;
use App\Models\DonationPoint;
use App\Models\Zone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmergencyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Zonas Afectadas
        $zoneCentro = new Zone([
            'id' => (string) Str::uuid(),
            'name' => 'Barrio Centro',
            'description' => 'Zona más afectada, varias familias evacuadas. Agua alcanza hasta 1.5 metros en algunas calles.',
            'status' => 'critical',
            'active' => true,
            'order' => 1,
        ]);
        $zoneCentro->save();

        $zoneNorte = new Zone([
            'id' => (string) Str::uuid(),
            'name' => 'Barrio Norte',
            'description' => 'Afectación moderada. Algunas viviendas con agua en planta baja.',
            'status' => 'moderate',
            'active' => true,
            'order' => 2,
        ]);
        $zoneNorte->save();

        $zoneSur = new Zone([
            'id' => (string) Str::uuid(),
            'name' => 'Barrio Sur',
            'description' => 'Zona en recuperación. El agua está bajando gradualmente.',
            'status' => 'recovering',
            'active' => true,
            'order' => 3,
        ]);
        $zoneSur->save();

        // Coordinadores
        $coord1 = new Coordinator([
            'id' => (string) Str::uuid(),
            'name' => 'Comité de Emergencia Local',
            'organization' => 'Municipalidad',
            'phone' => '+5491234567890',
            'whatsapp' => '+5491234567890',
            'email' => 'emergencias@municipio.gov.ar',
            'description' => 'Coordinación general de la ayuda y recepción de donaciones.',
            'active' => true,
            'order' => 1,
        ]);
        $coord1->save();

        $coord2 = new Coordinator([
            'id' => (string) Str::uuid(),
            'name' => 'Cruz Roja',
            'organization' => 'Cruz Roja Argentina',
            'phone' => '+5491234567891',
            'whatsapp' => '+5491234567891',
            'email' => 'ayuda@cruzroja.org.ar',
            'description' => 'Asistencia médica y logística de emergencia.',
            'active' => true,
            'order' => 2,
        ]);
        $coord2->save();

        // Donaciones Necesarias
        $donation1 = new Donation([
            'id' => (string) Str::uuid(),
            'name' => 'Agua Potable',
            'description' => 'Botellas de agua de 1.5L o bidones',
            'quantity_needed' => 500,
            'quantity_received' => 320,
            'unit' => 'unidades',
            'priority' => 'high',
            'active' => true,
            'order' => 1,
        ]);
        $donation1->save();

        $donation2 = new Donation([
            'id' => (string) Str::uuid(),
            'name' => 'Alimentos No Perecederos',
            'description' => 'Arroz, fideos, latas, aceite, azúcar',
            'quantity_needed' => 300,
            'quantity_received' => 180,
            'unit' => 'paquetes',
            'priority' => 'high',
            'active' => true,
            'order' => 2,
        ]);
        $donation2->save();

        $donation3 = new Donation([
            'id' => (string) Str::uuid(),
            'name' => 'Productos de Higiene',
            'description' => 'Jabón, shampoo, pasta dental, papel higiénico',
            'quantity_needed' => 400,
            'quantity_received' => 250,
            'unit' => 'unidades',
            'priority' => 'medium',
            'active' => true,
            'order' => 4,
        ]);
        $donation3->save();

        $donation4 = new Donation([
            'id' => (string) Str::uuid(),
            'name' => 'Colchones y Almohadas',
            'description' => 'Para familias que perdieron sus pertenencias',
            'quantity_needed' => 100,
            'quantity_received' => 45,
            'unit' => 'unidades',
            'priority' => 'medium',
            'active' => true,
            'order' => 5,
        ]);
        $donation4->save();

        $donation5 = new Donation([
            'id' => (string) Str::uuid(),
            'name' => 'Pilas y Linternas',
            'description' => 'Para zonas sin electricidad',
            'quantity_needed' => 150,
            'quantity_received' => 120,
            'unit' => 'unidades',
            'priority' => 'low',
            'active' => true,
            'order' => 6,
        ]);
        $donation5->save();

        // Puntos de Recepción
        $point1 = new DonationPoint([
            'id' => (string) Str::uuid(),
            'zone_id' => $zoneCentro->id,
            'name' => 'Centro de Recepción Municipal',
            'address' => 'Av. Principal 123, Centro',
            'schedule' => 'Lunes a Domingo: 8:00 - 20:00',
            'phone' => '+5491234567890',
            'whatsapp' => '+5491234567890',
            'notes' => 'Recepción de todo tipo de donaciones. Estacionamiento disponible.',
            'active' => true,
            'order' => 1,
        ]);
        $point1->save();

        $point2 = new DonationPoint([
            'id' => (string) Str::uuid(),
            'zone_id' => $zoneCentro->id,
            'name' => 'Escuela Primaria N° 15',
            'address' => 'Calle San Martín 456',
            'schedule' => 'Lunes a Viernes: 9:00 - 18:00',
            'phone' => '+5491234567892',
            'whatsapp' => '+5491234567892',
            'notes' => 'Solo alimentos y agua. Ingreso por el portón principal.',
            'active' => true,
            'order' => 2,
        ]);
        $point2->save();

        $point3 = new DonationPoint([
            'id' => (string) Str::uuid(),
            'zone_id' => $zoneNorte->id,
            'name' => 'Centro Comunitario Barrio Norte',
            'address' => 'Av. Libertador 789',
            'schedule' => 'Martes a Sábado: 10:00 - 19:00',
            'phone' => '+5491234567893',
            'whatsapp' => '+5491234567893',
            'notes' => 'Recepción de ropa, mantas y productos de higiene.',
            'active' => true,
            'order' => 3,
        ]);
        $point3->save();
    }
}
