<?php

// database/seeders/AssessmentSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // Kompetensi Master
        DB::table('competencies')->insert([
            ['id' => 1, 'name' => 'Integrity'],
            ['id' => 2, 'name' => 'Communication'],
            ['id' => 3, 'name' => 'Innovation & Creativity'],
            ['id' => 4, 'name' => 'Customer Orientation'],
            ['id' => 5, 'name' => 'Teamwork'],
            ['id' => 6, 'name' => 'Leadership'],
            ['id' => 7, 'name' => 'Business Acumen'],
            ['id' => 8, 'name' => 'Problem Solving & Decission Making'],
            ['id' => 9, 'name' => 'Acievement Orientation'],
            ['id' => 10, 'name' => 'Strategic Thinking'],
        ]);

        // Assessment Utama
        DB::table('assessment_session')->insert([
            'id' => 1,
            'user_id_talent' => 2,
            'user_id_atasan' => 1,
            'period' => '2026',
        ]);

        // Detail Assessment (Gap Analysis)
        DB::table('detail_assessment')->insert([
            [
                'assessment_id' => 1,
                'competence_id' => 1,
                'score_atasan' => 4,
                'score_talent' => 5,
                'gap_score' => -1.0,
                'notes' => 'Initial assessment notes',
            ]
        ]);

        // Standar Kompetensi per Posisi (Contoh untuk Position 2/Manager)
        DB::table('position_target_competence')->insert([
            ['position_id' => 2, 'competence_id' => 1, 'target_level' => 5],
            ['position_id' => 2, 'competence_id' => 2, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 3, 'target_level' => 3],
            ['position_id' => 2, 'competence_id' => 4, 'target_level' => 3],
            ['position_id' => 2, 'competence_id' => 5, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 6, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 7, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 8, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 9, 'target_level' => 4],
            ['position_id' => 2, 'competence_id' => 10, 'target_level' => 4],
        ]);

        // Pertanyaan Kompetensi (Questions)
        $questions = [
            // Integrity (competence_id = 1)
            [
                'competence_id' => 1,
                'level' => 1,
                'question_text' => 'Bertindak sesuai dengan aturan dan nilai organisasi dalam pekerjaan sehari-hari. Menghindari tindakan atau ucapan yang melanggar kebijakan perusahaan. Mematuhi etika yang berlaku',
            ],
            [
                'competence_id' => 1,
                'level' => 2,
                'question_text' => 'Mengingatkan dan mendorong rekan kerja untuk selalu berperilaku etis. Mengajak tim untuk mengikuti norma yang berlaku. Menyampaikan informasi yang akurat dan dapat dipercaya.',
            ],
            [
                'competence_id' => 1,
                'level' => 3,
                'question_text' => 'Memastikan bahwa anggota tim memahami dan menjalankan standar etika. Memberikan apresiasi atau teguran secara konstruktif bagi yang bertindak sesuai atau melanggar nilai organisasi. Memonitor penerapan etika dalam tim kerja.',
            ],
            [
                'competence_id' => 1,
                'level' => 4,
                'question_text' => 'Menciptakan lingkungan yang mendukung kepatuhan terhadap standar etika. Menyusun prinsip moral dan pedoman etika yang jelas. Berani mengoreksi tindakan yang bertentangan dengan integritas organisasi.',
            ],
            [
                'competence_id' => 1,
                'level' => 5,
                'question_text' => 'Menjadi panutan dalam menegakkan standar etika dan keadilan di organisasi. Menginspirasi tim untuk bertindak sesuai nilai perusahaan. Mengembangkan kebijakan dan strategi penerapan etika yang lebih luas.',
            ],

            // Communication (competence_id = 2)
            [
                'competence_id' => 2,
                'level' => 1,
                'question_text' => 'Bisa menyampaikan informasi secara jelas, baik langsung maupun lewat pesan digital (chat, email, dll.). Masih perlu arahan dalam menyusun komunikasi yang lebih kompleks. Kadang pesan kurang terstruktur atau butuh penjelasan ulang.',
            ],
            [
                'competence_id' => 2,
                'level' => 2,
                'question_text' => 'Bisa berkomunikasi dengan baik dalam situasi formal dan santai. Bisa mendengarkan dan merespons dengan jelas dalam percakapan sehari-hari. Perlu lebih banyak latihan dalam komunikasi formal atau profesional.',
            ],
            [
                'competence_id' => 2,
                'level' => 3,
                'question_text' => 'Bisa berbicara dengan tegas dan sopan saat menyampaikan informasi sulit atau sensitif. Bisa bekerja sama dengan tim dan menyampaikan pendapat dengan terstruktur. Terkadang masih perlu menyesuaikan komunikasi dengan audiens yang berbeda.',
            ],
            [
                'competence_id' => 2,
                'level' => 4,
                'question_text' => 'Bisa mengumpulkan dan mengolah informasi dari berbagai sumber untuk mendukung pekerjaan. Bisa menjelaskan ide dengan jelas dalam diskusi, presentasi, atau laporan tertulis. Mampu beradaptasi dengan audiens untuk memastikan pemahaman yang sama.',
            ],
            [
                'competence_id' => 2,
                'level' => 5,
                'question_text' => 'MBisa mengelola komunikasi tim dan organisasi secara terbuka dan efektif. Mampu menangani komunikasi dalam situasi sulit atau lintas budaya. Bisa menyusun strategi komunikasi yang jelas dan mudah dipahami oleh semua pihak.',
            ],

            // Innovation & Creativity (competence_id = 3)
            [
                'competence_id' => 3,
                'level' => 1,
                'question_text' => 'Mengidentifikasi masalah atau area yang bisa diperbaiki dalam proses kerja. Mencari referensi atau ide awal untuk solusi sederhana. Melaporkan hambatan yang berulang kepada atasan.',
            ],
            [
                'competence_id' => 3,
                'level' => 2,
                'question_text' => 'Berpartisipasi aktif dalam pelatihan atau diskusi terkait perbaikan proses kerja. Menggunakan data dan masukan dari tim untuk mencari solusi. Mengusulkan cara baru untuk meningkatkan efisiensi kerja.',
            ],
            [
                'competence_id' => 3,
                'level' => 3,
                'question_text' => 'Menerapkan teknologi atau metode baru yang relevan untuk meningkatkan produktivitas. Mengombinasikan cara lama dengan pendekatan yang lebih efektif. Mengukur dampak perubahan untuk memastikan perbaikan yang berkelanjutan.',
            ],
            [
                'competence_id' => 3,
                'level' => 4,
                'question_text' => 'Membimbing rekan kerja untuk memahami dan mengadopsi inovasi dalam pekerjaan. Mendorong partisipasi tim dalam mengembangkan ide-ide baru. Memfasilitasi brainstorming untuk mencari solusi terbaik.',
            ],
            [
                'competence_id' => 3,
                'level' => 5,
                'question_text' => 'Menciptakan budaya inovasi yang berkelanjutan dalam tim atau organisasi. Mengembangkan program perbaikan jangka panjang dengan teknologi dan kolaborasi lintas tim. Merancang kebijakan agar semua anggota tim dapat berkontribusi dalam inovasi.',
            ],

            // Customer Orientation (competence_id = 4)
            [
                'competence_id' => 4,
                'level' => 1,
                'question_text' => 'Bisa memahami kebutuhan dan harapan dasar pelanggan. Bisa mendengarkan dengan seksama untuk memberikan respons yang sesuai. Bisa berusaha memberikan layanan sesuai standar yang ditetapkan.',
            ],
            [
                'competence_id' => 4,
                'level' => 2,
                'question_text' => 'Bisa menyediakan layanan yang memenuhi atau melebihi ekspektasi pelanggan secara konsisten. Bisa mengambil langkah kecil untuk memastikan kepuasan pelanggan. Bisa memberikan informasi yang jelas dan tepat waktu untuk pengalaman positif.',
            ],
            [
                'competence_id' => 4,
                'level' => 3,
                'question_text' => 'Bisa mengidentifikasi dan menyelesaikan masalah pelanggan dengan cepat dan efektif. Bisa mencari solusi yang mengurangi ketidakpuasan dan mencegah masalah berulang. Bisa menunjukkan empati dan memberikan solusi yang memuaskan.',
            ],
            [
                'competence_id' => 4,
                'level' => 4,
                'question_text' => 'Bisa mengembangkan dan mengimplementasikan inisiatif untuk meningkatkan layanan pelanggan. Bisa mengumpulkan dan menganalisis umpan balik untuk perbaikan sistem. Bisa berkolaborasi dengan tim lintas fungsi untuk solusi yang lebih baik.',
            ],
            [
                'competence_id' => 4,
                'level' => 5,
                'question_text' => 'Bisa menciptakan dan menjaga hubungan jangka panjang dengan pelanggan secara profesional. Bisa menginisiasi strategi proaktif untuk memenuhi kebutuhan pelanggan sebelum masalah muncul. Bisa menjadi role model dalam budaya yang berorientasi pada kepuasan pelanggan.',
            ],

            // Teamwork (competence_id = 5)
            [
                'competence_id' => 5,
                'level' => 1,
                'question_text' => 'Bisa berpartisipasi aktif dalam kerja kelompok sesuai peran dan tanggung jawabnya. Bisa mendengarkan masukan dari anggota tim dan memberikan usulan. Bisa menjalin interaksi positif untuk membangun kepercayaan.',
            ],
            [
                'competence_id' => 5,
                'level' => 2,
                'question_text' => 'Bisa membantu rekan kerja dalam menyelesaikan tugas dan memberikan dukungan moral. Bisa berbagi informasi secara transparan untuk meningkatkan kolaborasi tim. Bisa membangun komitmen dan kedisiplinan untuk mencapai hasil.',
            ],
            [
                'competence_id' => 5,
                'level' => 3,
                'question_text' => 'Bisa mengenali kekuatan dan kelemahan anggota tim serta mengoptimalkan potensi mereka. Bisa mengambil keputusan berbasis masukan tim agar hasil lebih efektif. Bisa mengarahkan tim untuk mencapai target organisasi.',
            ],
            [
                'competence_id' => 5,
                'level' => 4,
                'question_text' => 'Bisa membangun sinergi antarunit kerja untuk memastikan kolaborasi lintas fungsi. Bisa mengelola konflik dalam tim dengan pendekatan konstruktif. Bisa menjaga komitmen jangka panjang dengan menyelaraskan tujuan individu dan organisasi.',
            ],
            [
                'competence_id' => 5,
                'level' => 5,
                'question_text' => 'Bisa membangun hubungan kerja yang konstruktif dan profesional. Bisa menjaga sinergi dengan unit kerja lain untuk memperkuat aliansi strategis. Bisa mengembangkan budaya kolaborasi berkelanjutan untuk hubungan produktif jangka panjang.',
            ],

            // Leadership (competence_id = 6)
            [
                'competence_id' => 6,
                'level' => 1,
                'question_text' => 'Bisa memberikan reward atau penghargaan untuk mendorong bawahan mencapai target. Bisa menetapkan aturan dan prosedur yang jelas dalam mengelola tim. Bisa memastikan pekerjaan tim berjalan sesuai standar yang diharapkan.',
            ],
            [
                'competence_id' => 6,
                'level' => 2,
                'question_text' => 'Bisa membangun kepercayaan dengan menunjukkan keteladanan dalam kepemimpinan. Bisa menunjukkan komitmen kuat terhadap nilai dan tujuan organisasi. Bisa memberikan keyakinan kepada tim bahwa kepemimpinan yang dijalankan kredibel.',
            ],
            [
                'competence_id' => 6,
                'level' => 3,
                'question_text' => 'Bisa memotivasi dan menginspirasi bawahan agar bekerja dengan semangat tinggi. Bisa menyampaikan visi dengan komunikasi yang jelas dan antusias. Bisa membangkitkan rasa bangga dalam tim dan meningkatkan kontribusi mereka.',
            ],
            [
                'competence_id' => 6,
                'level' => 4,
                'question_text' => 'Bisa membantu bawahan mengembangkan keterampilan dan potensi mereka secara mandiri. Bisa memberikan perhatian khusus pada kebutuhan individu dalam menyelesaikan masalah. Bisa melakukan pembinaan berkelanjutan sesuai kekuatan dan kelemahan tim.',
            ],
            [
                'competence_id' => 6,
                'level' => 5,
                'question_text' => 'Bisa mendorong bawahan untuk berpikir kritis dan kreatif dalam menghadapi tantangan. Bisa mengutamakan nilai organisasi dalam setiap keputusan dan tindakan tim. Bisa membangun wawasan yang lebih luas agar tim memahami visi dan misi organisasi.',
            ],

            // Business Acumen (competence_id = 7)
            [
                'competence_id' => 7,
                'level' => 1,
                'question_text' => 'Bisa mengidentifikasi perbedaan antara input dan output dalam proses kerja(business process). Bisa mengenali hambatan dan mencari cara meningkatkan efisiensi. Bisa mengoptimalkan sumber daya yang tersedia untuk hasil yang lebih baik.',
            ],
            [
                'competence_id' => 7,
                'level' => 2,
                'question_text' => 'Bisa menganalisis biaya dan keuntungan untuk mendukung efisiensi kerja. Bisa mengidentifikasi peluang penghematan biaya tanpa mengorbankan kualitas. Bisa memberikan rekomendasi berbasis data untuk meningkatkan efektivitas operasional.',
            ],
            [
                'competence_id' => 7,
                'level' => 3,
                'question_text' => 'Bisa mengembangkan ide atau rekomendasi untuk meningkatkan nilai tambah dalam area kerja. Bisa menemukan cara baru untuk meningkatkan kontribusi bisnis dengan lebih efisien. Bisa menyajikan ide inovatif untuk memperkuat daya saing organisasi.',
            ],
            [
                'competence_id' => 7,
                'level' => 4,
                'question_text' => 'Bisa mengembangkan aktivitas di luar bidang kerja untuk menemukan peluang bisnis baru. Bisa membangun kemitraan strategis untuk meningkatkan profitabilitas. Bisa melakukan riset pasar guna mengidentifikasi peluang bisnis potensial.',
            ],
            [
                'competence_id' => 7,
                'level' => 5,
                'question_text' => 'Bisa menciptakan peluang usaha baru dengan wawasan bisnis dan pemanfaatan tren pasar. Bisa menginisiasi proyek yang berdampak positif bagi bisnis. Bisa mendorong budaya inovasi agar ide bisnis baru terus berkembang.',
            ],

            // Problem Solving & Decision Making (competence_id = 8)
            [
                'competence_id' => 8,
                'level' => 1,
                'question_text' => 'Bisa mengumpulkan informasi dan memahami situasi sebelum mengambil tindakan. Bisa mengidentifikasi solusi awal yang sesuai dengan kebijakan organisasi. Bisa mengevaluasi informasi untuk memastikan tindakan relevan dengan tujuan kerja.',
            ],
            [
                'competence_id' => 8,
                'level' => 2,
                'question_text' => 'Bisa menciptakan peluang usaha baru dengan wawasan bisnis dan pemanfaatan tren pasar. Bisa menginisiasi proyek yang berdampak positif bagi bisnis. Bisa mendorong budaya inovasi agar ide bisnis baru terus berkembang.',
            ],
            [
                'competence_id' => 8,
                'level' => 3,
                'question_text' => 'Bisa membandingkan alternatif tindakan dengan mempertimbangkan risiko dan hasil yang mungkin timbul. Bisa memilih solusi terbaik dengan evaluasi yang hati-hati. Bisa menyeimbangkan risiko dan peluang keberhasilan untuk implementasi yang efektif.',
            ],
            [
                'competence_id' => 8,
                'level' => 4,
                'question_text' => 'Bisa menyusun solusi atas masalah yang berdampak luas dalam organisasi. Bisa mengidentifikasi solusi untuk masalah kompleks yang memengaruhi kinerja tim. Bisa membuat keputusan dengan mempertimbangkan mitigasi risiko yang diperlukan.',
            ],
            [
                'competence_id' => 8,
                'level' => 5,
                'question_text' => 'Bisa menghasilkan solusi strategis untuk masalah jangka panjang organisasi. Bisa mengembangkan kebijakan yang memperkuat daya saing perusahaan. Bisa mengambil keputusan besar dengan mempertimbangkan dampak luas dan mitigasi risiko.',
            ],

            // Achievement Orientation (competence_id = 9)
            [
                'competence_id' => 9,
                'level' => 1,
                'question_text' => 'Bisa mengidentifikasi tren sederhana yang memengaruhi pekerjaaBisa bekerja dengan baik sesuai standar yang ditetapkan. Bisa menunjukkan keinginan untuk terus belajar dan meningkatkan kualitas kerja. Bisa secara aktif mencari solusi untuk memperbaiki ketidakefisienan.',
            ],
            [
                'competence_id' => 9,
                'level' => 2,
                'question_text' => 'Bisa memastikan pencapaian standar kinerja sesuai persyaratan organisasi. Bisa bekerja keras untuk memenuhi target kualitas dan ketepatan waktu. Bisa menetapkan milestone untuk memantau kemajuan menuju target.',
            ],
            [
                'competence_id' => 9,
                'level' => 3,
                'question_text' => 'Bisa mencapai standar kerja yang lebih tinggi dari sebelumnya. Bisa memperbaiki metode kerja atau sistem untuk meningkatkan efisiensi. Bisa berfokus pada peningkatan layanan terkait waktu, biaya, dan kualitas.',
            ],
            [
                'competence_id' => 9,
                'level' => 4,
                'question_text' => 'BBisa menetapkan sasaran yang menantang tetapi realistis untuk hasil optimal. Bisa merealisasikan ide-ide baru yang belum pernah dicoba sebelumnya. Bisa mengembangkan target kerja lebih tinggi dari standar yang ada.',
            ],
            [
                'competence_id' => 9,
                'level' => 5,
                'question_text' => 'Bisa menginspirasi dan memotivasi tim untuk mencapai kinerja lebih tinggi. Bisa menjadi panutan dalam pencapaian standar kerja berkualitas tinggi. Bisa menciptakan budaya kerja yang fokus pada pencapaian kinerja unggul.',
            ],

            // Strategic Thinking (competence_id = 10)
            [
                'competence_id' => 10,
                'level' => 1,
                'question_text' => 'Bisa menyadari dampak jangka panjang dari keputusan yang diambil. Bisa mencoba memahami arah strategis organisasi. Bisa terlibat dalam diskusi sederhana tentang perencanaan jangka panjang.',
            ],
            [
                'competence_id' => 10,
                'level' => 2,
                'question_text' => 'Bisa menghubungkan tujuan pribadi dan tim dengan visi organisasi. Bisa mempertimbangkan dampak keputusan terhadap area kerja lainnya. Bisa berpikir proaktif dalam mengidentifikasi risiko sederhana yang memengaruhi tujuan.',
            ],
            [
                'competence_id' => 10,
                'level' => 3,
                'question_text' => 'Bisa menyusun rencana kerja dengan mempertimbangkan kebutuhan jangka panjang. Bisa mengidentifikasi tren industri yang relevan dan mengusulkan penyesuaian. Bisa berkolaborasi dengan tim lain untuk keselarasan tujuan strategis.',
            ],
            [
                'competence_id' => 10,
                'level' => 4,
                'question_text' => 'Bisa menganalisis data untuk memahami tren yang mempengaruhi bisnis di masa depan. Bisa menyusun strategi komprehensif untuk mendukung visi jangka panjang. Bisa mengantisipasi hambatan strategis dan menyusun mitigasi risiko.',
            ],
            [
                'competence_id' => 10,
                'level' => 5,
                'question_text' => 'Bisa mengarahkan visi strategis dengan mempertimbangkan tren global. Bisa membimbing tim dalam menentukan prioritas strategis. Bisa mengidentifikasi peluang bisnis baru untuk pertumbuhan organisasi..',
            ],
        ];

        foreach ($questions as $q) {
            DB::table('question')->updateOrInsert(
            ['competence_id' => $q['competence_id'], 'level' => $q['level']],
            ['question_text' => $q['question_text']]
            );
        }
    }
}
