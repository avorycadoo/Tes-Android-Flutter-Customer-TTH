<!-- resources/views/customers/create.blade.php -->
@extends('layouts.app')

@section('title', 'Tambah Customer & TTH Baru')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-user-plus me-2"></i>Tambah Customer & TTH
                </h2>
                <a href="{{ route('customers.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('customers.store') }}" method="POST" id="customerForm">
        @csrf

        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- CUSTOMER CARD -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user me-2"></i>Informasi Customer
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">CustID <span class="text-danger">*</span></label>
                                <input type="text" name="CustID" class="form-control @error('CustID') is-invalid @enderror" value="{{ old('CustID') }}" required>
                                @error('CustID')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nama Customer <span class="text-danger">*</span></label>
                                <input type="text" name="Name" class="form-control @error('Name') is-invalid @enderror" value="{{ old('Name') }}" required>
                                @error('Name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Branch Code <span class="text-danger">*</span></label>
                                <select name="BranchCode" class="form-select @error('BranchCode') is-invalid @enderror" required>
                                    <option value="">-- Pilih Branch --</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->BranchCode }}" {{ old('BranchCode') == $branch->BranchCode ? 'selected' : '' }}>
                                            {{ $branch->BranchCode }} - {{ $branch->Name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('BranchCode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <input type="text" name="Address" class="form-control @error('Address') is-invalid @enderror" value="{{ old('Address') }}" required>
                                @error('Address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="PhoneNo" class="form-control @error('PhoneNo') is-invalid @enderror" value="{{ old('PhoneNo') }}" required>
                                @error('PhoneNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TTH CARD -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-gift me-2"></i>TTH Pertama Customer</span>
                        <button type="button" class="btn btn-sm btn-light" onclick="addDetailRow()">
                            <i class="fas fa-plus me-1"></i>Tambah Item Hadiah
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. TTH <span class="text-danger">*</span></label>
                                <input type="text" name="TTHNo" class="form-control @error('TTHNo') is-invalid @enderror" value="{{ old('TTHNo') }}" required>
                                @error('TTHNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. TTOTTP <span class="text-danger">*</span></label>
                                <input type="text" name="TTOTTPNo" class="form-control @error('TTOTTPNo') is-invalid @enderror" value="{{ old('TTOTTPNo') }}" required>
                                @error('TTOTTPNo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sales ID <span class="text-danger">*</span></label>
                                <input type="text" name="SalesID" class="form-control @error('SalesID') is-invalid @enderror" value="{{ old('SalesID') }}" required>
                                @error('SalesID')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Dokumen <span class="text-danger">*</span></label>
                                <input type="date" name="DocDate" class="form-control @error('DocDate') is-invalid @enderror" value="{{ old('DocDate', date('Y-m-d')) }}" required>
                                @error('DocDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3"><i class="fas fa-box me-2"></i>Detail Hadiah</h5>

                        <div id="detailsContainer">
                            <div class="detail-row p-3 mb-3 border rounded position-relative">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="removeDetailRow(this)" style="display:none;">
                                    <i class="fas fa-times"></i>
                                </button>

                                <div class="row">
                                    <div class="col-md-8 mb-2">
                                        <label class="form-label">Jenis Hadiah <span class="text-danger">*</span></label>
                                        <input type="text" name="details[0][Jenis]" class="form-control" required>
                                        <small class="text-muted">Emas = Buah, Voucher = Lembar</small>
                                    </div>

                                    <div class="col-md-4 mb-2">
                                        <label class="form-label">Qty <span class="text-danger">*</span></label>
                                        <input type="number" name="details[0][Qty]" class="form-control" min="1" value="1" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Customer & TTH
                        </button>
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
    const row = document.createElement('div');
    row.className = 'detail-row p-3 mb-3 border rounded position-relative';

    row.innerHTML = `
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="removeDetailRow(this)">
            <i class="fas fa-times"></i>
        </button>
        <div class="row">
            <div class="col-md-8 mb-2">
                <label class="form-label">Jenis Hadiah <span class="text-danger">*</span></label>
                <input type="text" name="details[${detailIndex}][Jenis]" class="form-control" required>
            </div>
            <div class="col-md-4 mb-2">
                <label class="form-label">Qty <span class="text-danger">*</span></label>
                <input type="number" name="details[${detailIndex}][Qty]" class="form-control" min="1" value="1" required>
            </div>
        </div>
    `;

    container.appendChild(row);
    detailIndex++;

    updateRemoveButtons();
}

function removeDetailRow(btn) {
    btn.closest('.detail-row').remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.detail-row');
    rows.forEach(row => {
        const btn = row.querySelector('.btn-danger');
        btn.style.display = rows.length > 1 ? 'block' : 'none';
    });
}

document.addEventListener('DOMContentLoaded', updateRemoveButtons);
</script>
@endpush
