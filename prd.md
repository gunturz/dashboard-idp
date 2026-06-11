# Project Requirement Document (PRD)

## 1. Ringkasan Produk

Website ini adalah sistem Dashboard Individual Development Plan (IDP) dan Talent Promotion untuk mengelola proses pengembangan talent dari tahap registrasi, penyusunan development plan, assessment kompetensi, monitoring aktivitas IDP, validasi mentor, validasi finance, review panelis, keputusan akhir promosi, sampai arsip dan ekspor laporan PDF.

Sistem dibangun dengan Laravel, Blade, Livewire, autentikasi berbasis role, notifikasi internal, upload dokumen, preview/download file, serta pemisahan data per siklus pengembangan melalui entitas `development_sessions`.

## 2. Tujuan Produk

1. Menyediakan satu platform terpusat untuk memantau progres pengembangan talent.
2. Memastikan setiap proses promosi memiliki alur approval yang jelas: Talent, Atasan, Mentor, Finance, Panelis, dan PDC Admin.
3. Mengurangi pencatatan manual melalui logbook IDP, assessment kompetensi, upload bukti kegiatan, dan riwayat digital.
4. Memastikan setiap siklus promosi terdokumentasi sebagai arsip historis yang dapat ditinjau dan diekspor ke PDF.
5. Mendukung multi-role account sehingga satu user dapat memiliki lebih dari satu role dan memilih role aktif saat login.

## 3. Role Pengguna

### 3.1 PDC Admin

PDC Admin adalah role pengelola utama sistem. PDC Admin bertanggung jawab atas master data, user, kompetensi, development plan, monitoring progres talent, validasi finance dari sisi admin, pengiriman review panelis, keputusan akhir, arsip, dan laporan PDF.

### 3.2 Talent

Talent adalah peserta program IDP/promosi. Talent mengisi assessment kompetensi, mengunggah aktivitas IDP, mengunggah project improvement, melihat status validasi, menerima notifikasi, dan melihat riwayat siklus pengembangan yang sudah selesai.

### 3.3 Atasan

Atasan adalah user yang menilai kompetensi talent dari sisi atasan langsung, memantau progres talent aktif, melihat logbook, dan melihat riwayat talent yang pernah berada di bawah tanggung jawabnya pada siklus tertentu.

### 3.4 Mentor

Mentor adalah user pembimbing talent. Mentor memvalidasi aktivitas IDP talent, melihat dashboard mentee, memantau status exposure, mentoring, learning, dan melihat riwayat logbook talent pada siklus yang sudah selesai.

### 3.5 Finance

Finance adalah user yang memvalidasi project improvement yang dikirimkan oleh PDC Admin kepada finance tertentu. Finance dapat menyetujui atau menolak project dengan catatan feedback.

### 3.6 Panelis

Panelis adalah user reviewer akhir yang menilai talent pada tahap panelis. Panelis melihat talent yang ditugaskan, membuka detail talent dan logbook, mengisi skor aspek penilaian, komentar, rekomendasi, dan melihat riwayat penilaian.

## 4. Scope Produk

### 4.1 In Scope

1. Login, register, verifikasi email, forgot password, reset password, dan login Google.
2. Pemilihan role aktif untuk user multi-role.
3. Dashboard dan menu khusus per role.
4. Master data company, department, position, role, IDP type, competencies, questions, dan target kompetensi per posisi.
5. Manajemen user oleh PDC Admin, termasuk assign role, update profil, delete user, dan reset password default.
6. Development plan per talent atau grup talent.
7. Assessment kompetensi oleh talent dan atasan.
8. Pemilihan top gap kompetensi oleh PDC Admin.
9. IDP Monitoring untuk Exposure, Mentoring, dan Learning.
10. Upload dokumen logbook dan project improvement.
11. Validasi logbook oleh mentor.
12. Validasi project improvement oleh finance.
13. Assignment dan review panelis.
14. Lock/unlock progress oleh PDC Admin pada tahap panelis.
15. Keputusan akhir promosi dan arsip development session.
16. Notifikasi internal per role.
17. Preview/download file dengan proteksi akses.
18. Ekspor laporan talent ke PDF.

### 4.2 Out of Scope Saat Ini

