@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-white mb-0">
                    <i class="fas fa-user me-2"></i>Detail Customer
                </h2>
                <a href="{{ route('customers.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>Informasi Customer
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Customer ID</small>
                        <h5 class="mb-0"><strong>{{ $customer->CustID }}</strong></h5>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-store me-1"></i>Nama Toko</small>
                        <h5 class="mb-0">{{ $customer->Name }}</h5>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>Alamat</small>
                        <p class="mb-0">{{ $customer->Address }}</p>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-code-branch me-1"></i>Cabang</small>
                        <div>
                            <span class="badge bg-info">{{ $customer->BranchCode }}</span>
                            @if($customer->branch)
                                <small class="d-block mt-1">{{ $customer->branch->Name }}</small>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted"><i class="fas fa-phone me-1"></i>No. Telepon</small>
                        <h6 class="mb-0">{{ $customer->PhoneNo }}</h6>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <small class="text-muted"><i class="fas fa-file-invoice me-1"></i>Total TTH</small>
                        <h4 class="mb-0">
                            <span class="badge bg-primary">{{ $customer->tths->count() }} TTH</span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-gift me-2"></i>Daftar TTH
                    </span>
                    <span class="badge bg-light text-dark">
                        {{ $customer->tths->count() }} TTH
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">No. TTH</th>
                                    <th width="20%">Tanggal</th>
                                    <th width="15%">Jumlah Hadiah</th>
                                    <th width="20%">Status</th>
                                    <th width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->tths as $index => $tth)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $tth->TTHNo }}</strong></td>
                                    <td>
                                        <i class="fas fa-calendar text-primary me-1"></i>
                                        {{ $tth->formatted_doc_date }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $tth->details->count() }} item
                                        </span>
                                    </td>
                                    <td>
                                        @if($tth->Received == 1)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle"></i> Diterima
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('tth.show', $tth->TTHNo) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2 d-block"></i>
                                        <p class="text-muted mb-0">Belum ada data TTH</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection