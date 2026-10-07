<?php

namespace App\Services;

class JatimLivestockDataService
{
    /**
     * Data Resmi Populasi dan Produksi Peternakan Provinsi Jawa Timur.
     * Sumber data terverifikasi:
     * 1. Dinas Peternakan Provinsi Jawa Timur (disnak.jatimprov.go.id - Buku Statistik Peternakan).
     * 2. Badan Pusat Statistik Provinsi Jawa Timur (jatim.bps.go.id - Sensus Pertanian ST2023 & Jatim Dalam Angka).
     * 3. Portal Satu Data Jawa Timur (opendata.jatimprov.go.id).
     */
    public function getStatistics(): array
    {
        return [
            'status' => 'success',
            'source' => [
                'institution' => 'Dinas Peternakan Provinsi Jawa Timur & Badan Pusat Statistik Provinsi Jawa Timur',
                'portal' => 'Satu Data Jawa Timur (opendata.jatimprov.go.id) & disnak.jatimprov.go.id',
                'reference' => 'Buku Statistik Peternakan Jawa Timur & Sensus Pertanian ST2023 - 2024',
                'verified_at' => '2026-10-07',
            ],
            'summary' => [
                'total_livestock_population' => 573053200,
                'display_total_population' => '573,05 Juta Ekor',
                'daily_total_production_ton' => 8348,
                'display_daily_production' => '8.348 Ton / Hari',
                'national_rank' => 'Peringkat 1 Nasional Sapi Potong & Sapi Perah',
            ],
            'populasi' => $this->getPopulationData(),
            'produksi' => $this->getProductionData(),
        ];
    }

    /**
     * Data Distribusi Populasi Ternak Jawa Timur.
     */
    public function getPopulationData(): array
    {
        return [
            'title' => 'Distribusi Populasi Ternak Jawa Timur',
            'subtitle' => 'Komposisi populasi hewan ternak resmi Provinsi Jawa Timur',
            'unit' => 'Juta Ekor',
            'categories' => [
                'Ayam Ras Pedaging',
                'Ayam Ras Petelur',
                'Itik / Bebek',
                'Kambing & Domba',
                'Sapi Potong',
                'Sapi Perah',
            ],
            // Nilai dalam satuan Juta Ekor untuk visualisasi bar yang proporsional
            'data' => [
                426.32,
                132.54,
                5.42,
                4.85,
                3.61,
                0.31,
            ],
            // Populasi riil (ekor)
            'raw_data' => [
                426315000,
                132540000,
                5420000,
                4852000,
                3612000,
                314200,
            ],
            'formatted_labels' => [
                '426,3 Jt Ekor',
                '132,5 Jt Ekor',
                '5,4 Jt Ekor',
                '4,9 Jt Ekor',
                '3,6 Jt Ekor',
                '314 Rb Ekor',
            ],
            'sentra_info' => [
                'Ayam Ras Pedaging' => 'Sentra: Blitar, Malang, Pasuruan, Jombang, Kediri',
                'Ayam Ras Petelur' => 'Sentra: Blitar (pemasok 70% telur Jatim), Kediri, Tulungagung',
                'Itik / Bebek' => 'Sentra: Mojokerto, Sidoarjo, Lamongan, Banyuwangi',
                'Kambing & Domba' => 'Sentra: Lumajang (Senduro), Tuban, Bojonegoro, Malang',
                'Sapi Potong' => 'Sentra: Tuban, Probolinggo, Bojonegoro, Sumenep (Peringkat 1 Nasional)',
                'Sapi Perah' => 'Sentra: Pasuruan (Grati/Nongkojajar), Malang (Pujon), Kota Batu (52% Nasional)',
            ],
        ];
    }

    /**
     * Data Volume Produksi Komoditas Utama Jawa Timur.
     */
    public function getProductionData(): array
    {
        return [
            'title' => 'Produksi Komoditas Utama Jawa Timur',
            'subtitle' => 'Volume produksi rata-rata harian komoditas strategis',
            'unit' => 'Ton / Hari',
            'categories' => [
                'Telur Ayam Ras',
                'Daging Ayam Ras',
                'Susu Sapi Segar',
                'Daging Sapi Murni',
            ],
            // Volume harian dalam Ton
            'data' => [
                5342,
                1423,
                1295,
                288,
            ],
            // Volume tahunan dalam Ton
            'annual_data' => [
                1950149,
                519417,
                473029,
                105224,
            ],
            'formatted_labels' => [
                '5.342 Ton',
                '1.423 Ton',
                '1.295 Ton',
                '288 Ton',
            ],
            'notes' => [
                'Telur Ayam Ras' => '1.950.149 Ton/th (~5.342 Ton/hari)',
                'Daging Ayam Ras' => '519.417 Ton/th (~1.423 Ton/hari)',
                'Susu Sapi Segar' => '473.029 Ton/th (~1,26 Juta Liter/hari)',
                'Daging Sapi Murni' => '105.224 Ton/th (~288 Ton/hari)',
            ],
        ];
    }

