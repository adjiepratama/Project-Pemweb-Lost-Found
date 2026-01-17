<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

       $items = [
            [
                'title' => 'Dompet Kulit Cokelat',
                'category' => 'Aksesoris',
                'location' => 'Gedung A',
                'status' => 'returned',
                'date_event' => '2025-10-26',
              
                'image' => 'https://images.unsplash.com/photo-1600857062241-98e5dba7f214?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'title' => 'Kacamata Hitam Rayban',
                'category' => 'Aksesoris',
                'location' => 'Gor ABC',
                'status' => 'donated',
                'date_event' => '2025-10-25',
                
                'image' => 'https://images.unsplash.com/photo-1577803645773-f96470509666?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'title' => 'iPhone 13 Pro',
                'category' => 'Elektronik',
                'location' => 'Gedung A',
                'status' => 'available',
                'date_event' => '2025-10-28',
                
                'image' => 'https://images.unsplash.com/photo-1632661674596-df8be070a5c5?auto=format&fit=crop&q=80&w=400',
            ],
        
           [
                'title' => 'Kunci',
                'category' => 'Kunci',
                'location' => 'Kantin bawah',
                'status' => 'available',
                'date_event' => '2025-10-29',
                
                'image' => 'https://images.unsplash.com/photo-1582137211742-5d46e9629636?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'title' => 'Tumbler Corkcicle',
                'category' => 'Perabotan',
                'location' => 'Gedung C',
                'status' => 'available',
                'date_event' => '2025-10-27',
            
                'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?auto=format&fit=crop&q=80&w=400',
            ],
            [
                'title' => 'Jaket bomber coklat',
                'category' => 'Pakaian',
                'location' => 'Gedung B',
                'status' => 'available',
                'date_event' => '2025-10-30',
                
                'image' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?auto=format&fit=crop&q=80&w=400',
            ],
        ];

        foreach ($items as $item) {
            Item::create(array_merge($item, [
                'user_id' => $user->id,
                'description' => 'Barang ini ditemukan/hilang di lokasi tersebut. Hubungi saya jika mengenali.',
            ]));
        }
    }
}