@extends('layouts.app')

@section('title', 'Tambah TTH')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-plus-circle me-2"></i>Tambah TTH Baru
                </h2>
                <a href="{{ route('tth.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('tth.store') }}" method="POST" id="tthForm">
        @csrf
        
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-file-alt me-2"></i>Informasi TTH
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="TTHNo" class="form-label">
                                    <i class="fas fa-hashtag text-primary me-1"></i>
                                    No. TTH <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('TTHNo') is-invalid @enderror" 
                                       id="TTHNo" 
                                       name="TTHNo" 
                                       value="{{ old('TTHNo') }}"
                                       placeholder="Contoh: TTH-00A-2306-50137" 
                                       required>
                                @error('TTHNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="TTOTTPNo" class="form-label">
                                    <i class="fas fa-file-invoice text-info me-1"></i>
                                    No. TTOTTP <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('TTOTTPNo') is-invalid @enderror" 
                                       id="TTOTTPNo" 
                                       name="TTOTTPNo" 
                                       value="{{ old('TTOTTPNo') }}"
                                       placeholder="Contoh: TTOL-00A-2306-90079" 
                                       required>
                                @error('TTOTTPNo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="CustID" class="form-label">
                                    <i class="fas fa-user text-success me-1"></i>
                                    Customer <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('CustID') is-invalid @enderror" 
                                        id="CustID" 
                                        name="CustID" 
                                        required>
                                    <option value="">-- Pilih Customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->CustID }}" 
                                                {{ old('CustID') == $customer->CustID ? 'selected' : '' }}>
                                            {{ $customer->CustID }} - {{ $customer->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('CustID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="SalesID" class="form-label">
                                    <i class="fas fa-user-tie text-warning me-1"></i>
                                    Sales ID <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('SalesID') is-invalid @enderror" 
                                       id="SalesID" 
                                       name="SalesID" 
                                       value="{{ old('SalesID') }}"
                                       placeholder="Contoh: 00AC1A0103" 
                                       required>
                                @error('SalesID')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="DocDate" class="form-label">
                                    <i class="fas fa-calendar text-danger me-1"></i>
                                    Tanggal Dokumen <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('DocDate') is-invalid @enderror" 
                                       id="DocDate" 
                                       name="DocDate" 
                                       value="{{ old('DocDate', date('Y-m-d')) }}"
                                       required>
                                @error('DocDate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-gifts me-2"></i>Detail Hadiah
                        </span>
                        <button type="button" class="btn btn-sm btn-light" onclick="addDetailRow()">
                            <i class="fas fa-plus me-1"></i>Tambah Item
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="detailsContainer">
                            <div class="detail-row mb-3 p-3 border rounded position-relative">
                                <button type="button" 
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                                        onclick="removeDetailRow(this)"
                                        style="display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                                
                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <label class="form-label">
                                            <i class="fas fa-tag text-primary me-1"></i>
                                            Jenis Hadiah <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               name="details[0][Jenis]" 
                                               placeholder="Contoh: Emas 0.5 Gr atau Voucher 100rb"
                                               required>
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i> 
                                            Untuk Emas: unit otomatis "Buah" | Untuk Voucher: unit otomatis "Lembar"
                                        </small>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">
                                            <i class="fas fa-sort-numeric-up text-success me-1"></i>
                                            Jumlah <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               name="details[0][Qty]" 
                                               min="1" 
                                               value="1"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @error('details')
                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-lightbulb text-warning me-1"></i>
                                Minimal 1 item hadiah harus diisi
                            </small>
                            <div class="d-flex gap-2">
                                <a href="{{ route('tth.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan TTH
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let detailIndex = 1;

function addDetailRow() {
    const container = document.getElementById('detailsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'detail-row mb-3 p-3 border rounded position-relative';
    newRow.innerHTML = `
        <button type="button" 
                class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" 
                onclick="removeDetailRow(this)">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="row">
            <div class="col-md-8 mb-2">
                <label class="form-label">
                    <i class="fas fa-tag text-primary me-1"></i>
                    Jenis Hadiah <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       class="form-control" 
                       name="details[${detailIndex}][Jenis]" 
                       placeholder="Contoh: Emas 0.5 Gr atau Voucher 100rb"
                       required>
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Untuk Emas: unit otomatis "Buah" | Untuk Voucher: unit otomatis "Lembar"
                </small>
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">
                    <i class="fas fa-sort-numeric-up text-success me-1"></i>
                    Jumlah <span class="text-danger">*</span>
                </label>
                <input type="number" 
                       class="form-control" 
                       name="details[${detailIndex}][Qty]" 
                       min="1" 
                       value="1"
                       required>
            </div>
        </div>
    `;
    
    container.appendChild(newRow);
    detailIndex++;
    
    updateRemoveButtons();
}

function removeDetailRow(button) {
    const row = button.closest('.detail-row');
    row.remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.detail-row');
    rows.forEach((row, index) => {
        const removeBtn = row.querySelector('button[onclick*="removeDetailRow"]');
        if (removeBtn) {
            removeBtn.style.display = rows.length > 1 ? 'block' : 'none';
        }
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRemoveButtons();
});
</script>
@endpush