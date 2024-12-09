<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;

class IngredientSeeder extends Seeder
{
    public function run()
    {
        $ingredients = [
            'Agar-Agar', 'Air Kelapa', 'Air Soda', 'Almond', 'Alpukat', 'Anggur', 'Apel', 'Asam Jawa', 'Asparagus', 'Ati Ampela', 'Ayam', 'Ayam Cincang',
            'Baby Corn', 'Bacon', 'Baking Powder', 'Bakso', 'Bakso Ikan', 'Basil', 'Bawang Bombay', 'Bawang Merah', 'Bawang Putih', 'Bayam', 'Belimbing', 'Belut', 'Bengkoang', 'Beras', 'Beras Ketan', 'Beras Merah', 'Bihun', 'Biskuit Oreo', 'Blewah', 'Blueberry', 'Brokoli', 'Buah Naga', 'Bubble Pearl', 'Bubuk Jelly', 'Buncis', 'Bunga Lawang/Pekak',
            'Cabe', 'Cabe Bubuk', 'Cabe Merah Besar', 'Cakwe', 'Cengkeh', 'Cincau', 'Cokelat', 'Cokelat Bubuk', 'Cokelat Chip', 'Crab Stick', 'Cream Cheese', 'Cumi',
            'Daging Giling', 'Daging Ham (Sapi)', 'Daging Kambing', 'Daging Sapi', 'Daun Bawang', 'Daun Jeruk', 'Daun Kemangi', 'Daun Mint', 'Daun Pandan', 'Daun Pepaya', 'Daun Pisang', 'Daun Salam', 'Donat', 'Durian',
            'Ebi', 'Emulsifier', 'Es Batu', 'Es Krim',
            'Fettuccine', 'Furikake',
            'Garam', 'Gochujang', 'Granola', 'Green Tea/ Matcha', 'Gula', 'Gula Merah',
            'Ikan', 'Ikan Lele', 'Ikan Teri', 'Ikan Tuna',
            'Jagung', 'Jahe', 'Jambu', 'Jamur', 'Jamur Champignon', 'Jamur Enoki', 'Jamur Shiitake', 'Jamur Tiram', 'Jeruk', 'Jeruk Nipis', 'Jinten',
            'Kacang', 'Kacang Hijau', 'Kacang Panjang', 'Kacang Polong', 'Kacang Tanah', 'Kangkung', 'Kapur Sirih', 'Kayu Manis', 'Kecap Asin', 'Kecap Manis', 'Keju', 'Keju Edam', 'Keju Mozarella', 'Keju Parmesan', 'Kelapa', 'Kelapa Muda', 'Kelengkeng', 'Kembang Kol', 'Kembang Tahu', 'Kemiri', 'Kencur', 'Kentang', 'Kepiting', 'Kerang', 'Ketumbar', 'Ketupat', 'Kimchi', 'Kiwi', 'Kolang Kaling', 'Kopi', 'Kornet', 'Kubis', 'Kue', 'Kulit Lumpia', 'Kulit Pangsit', 'Kunyit', 'Kurma',
            'Labu', 'Labu Siam', 'Lada', 'Leci', 'Lemon', 'Lengkuas', 'Lobak', 'Lobster',
            'Madu', 'Mangga', 'Manggis', 'Margarin', 'Markisa', 'Marshmallow', 'Mayonaise', 'Melon', 'Mentega', 'Meses', 'Mie', 'Mie Instan', 'Minuman Probiotik', 'Minyak Sayur', 'Minyak Wijen', 'Minyak Zaitun',
            'Nanas', 'Nangka', 'Nasi', 'Nata de Coco', 'Nori', 'Nugget',
            'Oatmeal', 'Oregano',
            'Pala', 'Paprika', 'Pare', 'Paru Sapi', 'Pasta', 'Peach', 'Pepaya', 'Perwarna Makanan', 'Petai', 'Pisang', 'Puding',
            'Ragi', 'Rambutan', 'Raspberry', 'Rosemary', 'Roti', 'Roti Tawar', 'Rumput Laut',
            'Sagu Mutiara', 'Salak', 'Salmon', 'Santan', 'Saus Bolognese', 'Saus Caramel', 'Saus Kacang', 'Saus Sambal', 'Saus Teriyaki', 'Saus Tiram', 'Sawi', 'Selai Kacang', 'Selasih', 'Seledri', 'Semangka', 'Serai', 'Sereal', 'Shirataki', 'Singkong', 'Sirsak', 'Sosis', 'Spaghetti', 'Srikaya', 'Strawberry', 'Susu',
            'Tahu', 'Tape Singkong', 'Tauge', 'Teh', 'Telur', 'Telur Asin', 'Telur Puyuh', 'Tempe', 'Tepung', 'Tepung Beras', 'Tepung Maizena', 'Tepung Roti', 'Tepung Tapioka', 'Tepung Terigu', 'Terasi', 'Terong', 'Thai Tea', 'Timun', 'Tomat',
            'Ubi', 'Udang',
            'Vanilla',
            'Whipped Cream', 'Wijen', 'Wortel',
            'Yogurt',
            'Zucchini'
        ];

        foreach ($ingredients as $ingredient) {
            Ingredient::create(['name' => $ingredient]);
        }
    }
}