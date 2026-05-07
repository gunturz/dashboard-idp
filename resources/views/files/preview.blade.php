<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $filename }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="max-w-6xl mx-auto px-6 py-10">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Preview File</p>
                    <h1 class="text-xl font-bold text-slate-900 mt-2 break-all">{{ $filename }}</h1>
                    <p class="text-sm text-slate-500 mt-2">
                        File {{ strtoupper($extension) }}.
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex flex-wrap gap-3">
                    <a href="{{ $downloadUrl }}"
                        class="inline-flex items-center rounded-xl bg-teal-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-700 transition">
                        Download File
                    </a>
                </div>

                @if (str_starts_with($mimeType, 'image/'))
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <img src="{{ $fileUrl }}" alt="{{ $filename }}" class="w-full h-auto max-h-[75vh] object-contain mx-auto">
                    </div>
                @elseif ($mimeType === 'application/pdf' || $extension === 'pdf')
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <iframe src="{{ $fileUrl }}" class="w-full h-[75vh]" title="{{ $filename }}"></iframe>
                    </div>
                @elseif ($mimeType === 'text/plain' || $extension === 'txt')
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <iframe src="{{ $fileUrl }}" class="w-full h-[75vh]" title="{{ $filename }}"></iframe>
                    </div>
                @else
                    <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                        File ini tidak bisa dipreview langsung. Silakan gunakan tombol download.
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
