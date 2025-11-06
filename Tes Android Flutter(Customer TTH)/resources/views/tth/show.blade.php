@extends('layouts.app')

@section('title', 'Detail TTH')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-file-invoice me-2"></i>Detail TTH
                </h2>
                <a href="{{ route('tth.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Informasi TTH
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">No. TTH</small>
                        <h5 class="mb-0"><strong>{{ $tth->TTHNo }}</strong></h5>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted">No. TTOTTP</small>
                        <h6 class="mb-0">{{ $tth->TTOTTPNo }}</h6>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted">Sales ID</small>
                        <h6 class="mb-0">{{ $tth->SalesID }}</h6>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-calendar me-1"></i>Tanggal Dokumen</small>
                        <h6 class="mb-0">{{ $tth->formatted_doc_date }}</h6>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-gift me-1"></i>Total Hadiah</small>
                        <h4 class="mb-0">
                            <span class="badge bg-primary">{{ $tth->details->count() }} item</span>
                        </h4>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <small class="text-muted"><i class="fas fa-check-circle me-1"></i>Status</small>
                        <div class="mt-2">
                            @if($tth->Received == 1)
                                <span class="badge bg-success p-2">
                                    <i class="fas fa-check-circle"></i> Diterima
                                </span>
                                <small class="d-block mt-2 text-muted">
                                    {{ $tth->formatted_received_date }}
                                </small>
                            @else
                                <span class="badge bg-warning text-dark p-2">
                                    <i class="fas fa-clock"></i> Belum Diterima
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="fas fa-store me-2"></i>Informasi Customer
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Customer ID</small>
                        <h6 class="mb-0"><strong>{{ $tth->customer->CustID }}</strong></h6>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-store me-1"></i>Nama Toko</small>
                        <h5 class="mb-0">{{ $tth->customer->Name }}</h5>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>Alamat</small>
                        <p class="mb-0">{{ $tth->customer->Address }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-code-branch me-1"></i>Cabang</small>
                        <div>
                            <span class="badge bg-info">{{ $tth->customer->BranchCode }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <small class="text-muted"><i class="fas fa-phone me-1"></i>No. Telepon</small>
                        <h6 class="mb-0">{{ $tth->customer->PhoneNo }}</h6>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('customers.show', $tth->customer->CustID) }}" 
                       class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-eye me-1"></i>Lihat Detail Customer
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-gifts me-2"></i>Detail Hadiah
                    </span>
                    <button type="button" class="btn btn-sm btn-light" onclick="addNewDetail()">
                        <i class="fas fa-plus me-1"></i>Tambah Hadiah
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="detailsTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="50%">Jenis Hadiah</th>
                                    <th width="15%">Jumlah</th>
                                    <th width="15%">Satuan</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tth->details as $index => $detail)
                                <tr id="detail-row-{{ $detail->ID }}">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="detail-display" id="display-jenis-{{ $detail->ID }}">
                                            @if(stripos($detail->Jenis, 'Emas') !== false || stripos($detail->Jenis, 'Gr') !== false)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-coins"></i> {{ $detail->Jenis }}
                                                </span>
                                            @elseif(stripos($detail->Jenis, 'Voucher') !== false)
                                                <span class="badge bg-info">
                                                    <i class="fas fa-ticket-alt"></i> {{ $detail->Jenis }}
                                                </span>
                                            @else
                                                {{ $detail->Jenis }}
                                            @endif
                                        </span>
                                        <div class="detail-edit" id="edit-jenis-{{ $detail->ID }}" style="display: none;">
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   value="{{ $detail->Jenis }}"
                                                   id="input-jenis-{{ $detail->ID }}">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Emas→Buah | Voucher→Lembar
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="detail-display" id="display-qty-{{ $detail->ID }}">
                                            <strong>{{ $detail->Qty }}</strong>
                                        </span>
                                        <div class="detail-edit" id="edit-qty-{{ $detail->ID }}" style="display: none;">
                                            <input type="number" 
                                                   class="form-control form-control-sm" 
                                                   value="{{ $detail->Qty }}"
                                                   min="1"
                                                   id="input-qty-{{ $detail->ID }}">
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $detail->Unit }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" 
                                                    class="btn btn-warning detail-edit-btn" 
                                                    onclick="editDetail({{ $detail->ID }})"
                                                    id="edit-btn-{{ $detail->ID }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-success detail-save-btn" 
                                                    onclick="saveDetail({{ $detail->ID }})"
                                                    id="save-btn-{{ $detail->ID }}"
                                                    style="display: none;">
                                                <i class="fas fa-save"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-secondary detail-cancel-btn" 
                                                    onclick="cancelEdit({{ $detail->ID }})"
                                                    id="cancel-btn-{{ $detail->ID }}"
                                                    style="display: none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger" 
                                                    onclick="deleteDetail({{ $detail->ID }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <i class="fas fa-tasks me-2"></i>Update Status TTH
                </div>
                <div class="card-body">
                    <form action="{{ route('tth.updateStatus', $tth->TTHNo) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Penerimaan</label>
                                <select name="Received" class="form-select" id="receivedStatus">
                                    <option value="0" {{ $tth->Received == 0 ? 'selected' : '' }}>
                                        Belum Diterima
                                    </option>
                                    <option value="1" {{ $tth->Received == 1 ? 'selected' : '' }}>
                                        Sudah Diterima
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3" id="failedReasonDiv" style="display: {{ $tth->Received == 0 ? 'block' : 'none' }};">
                                <label class="form-label">Alasan Gagal (Opsional)</label>
                                <input type="text" 
                                       name="FailedReason" 
                                       class="form-control" 
                                       value="{{ $tth->FailedReason }}"
                                       placeholder="Masukkan alasan jika belum diterima">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add New Detail -->