1. Integrasi HRIS/payroll eksternal.
2. E-signature dokumen.
3. Kalender interview/panel otomatis.
4. Approval multi-level di luar role yang tersedia.
5. Mobile app native.
6. SLA reminder otomatis berbasis jadwal, kecuali notifikasi internal yang sudah ada.

## 5. Alur Bisnis Utama

### 5.1 Registrasi dan Login

1. User membuka halaman register.
2. User mengisi data identitas, perusahaan, departemen, posisi, email, username, password, dan role awal sesuai alur registrasi.
3. Sistem menyediakan endpoint departemen berdasarkan company.
4. User dapat menyelesaikan step kompetensi registrasi bila diperlukan.
5. User login menggunakan username/password atau Google.
6. Jika user memiliki lebih dari satu role, sistem mengarahkan ke halaman pilih role.
7. Setelah role aktif dipilih, user diarahkan ke dashboard role masing-masing.

### 5.2 Penyusunan Development Plan

1. PDC Admin membuka halaman Development Plan.
2. PDC Admin memilih company, department, target position, talent, atasan, mentor, start date, dan target date.
3. Sistem memfilter talent berdasarkan posisi sumber yang valid terhadap posisi target.
4. Sistem membuat atau memperbarui `promotion_plan` dan `development_sessions`.
5. Talent yang sudah memiliki plan aktif masuk ke Progress Talent.
6. Jika development plan belum lengkap, Talent tidak dapat mengisi IDP monitoring.

### 5.3 Assessment Kompetensi

1. Talent membuka halaman competency.
2. Sistem menampilkan kompetensi, pertanyaan per level, dan target level berdasarkan posisi tujuan.
3. Talent mengisi skor 0 sampai 5.
4. Sistem membuat `assessment_session` aktif dan `detail_assessment`.
5. Atasan menerima notifikasi untuk memberi penilaian.
6. Atasan mengisi skor kompetensi untuk talent.
7. Sistem menghitung final score dan gap score terhadap standar target posisi.
8. PDC Admin dapat memilih top 3 gap prioritas.

### 5.4 IDP Monitoring dan Logbook

1. Talent membuka IDP Monitoring setelah development plan lengkap.
2. Talent memilih tab Exposure, Mentoring, atau Learning.
3. Talent mengisi tema, tanggal kegiatan, aktivitas/deskripsi/action plan/platform/lokasi sesuai tipe.
4. Talent wajib mengunggah minimal satu dokumen untuk submit baru, maksimal lima file, ukuran maksimal 5 MB per file.
5. Sistem menyimpan aktivitas dengan status `Pending`.
6. Mentor terkait dan PDC Admin menerima notifikasi.
7. Talent dapat mengedit atau menghapus logbook selama progress belum dikunci dan sesi masih aktif.
8. Mentor memvalidasi logbook menjadi `Approved` atau `Rejected`.
9. Talent dan PDC Admin menerima notifikasi hasil validasi mentor.

### 5.5 Project Improvement dan Finance Validation

1. Talent mengunggah Project Improvement dengan judul dan file pendukung.
2. PDC Admin meninjau project dan dapat meminta validasi finance ke user finance tertentu.
3. Finance menerima permintaan validasi.
4. Finance memilih keputusan `Approved` atau `Rejected` dan dapat menulis catatan.
5. Sistem menyimpan keputusan dalam `finance_feedback` dengan format `[Approved] catatan` atau `[Rejected] catatan`.
6. Status project berubah menjadi `Verified` jika approved atau `Rejected` jika rejected.
7. Talent dan PDC Admin menerima notifikasi keputusan finance.

### 5.6 Review Panelis

1. PDC Admin membuka halaman Panelis Review.
2. PDC Admin memilih talent yang siap direview dan mengirim assignment ke panelis.
3. Sistem membuat data `panelis_assessments` per panelis, per talent, dan per development session.
4. Status promotion plan berubah menuju `Pending Panelis`.
5. Panelis melihat daftar talent yang ditugaskan dan belum dinilai.
6. Panelis membuka detail talent, logbook, dan form penilaian.
7. Panelis mengisi skor per aspek, komentar, rekomendasi, dan tanggal penilaian.
8. Sistem menyimpan total skor, skor JSON per aspek, komentar, rekomendasi, dan tanggal penilaian.
9. PDC Admin menerima notifikasi bahwa panelis telah menyelesaikan review.
10. PDC Admin dapat menandai review panelis selesai dan menentukan status akhir.

