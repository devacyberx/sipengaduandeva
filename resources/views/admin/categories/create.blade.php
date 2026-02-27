@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-tag me-2"></i>Tambah Kategori Baru
        </h2>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">Form Tambah Kategori</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Contoh: Kursi & Meja" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="color" class="form-label">Warna <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="color" class="form-control form-control-color" 
                                       id="color" name="color" value="{{ old('color', '#0d6efd') }}"
                                       title="Pilih warna">
                                <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                       value="{{ old('color', '#0d6efd') }}" 
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
                                      placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Simpan Kategori
                            </button>
                            <button type="reset" class="btn btn-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Form
                            </button>
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
                                Nama Kategori
                            </span>
                        </div>
                        <p class="text-muted" id="previewDescription">Deskripsi kategori akan muncul di sini</p>
                    </div>

                    <div class="card border">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Contoh Penggunaan</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Judul Pengaduan</th>
                                            <th>Kategori</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Kursi Rusak di Lab Komputer</td>
                                            <td>
                                                <span class="badge" id="exampleBadge">
                                                    Nama Kategori
                                                </span>
                                            </td>
                                            <td><span class="badge bg-warning">Menunggu</span></td>
                                        </tr>
                                        <tr>
                                            <td>Proyektor Tidak Menyala</td>
                                            <td>
                                                <span class="badge" id="exampleBadge2">
                                                    Nama Kategori
                                                </span>
                                            </td>
                                            <td><span class="badge bg-primary">Diproses</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Tips:</strong> Pilih warna yang kontras untuk memudahkan identifikasi kategori.
                    </div>
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
    const previewDescription = document.getElementById('previewDescription');
    const exampleBadges = document.querySelectorAll('#exampleBadge, #exampleBadge2');

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
        
        // Update example badges
        exampleBadges.forEach(badge => {
            badge.textContent = name;
            badge.style.backgroundColor = color;
            badge.style.color = getContrastColor(color);
        });

        // Update description
        previewDescription.textContent = description || 'Deskripsi kategori akan muncul di sini';
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

<style>
.form-control-color {
    height: 38px;
    width: 70px;
}

.preview-category {
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#previewBadge {
    transition: all 0.3s ease;
    font-size: 1.1rem;
}
</style>
@endsection