<div class="modal fade" id="addDetailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Hadiah Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addDetailForm">
                    <input type="hidden" name="TTHNo" value="{{ $tth->TTHNo }}">
                    <input type="hidden" name="TTOTTPNo" value="{{ $tth->TTOTTPNo }}">
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-tag text-primary me-1"></i>
                            Jenis Hadiah <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control" 
                               name="Jenis" 
                               placeholder="Contoh: Emas 1 Gr atau Voucher 50rb"
                               required>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Emas → unit "Buah" | Voucher → unit "Lembar"
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-sort-numeric-up text-success me-1"></i>
                            Jumlah <span class="text-danger">*</span>
                        </label>
                        <input type="number" 
                               class="form-control" 
                               name="Qty" 
                               min="1" 
                               value="1"
                               required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-primary" onclick="submitNewDetail()">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Show/hide failed reason based on status
document.getElementById('receivedStatus').addEventListener('change', function() {
    const failedReasonDiv = document.getElementById('failedReasonDiv');
    failedReasonDiv.style.display = this.value == '0' ? 'block' : 'none';
});

// Edit detail
function editDetail(id) {
    // Hide display, show edit
    document.querySelectorAll(`#detail-row-${id} .detail-display`).forEach(el => el.style.display = 'none');
    document.querySelectorAll(`#detail-row-${id} .detail-edit`).forEach(el => el.style.display = 'block');
    
    // Toggle buttons
    document.getElementById(`edit-btn-${id}`).style.display = 'none';
    document.getElementById(`save-btn-${id}`).style.display = 'inline-block';
    document.getElementById(`cancel-btn-${id}`).style.display = 'inline-block';
}

// Cancel edit
function cancelEdit(id) {
    // Show display, hide edit
    document.querySelectorAll(`#detail-row-${id} .detail-display`).forEach(el => el.style.display = 'inline');
    document.querySelectorAll(`#detail-row-${id} .detail-edit`).forEach(el => el.style.display = 'none');
    
    // Toggle buttons
    document.getElementById(`edit-btn-${id}`).style.display = 'inline-block';
    document.getElementById(`save-btn-${id}`).style.display = 'none';
    document.getElementById(`cancel-btn-${id}`).style.display = 'none';
}

// Save detail
function saveDetail(id) {
    const jenis = document.getElementById(`input-jenis-${id}`).value;
    const qty = document.getElementById(`input-qty-${id}`).value;
    
    if (!jenis || !qty || qty < 1) {
        alert('Jenis hadiah dan jumlah harus diisi dengan benar!');
        return;
    }
    
    $.ajax({
        url: `/tth/details/${id}`,
        method: 'PUT',
        data: {
            Jenis: jenis,
            Qty: qty
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Gagal mengupdate detail: ' + xhr.responseJSON.message);
        }
    });
}

// Delete detail
function deleteDetail(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus hadiah ini?')) {
        return;
    }
    
    $.ajax({
        url: `/tth/details/${id}`,
        method: 'DELETE',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Gagal menghapus detail: ' + xhr.responseJSON.message);
        }
    });
}

// Add new detail
function addNewDetail() {
    const modal = new bootstrap.Modal(document.getElementById('addDetailModal'));
    modal.show();
}

// Submit new detail
function submitNewDetail() {
    const form = document.getElementById('addDetailForm');
    const formData = new FormData(form);
    
    const data = {};
    formData.forEach((value, key) => data[key] = value);
    
    $.ajax({
        url: '/tth/details',
        method: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            }
        },
        error: function(xhr) {
            alert('Gagal menambahkan detail: ' + xhr.responseJSON.message);
        }
    });
}
</script>
@endpush