### 5.7 Keputusan Akhir dan Arsip

1. Setelah seluruh review dan validasi cukup, PDC Admin menentukan keputusan akhir.
2. Status akhir yang didukung meliputi `Promoted`, `Not Promoted`, `Ready Now`, `Ready in 1-2 Years`, `Ready in > 2 Years`, dan `Not Ready`.
3. Sistem mengarsipkan development session dengan `is_active = false`.
4. Data terkait pada siklus tersebut, seperti promotion plan, assessment, logbook, project, dan panelis assessment, tidak lagi bercampur dengan siklus baru.
5. Riwayat dapat dilihat oleh Talent, Atasan, Mentor, Finance, Panelis, dan PDC Admin sesuai scope akses masing-masing.

### 5.8 Ekspor Laporan PDF

1. PDC Admin membuka arsip progress talent.
2. PDC Admin membuka detail talent pada sesi historis tertentu.
3. PDC Admin memilih export PDF.
4. Sistem menghasilkan laporan PDF berisi data profil, target posisi, kompetensi, IDP activity, project improvement, dan hasil panelis sesuai template `pdc_admin/pdf_export.blade.php`.

## 6. Kebutuhan Fungsional Per Role

### 6.1 PDC Admin

#### Dashboard

1. Sistem harus menampilkan statistik jumlah user per role: Talent, Mentor, Atasan, Finance, dan Panelis.
2. Sistem harus menampilkan total user, talent on progress, pending finance, dan pending panelis.
3. Sistem harus menampilkan talent aktif yang sedang berada dalam siklus promosi.
4. Data talent dikelompokkan berdasarkan company dan target position.

#### Progress Talent

1. PDC Admin dapat melihat seluruh talent yang sudah dibuatkan development plan dan belum final.
2. PDC Admin dapat membuka detail grup company/position.
3. PDC Admin dapat membuka detail talent.
4. PDC Admin dapat melihat assessment, gap, logbook, project improvement, dan status validasi.
5. PDC Admin dapat memilih top gap prioritas.

#### Development Plan

1. PDC Admin dapat membuat development plan baru.
2. PDC Admin dapat mengedit development plan grup talent.
3. PDC Admin dapat menghapus development plan.
4. Sistem harus memastikan target position, mentor, atasan, start date, dan target date tersimpan.
5. Sistem harus mendukung multiple mentor melalui `mentor_ids`.
6. Sistem harus membuat development session aktif untuk setiap talent dalam plan.

#### Finance Validation

1. PDC Admin dapat melihat daftar project improvement yang membutuhkan validasi finance.
2. PDC Admin dapat meminta validasi finance untuk project tertentu.
3. PDC Admin dapat melihat hasil validasi finance dan feedback.
4. PDC Admin menerima notifikasi ketika finance memberi keputusan.

#### Kompetensi

1. PDC Admin dapat mengelola pertanyaan kompetensi per level.
2. PDC Admin dapat mengatur target score kompetensi per posisi.
3. Perubahan target score digunakan dalam perhitungan gap assessment.

#### User Management

1. PDC Admin dapat membuat user.
2. PDC Admin dapat mengedit username, nama, email, company, department, dan position.
3. PDC Admin dapat assign satu atau lebih role ke user.
4. PDC Admin dapat reset password user ke default `Password123`.
5. PDC Admin dapat menghapus user sesuai aturan relasi data.
6. User yang datanya diperbarui harus menerima notifikasi.

#### Company dan Department Management

1. PDC Admin dapat menambah, mengedit, dan menghapus company.
2. Company tidak boleh dihapus jika masih memiliki user.
3. Saat company dihapus, department di bawahnya ikut dihapus jika tidak ada user terkait.
4. PDC Admin dapat menambah, mengedit, dan menghapus department per company.
5. Department tidak boleh dihapus jika masih memiliki user.

#### Panelis Review

1. PDC Admin dapat melihat talent yang siap masuk panelis.
2. PDC Admin dapat mengirim assignment review ke panelis.
3. PDC Admin dapat melihat detail hasil review panelis.
4. PDC Admin dapat menyelesaikan proses panelis dan menentukan keputusan akhir.
5. PDC Admin dapat lock/unlock progress talent agar talent tidak mengubah data saat review.

