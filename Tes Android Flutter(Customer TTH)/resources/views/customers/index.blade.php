@extends('layouts.app')

@section('title', 'Daftar Customer')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-users me-2"></i>Daftar Customer
                </h2>
                <a href="{{ route('customers.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Customer
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
                    <form action="{{ route('customers.index') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <div class="search-box">
                                    <i class="fas fa-search"></i>
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari customer (ID, Nama, Alamat, No. Telepon)..." 
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select name="branch" class="form-select">
                                    <option value="">Semua Cabang</option>
                                    @foreach($branches as $branch)
                                        <option value="{{ $branch->BranchCode }}" 
                                                {{ request('branch') == $branch->BranchCode ? 'selected' : '' }}>
                                            {{ $branch->BranchCode }} - {{ $branch->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
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
                        <i class="fas fa-list me-2"></i>Data Customer
                    </span>
                    <span class="badge bg-light text-dark">
                        Total: {{ $customers->total() }} customer
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">Customer ID</th>
                                    <th width="18%">Nama Toko</th>
                                    <th width="25%">Alamat</th>
                                    <th width="12%">Cabang</th>
                                    <th width="13%">No. Telepon</th>
                                    <th width="8%">TTH</th>
                                    <th width="7%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $index => $customer)
                                <tr>
                                    <td>{{ $customers->firstItem() + $index }}</td>
                                    <td><strong>{{ $customer->CustID }}</strong></td>
                                    <td>
                                        <i class="fas fa-store text-primary me-1"></i>
                                        {{ $customer->Name }}
                                    </td>
                                    <td>
                                        <small>{{ Str::limit($customer->Address, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $customer->BranchCode }}
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-phone text-success me-1"></i>
                                        {{ $customer->PhoneNo }}
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $customer->tths->count() }} TTH
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('customers.show', $customer->CustID) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="deleteCustomer('{{ $customer->CustID }}', '{{ $customer->Name }}')"
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
                                        <h5 class="text-muted">Tidak ada data customer</h5>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($customers->hasPages())
                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        {{ $customers->links() }}
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
function deleteCustomer(custId, name) {
    if (confirm(`Apakah Anda yakin ingin menghapus customer "${name}"?\n\nPeringatan: Customer yang memiliki data TTH tidak dapat dihapus!`)) {
        const form = document.getElementById('deleteForm');
        form.action = `/customers/${custId}`;
        form.submit();
    }
}
</script>
@endpush