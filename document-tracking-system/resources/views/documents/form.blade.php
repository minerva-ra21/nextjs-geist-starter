@extends('layouts.app')

@section('title', ($isEdit ? 'Edit' : 'Tambah') . ' Dokumen - Document Tracking System')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4">
            <a href="{{ route('documents.index') }}" 
               class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mt-4">
            {{ $isEdit ? 'Edit Dokumen' : 'Tambah Dokumen Baru' }}
        </h1>
        <p class="text-gray-600 mt-2">
            {{ $isEdit ? 'Perbarui informasi dokumen' : 'Masukkan informasi dokumen baru' }}
        </p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form method="POST" action="{{ $isEdit ? route('documents.update', $document) : route('documents.store') }}" class="p-6 space-y-6">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Registration Number -->
            <div>
                <label for="registration_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Registrasi <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="registration_number" 
                       name="registration_number" 
                       value="{{ old('registration_number', $document->registration_number) }}"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('registration_number') border-red-300 @enderror"
                       placeholder="Masukkan nomor registrasi dokumen"
                       required>
                @error('registration_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Dokumen <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title', $document->title) }}"
                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-300 @enderror"
                       placeholder="Masukkan judul dokumen"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-300 @enderror"
                          placeholder="Masukkan deskripsi dokumen (opsional)">{{ old('description', $document->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror"
                        required>
                    <option value="">Pilih status dokumen</option>
                    @php
                        $statuses = [
                            'Masuk' => 'Masuk',
                            'Proses' => 'Sedang Proses',
                            'Selesai' => 'Selesai',
                            'Ditolak' => 'Ditolak'
                        ];
                        $selectedStatus = old('status', $document->status);
                    @endphp
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ $selectedStatus == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('documents.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </a>

                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                        onclick="addLoadingState(this)">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ $isEdit ? 'Perbarui Dokumen' : 'Simpan Dokumen' }}
                </button>
            </div>
        </form>
    </div>

    <!-- Additional Information -->
    @if($isEdit)
        <div class="mt-6 bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-900 mb-2">Informasi Dokumen</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Dibuat:</span> 
                    {{ $document->created_at->format('d F Y, H:i') }}
                </div>
                <div>
                    <span class="font-medium">Terakhir diperbarui:</span> 
                    {{ $document->updated_at->format('d F Y, H:i') }}
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    // Auto-generate registration number if creating new document
    @if(!$isEdit)
        document.addEventListener('DOMContentLoaded', function() {
            const regNumberInput = document.getElementById('registration_number');
            if (!regNumberInput.value) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const time = String(now.getHours()).padStart(2, '0') + String(now.getMinutes()).padStart(2, '0');
                const regNumber = `DOC-${year}${month}${day}-${time}`;
                regNumberInput.value = regNumber;
            }
        });
    @endif

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const requiredFields = ['registration_number', 'title', 'status'];
        let hasError = false;

        requiredFields.forEach(function(fieldName) {
            const field = document.getElementById(fieldName);
            if (!field.value.trim()) {
                hasError = true;
                field.classList.add('border-red-300');
            } else {
                field.classList.remove('border-red-300');
            }
        });

        if (hasError) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
</script>
@endsection