#### Arsip dan PDF

1. PDC Admin dapat melihat arsip development session yang sudah final.
2. Arsip harus menampilkan satu baris per development session, bukan hanya satu baris per user.
3. PDC Admin dapat membuka detail arsip.
4. PDC Admin dapat melihat logbook arsip.
5. PDC Admin dapat export PDF laporan talent per sesi.

### 6.2 Talent

#### Dashboard

1. Talent dapat melihat ringkasan profil, company, department, position, mentor, atasan, target position, status promotion plan, dan notifikasi.
2. Talent hanya dapat mengakses dashboard jika memiliki role talent.

#### Competency Assessment

1. Talent dapat melihat daftar kompetensi dan pertanyaan per level.
2. Talent dapat mengisi skor kompetensi 0 sampai 5.
3. Talent tidak dapat mengirim assessment jika progress dikunci oleh PDC Admin.
4. Setelah submit, sistem membuat assessment session aktif dan memberi notifikasi ke Atasan dan PDC Admin.

#### IDP Monitoring

1. Talent dapat membuka tab Exposure, Mentoring, dan Learning.
2. Talent hanya dapat mengakses IDP Monitoring jika development plan lengkap.
3. Talent dapat submit aktivitas dengan bukti dokumen.
4. Talent dapat mengedit aktivitas dan status dikembalikan ke `Pending`.
5. Talent dapat menghapus aktivitas selama sesi aktif dan progress tidak dikunci.
6. Talent dapat melihat detail logbook dan status validasinya.

#### Project Improvement

1. Talent dapat mengunggah project improvement dengan judul dan file.
2. File project dapat berupa gambar, PDF, dokumen office, presentasi, spreadsheet, atau zip sesuai validasi sistem.
3. Talent menerima notifikasi ketika finance memberi keputusan.

#### Riwayat

1. Talent dapat melihat riwayat development session yang sudah selesai atau final.
2. Talent dapat membuka detail riwayat per session.
3. Detail riwayat harus menampilkan assessment, gap, jumlah aktivitas Exposure/Mentoring/Learning, project improvement, hasil panelis, rata-rata aspek panelis, dan komentar panelis.

### 6.3 Atasan

#### Dashboard

1. Atasan dapat melihat talent aktif yang menjadi bawahannya.
2. Sistem menampilkan total talent, assessment pending, dan talent on track.
3. Talent yang tampil sebagai pending assessment adalah talent yang sudah memiliki assessment session dari talent tetapi belum memiliki skor atasan.

#### Assessment Atasan

1. Atasan dapat membuka halaman assessment untuk talent bawahannya.
2. Atasan hanya dapat menilai talent yang memiliki assessment session aktif.
3. Atasan mengisi skor 0 sampai 5 untuk setiap kompetensi.
4. Sistem menghitung gap score berdasarkan rata-rata skor talent dan atasan dibanding target kompetensi posisi.
5. Talent dan PDC Admin menerima notifikasi setelah assessment atasan selesai.

#### Monitoring

1. Atasan dapat melihat progres talent aktif.
2. Atasan dapat membuka detail monitoring talent.
3. Atasan dapat melihat logbook, assessment, project improvement, dan standar kompetensi.
4. Atasan dapat membuka detail item logbook.

#### Riwayat

1. Atasan dapat melihat riwayat talent yang pada development session tersebut memiliki `atasan_id` sesuai user login.
2. Riwayat dapat difilter berdasarkan search, periode, perusahaan, dan departemen.
3. Atasan dapat membuka detail riwayat dan logbook per session.

### 6.4 Mentor

#### Dashboard

1. Mentor dapat melihat daftar mentee aktif.
2. Sistem menampilkan top gap talent, status logbook pending/approved/rejected, dan progress jumlah Exposure/Mentoring/Learning.
3. Talent yang siklusnya sudah final tidak ditampilkan sebagai mentee aktif.

#### Validasi Logbook

1. Mentor dapat melihat logbook dari mentee yang terkait dengan dirinya.
2. Mentor dapat melihat tab Exposure, Mentoring, dan Learning.
3. Mentor dapat membuka bukti dokumen yang diunggah talent.
4. Mentor dapat mengubah status logbook menjadi `Approved` atau `Rejected`.
5. Mentor tidak dapat memvalidasi logbook dari sesi yang sudah tidak aktif.
6. Mentor tidak dapat memvalidasi logbook talent yang bukan mentee atau tidak memiliki relasi validasi.
7. Talent dan PDC Admin menerima notifikasi setelah validasi mentor.

