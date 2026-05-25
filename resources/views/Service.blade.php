@extends('layouts.master')

@section('title', 'Services - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Services</h1>
        <p>Kelola semua layanan yang tersedia.</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-dark" onclick="openModal('modal-add-service')">
            + Tambah Service
        </button>
    </div>
</div>

<div class="table-section">
    <table>
        <thead>
            <tr>
                <th>NAMA SERVICE</th>
                <th>HARGA</th>
                <th>DESCRIPTION</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                    <td>{{ Str::limit($service->description, 50) ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $service->status ? 'badge-active' : 'badge-inactive' }}">
                            {{ $service->status ? 'AKTIF' : 'INACTIVE' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px; color: #999;">
                        Belum ada data services
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($services->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $services->links() }}
    </div>
@endif

<!-- Modal Add Service -->
<div class="modal-overlay" id="modal-add-service">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Service Baru</h2>
            <button class="btn-close" onclick="closeModal('modal-add-service')">&times;</button>
        </div>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Service</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" class="form-control" name="price" required min="0">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="status" value="1" checked>
                    Aktif
                </label>
            </div>
            <button type="submit" class="btn btn-dark" style="width: 100%; justify-content: center;">Simpan</button>
        </form>
    </div>
</div>
@endsection