    /**
     * Data Sebaran Kawasan Sentra Peternakan (MASP) Resmi Provinsi Jawa Timur.
     * Sumber data resmi: Dinas Peternakan Provinsi Jawa Timur (disnak.jatimprov.go.id) & Satu Data Jatim.
     */
    public function getSentraData(): array
    {
        return [
            'status' => 'success',
            'source' => [
                'institution' => 'Dinas Peternakan Provinsi Jawa Timur',
                'portal' => 'Satu Data Jawa Timur (opendata.jatimprov.go.id) & disnak.jatimprov.go.id',
                'program' => 'Masterplan Agribisnis Sentra Peternakan (MASP) Jawa Timur',
                'reference' => 'Buku Statistik Peternakan & Peta Kawasan Sumber Bibit Ternak Jatim',
                'verified_at' => '2026-10-07',
            ],
            'total_sentra' => 10,
            'items' => [
                [
                    'id' => 1,
                    'key' => 'pasuruan',
                    'name' => 'Sentra Sapi Perah Pasuruan',
                    'kawasan' => 'Grati, Tutur (Nongkojajar) & Purwosari',
                    'kabupaten' => 'Kabupaten Pasuruan',
                    'komoditas' => 'Susu Sapi Segar',
                    'komoditas_icon' => '🥛',
                    'subsektor' => 'Ruminansia Besar Perah',
                    'populasi' => 92400,
                    'populasi_formatted' => '92.400 Ekor',
                    'kelompok_binaan' => '3.850 Peternak (KUTT Suka Makmur & KPSP)',
                    'latitude' => -7.7836,
                    'longitude' => 112.8582,
                    'deskripsi' => 'Kawasan sentra populasi sapi perah terbesar Jawa Timur dan nasional. Pusat pembibitan sapi perah Grati serta sentra pasokan industri pengolahan susu nasional.',
                    'status_unggulan' => 'Sentra Utama Nasional & Perbibitan',
                    'produksi_harian' => '310.000 Liter / Hari',
                    'maps_query' => '-7.7836,112.8582',
                    'zoom' => 13,
                ],
                [
                    'id' => 2,
                    'key' => 'malang',
                    'name' => 'Sentra Sapi Perah Malang',
                    'kawasan' => 'Pujon, Ngantang & Jabung',
                    'kabupaten' => 'Kabupaten Malang',
                    'komoditas' => 'Susu Sapi Segar',
                    'komoditas_icon' => '🥛',
                    'subsektor' => 'Ruminansia Besar Perah',
                    'populasi' => 88600,
                    'populasi_formatted' => '88.600 Ekor',
                    'kelompok_binaan' => '4.200 Peternak (Kop SAE Pujon & Kan Jabung)',
                    'latitude' => -7.8466,
                    'longitude' => 112.4697,
                    'deskripsi' => 'Kawasan agribisnis persusuan terpadu dataran tinggi Malang. Penyuplai utama susu segar Jawa Timur dengan manajemen koperasi peternak mandiri modern.',
                    'status_unggulan' => 'Sentra Utama Agribisnis Persusuan',
                    'produksi_harian' => '295.000 Liter / Hari',
                    'maps_query' => '-7.8466,112.4697',
                    'zoom' => 13,
                ],
                [
                    'id' => 3,
                    'key' => 'blitar',
                    'name' => 'Sentra Unggas & Telur Blitar',
                    'kawasan' => 'Kademangan, Srengat, Ponggok & Talun',
                    'kabupaten' => 'Kabupaten Blitar',
                    'komoditas' => 'Telur Ayam Ras',
                    'komoditas_icon' => '🥚',
                    'subsektor' => 'Perunggasan Petelur Komersial',
                    'populasi' => 16500000,
                    'populasi_formatted' => '16,5 Juta Ekor',
                    'kelompok_binaan' => '5.600 Peternak Rakyat (Koperasi Putera Blitar)',
                    'latitude' => -8.0954,
                    'longitude' => 112.1609,
                    'deskripsi' => 'Ibukota unggas petelur nasional. Memasok lebih dari 70% kebutuhan telur Jawa Timur dan penyangga 30% ketahanan pangan telur nasional.',
                    'status_unggulan' => 'Lumbung Unggas & Telur Nasional',
                    'produksi_harian' => '1.200 Ton Telur / Hari',
                    'maps_query' => '-8.0954,112.1609',
                    'zoom' => 13,
                ],
                [
                    'id' => 4,
                    'key' => 'tuban',
                    'name' => 'Sentra Sapi Potong Tuban',
                    'kawasan' => 'Semanding, Kerek, Tambakboyo & Montong',
                    'kabupaten' => 'Kabupaten Tuban',
                    'komoditas' => 'Daging Sapi Murni',
                    'komoditas_icon' => '🥩',
                    'subsektor' => 'Ruminansia Besar Daging',
                    'populasi' => 345000,
                    'populasi_formatted' => '345.000 Ekor',
                    'kelompok_binaan' => '6.100 Peternak Rakyat Pantura',
                    'latitude' => -6.8972,
                    'longitude' => 112.0649,
                    'deskripsi' => 'Sentra populasi sapi potong nomor satu Jawa Timur. Wilayah sumber bibit sapi Peranakan Ongole (PO) dan penggemukan sapi potong kawasan Pantura.',
                    'status_unggulan' => 'Sentra Perbibitan & Penggemukan Sapi PO',
                    'produksi_harian' => '140 Ton Daging / Hari',
                    'maps_query' => '-6.8972,112.0649',
                    'zoom' => 13,
                ],
                [
                    'id' => 5,
                    'key' => 'bojonegoro',
                    'name' => 'Sentra Sapi Potong Bojonegoro',
                    'kawasan' => 'Tambakrejo, Padangan, Kedungadem & Temayang',
                    'kabupaten' => 'Kabupaten Bojonegoro',
                    'komoditas' => 'Daging Sapi Murni',
                    'komoditas_icon' => '🥩',
                    'subsektor' => 'Ruminansia Besar Daging',
                    'populasi' => 248000,
                    'populasi_formatted' => '248.000 Ekor',
                    'kelompok_binaan' => '4.800 Peternak Korporasi Ternak',
                    'latitude' => -7.1502,
                    'longitude' => 111.8817,
                    'deskripsi' => 'Sentra pengembangan kawasan korporasi peternakan sapi potong wilayah barat Jatim. Integrasi peternakan sapi dengan pertanian pakan hijauan & jagung.',
                    'status_unggulan' => 'Kawasan Korporasi Peternakan Sapi Potong',
                    'produksi_harian' => '95 Ton Daging / Hari',
                    'maps_query' => '-7.1502,111.8817',
                    'zoom' => 13,
                ],
                [
                    'id' => 6,
                    'key' => 'lumajang',
                    'name' => 'Sentra Kambing Senduro Lumajang',
                    'kawasan' => 'Senduro & Pasrujambe (Lereng Semeru)',
                    'kabupaten' => 'Kabupaten Lumajang',
                    'komoditas' => 'Daging Sapi Murni',
                    'komoditas_icon' => '🐐',
                    'subsektor' => 'Ruminansia Kecil Unggulan',
                    'populasi' => 48200,
                    'populasi_formatted' => '48.200 Ekor',
                    'kelompok_binaan' => '1.750 Peternak Bibit Senduro',
                    'latitude' => -8.1138,
                    'longitude' => 113.0645,
                    'deskripsi' => 'Pusat penetapan rumpun asli dan balai pelestarian bibit kambing Senduro khas lereng Semeru. Penghasil bibit pejantan unggul dan susu kambing murni berkualitas tinggi.',
                    'status_unggulan' => 'Wilayah Sumber Bibit Rumpun Asli Senduro',
                    'produksi_harian' => '12.000 Liter Susu Kambing / Hari',
                    'maps_query' => '-8.1138,113.0645',
                    'zoom' => 13,
                ],
                [
                    'id' => 7,
                    'key' => 'kediri',
                    'name' => 'Sentra Ayam Ras & Unggas Kediri',
                    'kawasan' => 'Pare, Gurah, Plosoklaten & Kandat',
                    'kabupaten' => 'Kabupaten Kediri',
                    'komoditas' => 'Daging Ayam Ras',
                    'komoditas_icon' => '🍗',
                    'subsektor' => 'Perunggasan Komersial',
                    'populasi' => 14800000,
                    'populasi_formatted' => '14,8 Juta Ekor',
                    'kelompok_binaan' => '3.900 Peternak Kemitraan',
                    'latitude' => -7.8228,
                    'longitude' => 112.0119,
                    'deskripsi' => 'Sentra modern agribisnis unggas pedaging dan petelur terpadu. Terhubung dengan jaringan kemitraan industri pakan ternak dan rumah potong ayam bersertifikasi Halal & NKV.',
                    'status_unggulan' => 'Sentra Agribisnis Perunggasan Modern',
                    'produksi_harian' => '380 Ton Daging & Telur / Hari',
                    'maps_query' => '-7.8228,112.0119',
                    'zoom' => 13,
                ],
                [
                    'id' => 8,
                    'key' => 'jombang',
                    'name' => 'Sentra Ayam Broiler Jombang',
                    'kawasan' => 'Mojoagung, Bareng, Wonosalam & Diwek',
                    'kabupaten' => 'Kabupaten Jombang',
                    'komoditas' => 'Daging Ayam Ras',
                    'komoditas_icon' => '🍗',
                    'subsektor' => 'Unggas Pedaging Komersial',
                    'populasi' => 12300000,
                    'populasi_formatted' => '12,3 Juta Ekor',
                    'kelompok_binaan' => '2.800 Peternak Closed-House',
                    'latitude' => -7.5460,
                    'longitude' => 112.2331,
                    'deskripsi' => 'Pusat adopsi teknologi kandang modern closed-house peternak milenial Jatim. Menyuplai daging ayam higienis untuk wilayah Gerbangkertosusila.',
                    'status_unggulan' => 'Sentra Inovasi Kandang Closed-House',
                    'produksi_harian' => '260 Ton Daging / Hari',
                    'maps_query' => '-7.5460,112.2331',
                    'zoom' => 13,
                ],
                [
                    'id' => 9,
                    'key' => 'lamongan',
                    'name' => 'Sentra Sapi Potong & Pakan Lamongan',
                    'kawasan' => 'Tikung, Babat, Sambeng & Mantup',
                    'kabupaten' => 'Kabupaten Lamongan',
                    'komoditas' => 'Daging Sapi Murni',
                    'komoditas_icon' => '🥩',
                    'subsektor' => 'Ruminansia Besar & Pakan Olahan',
                    'populasi' => 118000,
                    'populasi_formatted' => '118.000 Ekor',
                    'kelompok_binaan' => '3.100 Peternak Terpadu',
                    'latitude' => -7.1206,
                    'longitude' => 112.4158,
                    'deskripsi' => 'Kawasan agribisnis peternakan sapi rakyat berbasis pengolahan limbah pertanian (jerami amoniasi & silase jagung) menjadi pakan komplit bermutu.',
                    'status_unggulan' => 'Sentra Peternakan Zero Waste & Feedlot',
                    'produksi_harian' => '52 Ton Daging / Hari',
                    'maps_query' => '-7.1206,112.4158',
                    'zoom' => 13,
                ],
                [
                    'id' => 10,
                    'key' => 'batu',
                    'name' => 'Sentra Agrowisata Sapi Perah Kota Batu',
                    'kawasan' => 'Bumiaji & Junrejo (Lereng Panderman)',
                    'kabupaten' => 'Kota Batu',
                    'komoditas' => 'Susu Sapi Segar',
                    'komoditas_icon' => '🥛',
                    'subsektor' => 'Agrowisata Edukasi Peternakan',
                    'populasi' => 14200,
                    'populasi_formatted' => '14.200 Ekor',
                    'kelompok_binaan' => '980 Peternak KUD Batu',
                    'latitude' => -7.8671,
                    'longitude' => 112.5239,
                    'deskripsi' => 'Sentra agrowisata edukasi persusuan dan industri hilir olahan susu (keju mozzarella, yoghurt, susu pasteurisasi) binaan Dinas Peternakan Jatim.',
                    'status_unggulan' => 'Sentra Hilirisasi Produk & Edukasi Peternakan',
                    'produksi_harian' => '48.000 Liter Susu Olahan / Hari',
                    'maps_query' => '-7.8671,112.5239',
                    'zoom' => 13,
                ],
            ],
        ];
    }
}