#### Riwayat

1. Mentor dapat melihat talent yang pernah dibimbingnya pada development session final.
2. Mentor dapat membuka riwayat logbook per talent dan session.
3. Data riwayat harus mengambil data berdasarkan `development_session_id` agar tidak bercampur dengan siklus baru.

### 6.5 Finance

#### Dashboard

1. Finance dapat melihat project improvement yang ditugaskan kepadanya.
2. Sistem menampilkan total project, pending, approved, dan rejected.
3. Project dikelompokkan berdasarkan company talent.
4. Dashboard memisahkan project pending dan history keputusan.

#### Permintaan Validasi

1. Finance dapat melihat project yang memiliki feedback dari PDC Admin, ditugaskan ke finance login, berstatus `Pending`, dan belum memiliki `finance_feedback`.
2. Finance dapat membuka dokumen project untuk validasi.
3. Finance dapat memberi keputusan `Approved` atau `Rejected`.
4. Finance dapat menambahkan catatan feedback.
5. Setelah keputusan disimpan, project masuk ke riwayat.

#### Riwayat

1. Finance dapat melihat project yang sudah diberi keputusan.
2. Finance dapat melakukan pencarian berdasarkan nama talent.
3. Riwayat dikelompokkan berdasarkan company.

### 6.6 Panelis

#### Dashboard

1. Panelis dapat melihat talent dengan status `Pending Panelis` yang ditugaskan kepadanya.
2. Talent yang tampil adalah talent yang memiliki panelis assessment aktif dan belum memiliki skor panelis.
3. Data dikelompokkan berdasarkan company dan target position.

#### Review Talent

1. Panelis dapat membuka detail talent.
2. Panelis dapat melihat profil talent, target posisi, mentor, atasan, assessment, standar kompetensi, top gap, IDP count, dan project improvement.
3. Panelis dapat membuka logbook talent berdasarkan Exposure, Mentoring, dan Learning.
4. Panelis dapat membuka detail item logbook.

#### Penilaian

1. Panelis dapat membuka form penilaian talent yang ditugaskan.
2. Sistem harus mencegah panelis menilai talent yang tidak ditugaskan melalui policy/gate.
3. Panelis mengisi skor per aspek, komentar, rekomendasi, dan tanggal penilaian.
4. Sistem menghitung total skor dari seluruh aspek.
5. Sistem menyimpan hasil ke `panelis_assessments`.
6. PDC Admin menerima notifikasi setelah penilaian selesai.

#### History

1. Panelis dapat melihat seluruh penilaian yang pernah dibuat olehnya.
2. Riwayat harus memuat data development session, posisi sumber, posisi target, project improvement, dan profil talent.

## 7. Kebutuhan Data

### 7.1 Entitas Utama

1. `users`: akun pengguna, identitas, company, department, position, role utama, mentor, atasan, foto.
2. `role`: master role.
3. `user_role`: relasi many-to-many user dan role.
4. `company`: master perusahaan.
5. `department`: master departemen per perusahaan.
6. `position`: master posisi dan grade level.
7. `idp_type`: master tipe IDP, yaitu Exposure, Mentoring, Learning.
8. `competencies`: master kompetensi.
9. `question`: pertanyaan kompetensi per level.
10. `position_target_competence`: target level kompetensi per posisi.
11. `development_sessions`: siklus development/promotion per talent.
12. `promotion_plan`: target promosi, mentor, status, periode, dan relasi session.
13. `assessment_session`: header assessment talent dan atasan.
14. `detail_assessment`: skor talent, skor atasan, gap, dan notes/top gap.
15. `idp_activity`: logbook aktivitas IDP.
16. `improvement_project`: project improvement dan validasi finance.
17. `panelis_assessments`: assignment dan hasil penilaian panelis.
18. `documents`: file upload aman.
19. `app_notifications`: notifikasi internal.
20. `audit_activity`: pencatatan audit aktivitas.

### 7.2 Status Penting

Promotion plan:

