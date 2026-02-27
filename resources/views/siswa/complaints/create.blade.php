@extends('layouts.app')

@section('title', 'Buat Pengaduan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0">
            <i class="bi bi-plus-circle me-2"></i>Buat Pengaduan Baru
        </h2>
        <a href="{{ route('siswa.complaints.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header card-header-custom">
                    <h5 class="mb-0">Form Pengaduan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.complaints.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <div class="form-stepper">
                                <div class="stepper-step active">
                                    <div class="stepper-circle">1</div>
                                    <div class="stepper-label">Informasi Dasar</div>
                                </div>
                                <div class="stepper-line"></div>
                                <div class="stepper-step">
                                    <div class="stepper-circle">2</div>
                                    <div class="stepper-label">Detail Pengaduan</div>
                                </div>
                                <div class="stepper-line"></div>
                                <div class="stepper-step">
                                    <div class="stepper-circle">3</div>
                                    <div class="stepper-label">Lampiran</div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 1: Basic Information -->
                        <div class="step-content active" id="step1">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" 
                                       placeholder="Contoh: Kursi Rusak di Ruang Lab Komputer" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Judul yang jelas membantu petugas memahami masalah</small>
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Lokasi</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location') }}" 
                                       placeholder="Contoh: Ruang Lab Komputer, Lantai 2">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" onclick="nextStep(2)">
                                    Selanjutnya <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Detail Information -->
                        <div class="step-content" id="step2" style="display: none;">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="6" 
                                          placeholder="Jelaskan secara detail masalah yang ditemukan..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Jelaskan secara rinci: apa yang rusak, kapan ditemukan, dampaknya, dll.
                                </small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(1)">
                                    <i class="bi bi-arrow-left me-1"></i>Sebelumnya
                                </button>
                                <button type="button" class="btn btn-primary" onclick="nextStep(3)">
                                    Selanjutnya <i class="bi bi-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Attachment -->
                        <div class="step-content" id="step3" style="display: none;">
                            <div class="mb-4">
                                <label for="photo" class="form-label">Foto Bukti</label>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                       id="photo" name="photo" accept="image/*">
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Unggah foto kerusakan (maks. 2MB, format: jpg, png, jpeg, gif)
                                </small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Preview Foto</label>
                                <div class="border rounded p-3 text-center" id="photoPreview" 
                                     style="min-height: 150px; display: none;">
                                    <img id="previewImage" class="img-fluid rounded" 
                                         style="max-height: 200px;">
                                </div>
                                <div class="text-center mt-2" id="noPhotoText">
                                    <i class="bi bi-image text-muted display-4"></i>
                                    <p class="text-muted">Belum ada foto yang dipilih</p>
                                </div>
                            </div>

                            <!-- Tips -->
                            <div class="alert alert-info">
                                <h6><i class="bi bi-lightbulb me-2"></i>Tips Pengaduan yang Baik:</h6>
                                <ul class="mb-0">
                                    <li>Gunakan judul yang jelas dan spesifik</li>
                                    <li>Jelaskan masalah secara detail dan kronologis</li>
                                    <li>Sertakan foto bukti yang jelas dan relevan</li>
                                    <li>Tentukan lokasi dengan tepat</li>
                                    <li>Pilih kategori yang sesuai</li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="prevStep(2)">
                                    <i class="bi bi-arrow-left me-1"></i>Sebelumnya
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-send me-1"></i>Kirim Pengaduan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentStep = 1;

function nextStep(step) {
    // Validate current step
    if (!validateStep(currentStep)) {
        return;
    }
    
    // Hide current step
    document.getElementById(`step${currentStep}`).style.display = 'none';
    document.querySelector(`.stepper-step:nth-child(${currentStep * 2 - 1})`).classList.remove('active');
    
    // Show next step
    document.getElementById(`step${step}`).style.display = 'block';
    document.querySelector(`.stepper-step:nth-child(${step * 2 - 1})`).classList.add('active');
    
    currentStep = step;
}

function prevStep(step) {
    // Hide current step
    document.getElementById(`step${currentStep}`).style.display = 'none';
    document.querySelector(`.stepper-step:nth-child(${currentStep * 2 - 1})`).classList.remove('active');
    
    // Show previous step
    document.getElementById(`step${step}`).style.display = 'block';
    document.querySelector(`.stepper-step:nth-child(${step * 2 - 1})`).classList.add('active');
    
    currentStep = step;
}

function validateStep(step) {
    if (step === 1) {
        const title = document.getElementById('title').value.trim();
        const category = document.getElementById('category_id').value;
        
        if (!title) {
            alert('Judul pengaduan harus diisi');
            return false;
        }
        
        if (!category) {
            alert('Kategori harus dipilih');
            return false;
        }
        
        return true;
    }
    
    if (step === 2) {
        const description = document.getElementById('description').value.trim();
        
        if (!description) {
            alert('Deskripsi pengaduan harus diisi');
            return false;
        }
        
        if (description.length < 20) {
            alert('Deskripsi minimal 20 karakter');
            return false;
        }
        
        return true;
    }
    
    return true;
}

// Photo preview
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('photoPreview');
    const previewImage = document.getElementById('previewImage');
    const noPhotoText = document.getElementById('noPhotoText');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
            noPhotoText.style.display = 'none';
        }
        
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        noPhotoText.style.display = 'block';
    }
});

// Auto resize textarea
document.getElementById('description').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});
</script>

<style>
.form-stepper {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
}

.stepper-step {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.stepper-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    transition: all 0.3s ease;
}

.stepper-step.active .stepper-circle {
    background-color: var(--primary-color);
    color: white;
}

.stepper-label {
    margin-top: 8px;
    font-size: 12px;
    color: #6c757d;
    text-align: center;
}

.stepper-step.active .stepper-label {
    color: var(--primary-color);
    font-weight: bold;
}

.stepper-line {
    width: 100px;
    height: 2px;
    background-color: #e9ecef;
    margin: 0 10px;
}

.step-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

#photoPreview {
    border: 2px dashed #dee2e6;
    background-color: #f8f9fa;
}

#noPhotoText {
    color: #6c757d;
}
</style>
@endsection