<?php

namespace Database\Seeders;

use App\Models\TimelineTemplate;
use Illuminate\Database\Seeder;

class MasterTimelineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $milestones = [
            [
                'title' => 'Pertemuan Awal & Brainstorming',
                'description' => 'Diskusi konsep pernikahan impian, tema warna, budget planning dasar, dan pembagian tugas awal.',
                'days_before_wedding' => 180,
                'order' => 1,
            ],
            [
                'title' => 'Booking Venue & Tanggal Pernikahan',
                'description' => 'Membayar down payment (DP) untuk mengunci tanggal pernikahan pada gedung / lokasi outdoor pilihan.',
                'days_before_wedding' => 150,
                'order' => 2,
            ],
            [
                'title' => 'Kurasi & Booking Vendor Utama (MUA, Dekorasi, Catering)',
                'description' => 'Mengevaluasi portofolio vendor, melakukan test food catering, fitting busana awal, dan mengunci dekorasi pelaminan.',
                'days_before_wedding' => 120,
                'order' => 3,
            ],
            [
                'title' => 'Pendaftaran Kantor Urusan Agama (KUA) / Catatan Sipil',
                'description' => 'Melengkapi berkas administrasi pernikahan resmi secara hukum dan agama.',
                'days_before_wedding' => 90,
                'order' => 4,
            ],
            [
                'title' => 'Sesi Pemotretan Pre-Wedding',
                'description' => 'Mengambil foto dan video dokumentasi pra-nikah untuk kebutuhan dekorasi / undangan digital.',
                'days_before_wedding' => 60,
                'order' => 5,
            ],
            [
                'title' => 'Penyebaran Undangan & Finalisasi Tamu',
                'description' => 'Mengirim undangan cetak/digital kepada kerabat dan memantau status konfirmasi kehadiran (RSVP).',
                'days_before_wedding' => 30,
                'order' => 6,
            ],
            [
                'title' => 'Technical Meeting & Rehearsal (Gladi Bersih)',
                'description' => 'Pertemuan koordinasi seluruh panitia keluarga dan vendor pengisi acara untuk finalisasi rundown acara.',
                'days_before_wedding' => 7,
                'order' => 7,
            ],
        ];

        foreach ($milestones as $m) {
            TimelineTemplate::create($m);
        }
    }
}
