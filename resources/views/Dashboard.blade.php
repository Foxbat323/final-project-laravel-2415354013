@extends('layouts.master')

@section('title', 'Dashboard - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Dashboard Overview</h1>
        <p>Monitoring performa ERP Anda secara real-time.</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-outline">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Laporan
        </button>
        <button class="btn btn-dark" onclick="openModal('modal-add')">
            + Data Baru
        </button>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">TOTAL CUSTOMERS</div>
        <div class="stat-value">{{ number_format($totalCustomers) }}</div>
        <div class="stat-trend">
            <span class="trend-badge {{ $customerChange >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $customerChange >= 0 ? '↑' : '↓' }} {{ abs($customerChange) }}%
            </span>
            vs bulan lalu
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-title">LAYANAN AKTIF</div>
        <div class="stat-value">{{ number_format($activeServices) }}</div>
        <div class="stat-trend">
            <span class="trend-badge {{ $serviceChange >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $serviceChange >= 0 ? '↑' : '↓' }} {{ abs($serviceChange) }}%
            </span>
            vs bulan lalu
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-title">SUBSCRIPTIONS</div>
        <div class="stat-value">{{ number_format($totalSubscriptions) }}</div>
        <div class="stat-trend">
            <span class="trend-badge {{ $subscriptionChange >= 0 ? 'trend-up' : 'trend-down' }}">
                {{ $subscriptionChange >= 0 ? '↑' : '↓' }} {{ abs($subscriptionChange) }}%
            </span>
            vs bulan lalu
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-title">UNPAID INVOICES</div>
        <div class="stat-value">{{ number_format($unpaidInvoices) }}</div>
        <div class="stat-trend"><span class="trend-badge trend-down">Perlu cek</span> vs bulan lalu</div>
    </div>
</div>

<div class="table-section">
    <div class="table-header">
        <h2>Tagihan Terbaru</h2>
        <a href="{{ route('subscriptions.index') }}">LIHAT SEMUA ></a>
    </div>
    <table>
        <thead>
            <tr>
                <th>CUSTOMER</th>
                <th>SERVICE</th>
                <th>STATUS</th>
                <th>TANGGAL MULAI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentSubscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->customer->name }}</td>
                    <td>{{ $subscription->service->name }}</td>
                    <td>
                        <span class="badge badge-{{ $subscription->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($subscription->status) }}
                        </span>
                    </td>
                    <td>{{ $subscription->start_date->format('d M Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px; color: #999;">
                        Belum ada subscription
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="modal-overlay" id="modal-add">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Data Cepat</h2>
            <button class="btn-close" onclick="closeModal('modal-add')">&times;</button>
        </div>
        <form action="#">
            <div class="form-group">
                <label>Pilih Tipe Data</label>
                <select class="form-control">
                    <option>Customer Baru</option>
                    <option>Invoice Baru</option>
                </select>
            </div>
            <button type="submit" class="btn btn-dark" style="width: 100%; justify-content: center; margin-top: 10px;">Simpan</button>
        </form>
    </div>
</div>
@endsection