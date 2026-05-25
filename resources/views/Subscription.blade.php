@extends('layouts.master')

@section('title', 'Subscriptions - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Subscriptions</h1>
        <p>Kelola semua subscription pelanggan.</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-dark" onclick="openModal('modal-add-subscription')">
            + Tambah Subscription
        </button>
    </div>
</div>

<div class="table-section">
    <table>
        <thead>
            <tr>
                <th>CUSTOMER</th>
                <th>SERVICE</th>
                <th>TANGGAL MULAI</th>
                <th>TANGGAL AKHIR</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subscriptions as $subscription)
                <tr>
                    <td><strong>{{ $subscription->customer->name }}</strong></td>
                    <td>{{ $subscription->service->name }}</td>
                    <td>{{ $subscription->start_date?->format('d M Y') ?? '-' }}</td>
                    <td>{{ $subscription->end_date?->format('d M Y') ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $subscription->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($subscription->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('subscriptions.show', $subscription->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                        Belum ada data subscriptions
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($subscriptions->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $subscriptions->links() }}
    </div>
@endif

<!-- Modal Add Subscription -->
<div class="modal-overlay" id="modal-add-subscription">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Subscription Baru</h2>
            <button class="btn-close" onclick="closeModal('modal-add-subscription')">&times;</button>
        </div>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label>Customer</label>
                <select class="form-control" name="customer_id" required>
                    <option value="">-- Pilih Customer --</option>
                </select>
            </div>
            <div class="form-group">
                <label>Service</label>
                <select class="form-control" name="service_id" required>
                    <option value="">-- Pilih Service --</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" class="form-control" name="start_date" required>
            </div>
            <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" class="form-control" name="end_date">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-dark" style="width: 100%; justify-content: center;">Simpan</button>
        </form>
    </div>
</div>
@endsection