1. `Draft`
2. `In Progress`
3. `Pending Panelis`
4. `Approved Panelis`
5. `Rejected Panelis`
6. `Ready`
7. `Promoted`
8. `Not Promoted`
9. `Ready Now`
10. `Ready in 1-2 Years`
11. `Ready in > 2 Years`
12. `Not Ready`

IDP activity:

1. `Pending`
2. `Approved`
3. `Rejected`

Improvement project:

1. `On Progress`
2. `Pending`
3. `Verified`
4. `Rejected`

Finance feedback:

1. `[Approved] catatan`
2. `[Rejected] catatan`

## 8. Hak Akses dan Keamanan

1. Seluruh dashboard role harus dilindungi middleware `auth` dan `verified`.
2. Setiap route role harus menggunakan middleware khusus: `talent.only`, `pdc_admin.only`, `atasan.only`, `mentor.only`, `finance.only`, dan `panelis.only`.
3. User multi-role harus memilih role aktif sebelum masuk dashboard.
4. File upload/download harus melewati validasi akses.
5. File preview harus memastikan path file terkait dengan dokumen/logbook/project yang valid.
6. Panelis hanya boleh submit penilaian untuk talent yang ditugaskan.
7. Mentor hanya boleh validasi logbook yang terkait dengan dirinya atau mentee yang valid.
8. Atasan hanya boleh mengakses talent yang menjadi bawahannya pada session aktif atau historis terkait.
9. Data historis harus dibatasi berdasarkan `development_session_id` dan relasi role pada siklus tersebut.
10. Password reset admin menggunakan default `Password123` dan user harus diberi notifikasi untuk mengganti password.
11. Login harus memiliki throttle untuk mencegah brute force.
12. Forgot password harus memiliki throttle.
13. Security header middleware harus diterapkan sesuai konfigurasi aplikasi.

## 9. Notifikasi

Sistem harus mengirim notifikasi internal untuk event berikut:

1. Talent selesai mengisi assessment kompetensi.
2. Atasan selesai memberi assessment.
3. Talent membuat, mengedit, atau menghapus IDP Monitoring.
4. Mentor memberi validasi IDP Monitoring.
5. PDC Admin memperbarui profil user.
6. PDC Admin reset password user.
7. PDC Admin meminta validasi finance.
8. Finance memberi keputusan project improvement.
9. PDC Admin mengirim review ke panelis.
10. Panelis selesai memberi review.
11. Perubahan status penting pada proses promotion plan.

Setiap role memiliki halaman notifikasi dan fitur mark all read. Komponen Livewire notifikasi juga mendukung mode edit, select all, dan delete selected.

## 10. File dan Dokumen

### 10.1 IDP Monitoring

1. Submit baru wajib memiliki minimal 1 file.
2. Maksimal 5 file.
3. Maksimal ukuran 5 MB per file.
4. Format yang diterima: PNG, JPG, JPEG, PDF, DOC, DOCX, XLS, XLSX.
5. Multi-file disimpan sebagai JSON path dan daftar nama file.

### 10.2 Project Improvement

1. Project wajib memiliki file.
2. Maksimal ukuran 10 MB.
3. Format yang diterima: PNG, JPG, JPEG, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP.

### 10.3 Preview dan Download

1. Sistem harus dapat menampilkan preview file yang didukung browser.
2. File yang tidak bisa dipreview harus diarahkan untuk download.
3. Nama file download harus aman dan informatif.
4. Response file harus menggunakan header no-cache untuk data sensitif.

## 11. Kebutuhan Non-Fungsional

### 11.1 Usability

1. Menu dan dashboard harus konsisten per role.
2. Status penting harus mudah dibaca melalui badge/indikator.
3. Tabel harus mendukung pencarian dan filter jika jumlah data besar.
4. Detail talent harus mudah dipindai: profil, kompetensi, gap, logbook, project, panelis.

### 11.2 Reliability

1. Setiap operasi multi-data seperti development plan dan archive session harus menggunakan transaksi database.
2. Data lama tidak boleh hilang saat siklus baru dibuat.
3. Arsip harus tetap bisa dibuka meskipun user memiliki siklus aktif baru.

### 11.3 Performance

1. Query dashboard harus menggunakan eager loading untuk relasi besar.
2. Tabel Livewire harus mendukung pagination/filter.
3. Grouping data company/position harus dilakukan dengan dataset yang sudah terfilter.

