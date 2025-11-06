@extends('layouts.app')

@section('title', 'Daftar TTH')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-gift me-2"></i>Daftar TTH (Tanda Terima Hadiah)
                </h2>
                <a href="{{ route('tth.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah TTH
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-filter me-2"></i>Filter & Pencarian
                </div>
                <div class="card-body">
                    <form action="{{ route('tth.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari No. TTH, Customer ID, Nama Toko..." 
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Diterima</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_from" class="form-control" 
                                       placeholder="Dari Tanggal" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="date" name="date_to" class="form-control" 
                                       placeholder="Sampai Tanggal" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-list me-2"></i>Data TTH
                    </span>
                    <span class="badge bg-light text-dark">
                        Total: {{ $tths->total() }} TTH
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">No. TTH</th>
                                    <th width="20%">Customer</th>
                                    <th width="12%">Tanggal</th>
                                    <th width="10%">Jumlah Item</th>
                                    <th width="15%">Status</th>
                                    <th width="13%">Tgl Diterima</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tths as $index => $tth)
                                <tr>
                                    <td>{{ $tths->firstItem() + $index }}</td>
                                    <td><strong>{{ $tth->TTHNo }}</strong></td>
                                    <td>
                                        <div>
                                            <i class="fas fa-store text-primary me-1"></i>
                                            <strong>{{ $tth->customer->Name ?? 'N/A' }}</strong>
                                        </div>
                                        <small class="text-muted">{{ $tth->CustID }}</small>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar text-info me-1"></i>
                                        {{ $tth->formatted_doc_date }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-gift me-1"></i>
                                            {{ $tth->details->count() }} item
                                        </span>
                                    </td>
                                    <td>
                                        @if($tth->Received == 1)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Diterima
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $tth->formatted_received_date }}</small>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('tth.show', $tth->TTHNo) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="deleteTTH('{{ $tth->TTHNo }}')"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                        <h5 class="text-muted">Tidak ada data TTH</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($tths->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $tths->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteTTH(tthNo) {
    if (confirm(`Apakah Anda yakin ingin menghapus TTH "${tthNo}"?\n\nSemua detail TTH juga akan dihapus!`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/tth/${tthNo}`;
        form.submit();
    }
}
</script>
@endpush