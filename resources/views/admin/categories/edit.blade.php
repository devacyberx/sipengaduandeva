@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-pencil-square me-2"></i>Edit Kategori
        </h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">Form Edit Kategori</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" 
                                   placeholder="Contoh: Kursi & Meja" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="color" class="form-label">Warna <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" 
                                       id="color" name="color" value="{{ old('color', $category->color) }}"
                                       title="Pilih warna">
                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                       value="{{ old('color', $category->color) }}" 
                                       id="colorHex" placeholder="#0d6efd" maxlength="7">
                            </div>
                            @error('color')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Warna akan digunakan untuk label kategori</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Deskripsi singkat kategori...">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Update Kategori
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">Preview Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="preview-category mb-3">
                            <span class="badge px-4 py-3 fs-5" id="previewBadge">
                                {{ $category->name }}
                            </span>
                        </div>
                        <p class="text-muted" id="previewDescription">
                            {{ $category->description ?? 'Deskripsi kategori akan muncul di sini' }}
                        </p>
                    </div>

                    <!-- Category Statistics -->
                    <div class="card border mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Statistik Kategori</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="display-6 text-primary">{{ $category->complaints->count() }}</div>
                                    <small class="text-muted">Total Pengaduan</small>
                                </div>
                                <div class="col-4">
                                    <div class="display-6 text-success">
                                        {{ $category->complaints->where('status', 'selesai')->count() }}
                                    </div>
                                    <small class="text-muted">Selesai</small>
                                </div>
                                <div class="col-4">
                                    <div class="display-6 text-warning">
                                        {{ $category->complaints->where('status', 'menunggu')->count() }}
                                    </div>
                                    <small class="text-muted">Menunggu</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Complaints -->
                    @if($category->complaints->count() > 0)
                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Pengaduan Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @foreach($category->complaints()->latest()->take(3)->get() as $complaint)
                                <a href="{{ route('admin.complaints.show', $complaint) }}" 
                                   class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ Str::limit($complaint->title, 40) }}</h6>
                                        <small>{{ $complaint->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-muted">{{ Str::limit($complaint->description, 60) }}</p>
                                    <small>
                                        <span class="badge bg-{{ $complaint->status_color }}">
                                            {{ $complaint->status_text }}
                                        </span>
                                    </small>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorPicker = document.getElementById('color');
    const colorHex = document.getElementById('colorHex');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const previewBadge = document.getElementById('previewBadge');

    // Update preview when color changes
    colorPicker.addEventListener('input', function() {
        colorHex.value = this.value;
        updatePreview();
    });

    colorHex.addEventListener('input', function() {
        colorPicker.value = this.value;
        updatePreview();
    });

    // Update preview when name or description changes
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);

    function updatePreview() {
        const name = nameInput.value || 'Nama Kategori';
        const color = colorPicker.value || '#0d6efd';
        const description = descriptionInput.value || 'Deskripsi kategori akan muncul di sini';

        // Update preview badge
        previewBadge.textContent = name;
        previewBadge.style.backgroundColor = color;
        previewBadge.style.color = getContrastColor(color);

        // Update description
        document.getElementById('previewDescription').textContent = 
            description || 'Deskripsi kategori akan muncul di sini';
    }

    // Function to determine contrast color
    function getContrastColor(hexcolor) {
        hexcolor = hexcolor.replace('#', '');
        const r = parseInt(hexcolor.substr(0, 2), 16);
        const g = parseInt(hexcolor.substr(2, 2), 16);
        const b = parseInt(hexcolor.substr(4, 2), 16);
        const yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
        return (yiq >= 128) ? '#000000' : '#ffffff';
    }

    // Initial preview
    updatePreview();
});
</script>
@endsection