<?php

namespace App\Http\Controllers;

use App\Models\IdpActivity;
use App\Models\ImprovementProject;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FilePreviewController extends Controller
{
    public function show(Request $request, string $path): BinaryFileResponse|RedirectResponse|Response
    {
        $path = ltrim($path, '/');

        if ($path === '' || str_contains($path, '..')) {
            return $this->missingFileResponse();
        }

        if (! Storage::disk('public')->exists($path)) {
            return $this->missingFileResponse();
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $absolutePath = Storage::disk('public')->path($path);
        $mimeType = Storage::disk('public')->mimeType($path) ?? 'application/octet-stream';
        $fileContext = $this->resolveFileContext($path);
        $downloadFilename = $this->buildDownloadFilename(
            $fileContext['original_name'] ?? basename($path),
            $fileContext['talent_name'] ?? 'Talent',
            $extension
        );

        if ($request->boolean('raw')) {
            return response()->file($absolutePath, array_merge([
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . addslashes(basename($path)) . '"',
            ], $this->noCacheHeaders()));
        }

        if ($request->boolean('download') || ! $this->canPreviewInBrowser($mimeType, $extension)) {
            return response()->download($absolutePath, $downloadFilename, array_merge([
                'Content-Type' => $mimeType,
            ], $this->noCacheHeaders()));
        }

        return response()->view('files.preview', [
            'path' => $path,
            'filename' => $fileContext['display_name'] ?? $fileContext['original_name'] ?? basename($path),
            'downloadFilename' => $downloadFilename,
            'extension' => $extension,
            'mimeType' => $mimeType,
            'fileUrl' => route('files.preview', ['path' => $path, 'raw' => 1]),
            'downloadUrl' => route('files.preview', ['path' => $path, 'download' => 1]),
        ], 200, $this->noCacheHeaders());
    }

    protected function canPreviewInBrowser(string $mimeType, string $extension): bool
    {
        if (Str::startsWith($mimeType, 'image/')) {
            return true;
        }

        return in_array($mimeType, [
            'application/pdf',
            'text/plain',
        ], true) || in_array($extension, ['pdf', 'txt'], true);
    }

    protected function resolveFileContext(string $path): array
    {
        $activity = IdpActivity::with('talent')
            ->where('document_path', $path)
            ->orWhere('document_path', 'like', '%' . $path . '%')
            ->get()
            ->first(function (IdpActivity $item) use ($path) {
                return $this->pathBelongsToDocumentField($item->document_path, $path);
            });

        if ($activity) {
            return [
                'original_name' => $this->resolveActivityOriginalName($activity, $path),
                'display_name' => $this->resolveActivityOriginalName($activity, $path),
                'talent_name' => $activity->talent?->nama,
            ];
        }

        $project = ImprovementProject::with('talent')
            ->where('document_path', $path)
            ->first();

        if ($project) {
            return [
                'original_name' => $project->title ?: basename($path),
                'display_name' => $project->title ?: basename($path),
                'talent_name' => $project->talent?->nama,
            ];
        }

        return [
            'original_name' => basename($path),
            'display_name' => basename($path),
            'talent_name' => null,
        ];
    }

    protected function resolveActivityOriginalName(IdpActivity $activity, string $path): string
    {
        if (! str_starts_with((string) $activity->document_path, '["')) {
            return $activity->file_name ?: basename($path);
        }

        $paths = json_decode($activity->document_path, true);
        $names = array_map('trim', explode(',', (string) $activity->file_name));

        if (! is_array($paths)) {
            return basename($path);
        }

        $index = array_search($path, $paths, true);

        if ($index === false) {
            return basename($path);
        }

        return Arr::get($names, $index, basename($path));
    }

    protected function pathBelongsToDocumentField(?string $documentPath, string $path): bool
    {
        if (! $documentPath) {
            return false;
        }

        if ($documentPath === $path) {
            return true;
        }

        if (! str_starts_with($documentPath, '["')) {
            return false;
        }

        $paths = json_decode($documentPath, true);

        return is_array($paths) && in_array($path, $paths, true);
    }

    protected function buildDownloadFilename(string $originalName, string $talentName, string $extension): string
    {
        $baseOriginalName = pathinfo($originalName, PATHINFO_FILENAME);
        $safeOriginalName = $this->sanitizeFilenameSegment($baseOriginalName !== '' ? $baseOriginalName : 'File');
        $safeTalentName = $this->sanitizeFilenameSegment($talentName !== '' ? $talentName : 'Talent');
        $timestamp = now()->format('Y-m-d H-i-s');

        return trim($safeOriginalName . ' - ' . $safeTalentName . ' - ' . $timestamp . '.' . $extension);
    }

    protected function sanitizeFilenameSegment(string $value): string
    {
        $sanitized = preg_replace('/[\\\\\\/:*?"<>|]+/', '-', $value) ?? '';
        $sanitized = preg_replace('/\s+/', ' ', $sanitized) ?? '';

        return trim($sanitized, " .-\t\n\r\0\x0B");
    }

    protected function noCacheHeaders(): array
    {
        return [
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ];
    }

    protected function missingFileResponse(): RedirectResponse
    {
        return redirect()
            ->back()
            ->with('error', 'File tidak ditemukan atau sudah tidak tersedia di server.');
    }
}