### 11.4 Maintainability

1. Logic role harus dipisahkan melalui middleware dan policy.
2. Relasi model harus menjadi sumber utama akses data.
3. Logic development session harus konsisten digunakan di semua role.
4. Status final harus didefinisikan konsisten di controller dan view.

### 11.5 Auditability

1. Aktivitas penting harus dapat dicatat pada audit activity.
2. Perubahan data user oleh admin harus dapat ditelusuri melalui notifikasi/audit.
3. Keputusan finance dan panelis harus menyimpan identitas reviewer serta timestamp.

## 12. Acceptance Criteria Global

1. User dengan satu role langsung diarahkan ke dashboard role tersebut.
2. User dengan beberapa role diarahkan ke halaman pilih role.
3. Talent tidak bisa membuka IDP Monitoring sebelum development plan lengkap.
4. Talent tidak bisa mengubah assessment/logbook/project jika promotion plan dikunci.
5. Atasan hanya bisa memberi assessment untuk talent bawahannya.
6. Mentor hanya bisa memvalidasi logbook yang terkait dengannya.
7. Finance hanya melihat project yang ditugaskan kepadanya.
8. Panelis hanya melihat dan menilai talent yang ditugaskan kepadanya.
9. PDC Admin dapat melihat seluruh progres lintas company dan role.
10. Setiap siklus promosi final harus masuk arsip dan tidak bercampur dengan siklus baru.
11. Ekspor PDF harus mengambil data dari development session yang dipilih.
12. Notifikasi terkirim ke role terkait pada setiap event utama.
13. File upload yang tidak memenuhi ukuran/format harus ditolak.
14. File preview/download harus menolak akses tanpa otorisasi.

## 13. Success Metrics

1. 100% talent aktif memiliki development session yang dapat ditelusuri.
2. 100% assessment talent memiliki pasangan assessment atasan atau status pending yang jelas.
3. 100% logbook baru memiliki status validasi yang jelas: Pending, Approved, atau Rejected.
4. 100% project yang dikirim ke finance memiliki keputusan final finance atau status pending yang jelas.
5. 100% penilaian panelis tersimpan dengan panelis, skor, komentar/rekomendasi, tanggal, dan development session.
6. 100% siklus final dapat dibuka dari riwayat/arsip dan diekspor PDF oleh PDC Admin.

## 14. Risiko dan Catatan Implementasi

1. Beberapa status final digunakan berulang di banyak controller. Sebaiknya dibuat constant/shared helper agar tidak terjadi inkonsistensi.
2. Format `finance_feedback` saat ini menyimpan keputusan sebagai prefix string. Untuk pengembangan berikutnya, disarankan memisahkan `finance_decision` dan `finance_feedback_note`.
3. Multiple mentor menggunakan JSON `mentor_ids`. Query JSON harus dijaga kompatibilitasnya dengan database yang digunakan.
4. Beberapa role membaca data historis berdasarkan session. Semua fitur baru harus selalu membawa `development_session_id`.
5. Reset password default perlu disertai kebijakan wajib ganti password untuk keamanan yang lebih kuat.
6. Upload file multi-format perlu audit berkala untuk mencegah file berbahaya.
7. Nama role harus dinormalisasi karena sistem mengenali variasi seperti `admin`, `pdc admin`, `pdc_admin`, `panelis`, dan variasi capitalization.

## 15. Roadmap Rekomendasi

### Phase 1: Stabilization

1. Standarisasi konstanta status final.
2. Tambahkan test untuk middleware role, development session archive, dan akses file.
3. Pisahkan decision finance dari text feedback.
4. Tambahkan validasi wajib ganti password setelah reset admin.

### Phase 2: Workflow Enhancement

1. Tambahkan reminder otomatis untuk assessment/logbook/finance/panelis yang pending.
2. Tambahkan dashboard SLA per role.
3. Tambahkan komentar threaded pada logbook atau project improvement.
4. Tambahkan export Excel untuk arsip progress talent.

### Phase 3: Governance

1. Tambahkan audit trail lengkap untuk perubahan status promosi.
2. Tambahkan approval matrix yang dapat dikonfigurasi.
3. Tambahkan reporting lintas company, department, dan posisi.
4. Tambahkan integrasi HRIS untuk sinkronisasi data user, posisi, dan struktur organisasi.
