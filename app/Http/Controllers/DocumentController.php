<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Menerima dan Memvalidasi Dokumen.
     */
    public function upload(Request $request)
    {
        // 1. Pastikan Otorisasi di tingkat Form Request / Controller
        // Contoh: User tidak terauthentikasi akan ditolak oleh middleware di routes,
        // tapi jika ingin lebih spesifik dapat menambah logic tambahan di sini.
        // 2. Validasi Super Ketat
        $request->validate([
            'document' => [
                'required',
                'file',
                'max:10240', // Ukuran Maksimal 10MB
                
                // Rule mimes & mimetypes di Laravel otomatis memeriksa "Magic Bytes" 
                // menggunakan ekstensi PHP fileinfo. Ekstensi palsu (misal php di-rename jadi pdf) akan ketahuan
                'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg',
                'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,image/jpeg,image/png',
                
                // Rule scanner Antirus, akan otomatis menolak file bervirus
                'clamav', 
            ]
        ], [
            'document.clamav' => 'Peringatan: File ini mengandung virus dan tidak dapat diunggah!',
        ]);
        $file = $request->file('document');
        // 3. Sanitasi Nama File (Pilar Penting!)
        // JANGAN pernah menggunakan nama asli user (getClientOriginalName) sebagai nama file di disk,
        // karena rentan path traversal dan executable hidden script. 
        // hashName() akan membuat nama random yang aman (contoh: a7x..y7z.pdf)
        $safeFileName = $file->hashName();
        // 4. Proses Pindah ke Private Disk
        $path = $file->storeAs('secure_documents', $safeFileName, 'private');
        // 5. Simpan Nama Asli dan Path ke Database agar nanti bisa di-download dengan nama aslinya
        Document::create([
            'user_id' => auth()->id(),
            'original_name' => $file->getClientOriginalName(),
            'file_path' => $path, // Contoh hasil: secure_documents/a7x..y7z.pdf
            'mime_type' => $file->getMimeType(),
        ]);
        return redirect()->back()->with('success', 'Dokumen aman telah diunggah!');
    }
    /**
     * Memproses Unduhan Dokumen (Akses Terbatas)
     */
    public function download(Document $document)
    {
        // 1. Authorization Gate/Policy
        // Sistem hanya memperbolehkan akses jika policy lolos.
        // Anda juga dapat melakukan pengecekan manual, misal: if ($document->user_id !== auth()->id()) abort(403);
        $this->authorize('view', $document);
        // 2. Cek apakah file fisik eksis di private storage
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'File secara fisik tidak ditemukan di sistem.');
        }
        // 3. Beri return file via controller, yang disembunyikan streamnya ke pengguna 
        return Storage::disk('private')->download(
            $document->file_path, 
            $document->original_name
        );
    }
}
