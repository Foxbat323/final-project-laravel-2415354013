@extends('layouts.master')

@section('title', 'Service Detail - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $service->name }}</h1>
        <p>Detail informasi layanan.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('services.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- Service Info -->
    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Informasi Layanan</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Nama Service</label>
                <p style="margin: 0; font-weight: 500; font-size: 18px;">{{ $service->name }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Harga</label>
                <p style="margin: 0; font-weight: 600; font-size: 20px; color: #10b981;">Rp {{ number_format($service->price, 0, ',', '.') }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Description</label>
                <p style="margin: 0;">{{ $service->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Status</label>
                <span class="badge {{ $service->status ? 'badge-active' : 'badge-inactive' }}">
                    {{ $service->status ? 'AKTIF' : 'INACTIVE' }}
                </span>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Dibuat Sejak</label>
                <p style="margin: 0;">{{ $service->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Statistik</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="padding: 15px; background: #f3f4f6; border-radius: 8px;">
                <p style="margin: 0; font-size: 12px; color: #9ca3af;">Total Subscriptions</p>
                <p style="margin: 5px 0 0 0; font-size: 28px; font-weight: 700;">{{ $service->subscriptions->count() }}</p>
            </div>
            <div style="padding: 15px; background: #f3f4f6; border-radius: 8px;">
                <p style="margin: 0; font-size: 12px; color: #9ca3af;">Active Subscriptions</p>
                <p style="margin: 5px 0 0 0; font-size: 28px; font-weight: 700;">{{ $service->subscriptions->where('status', 'active')->count() }}</p>
            </div>
            <div style="padding: 15px; background: #f3f4f6; border-radius: 8px;">
                <p style="margin: 0; font-size: 12px; color: #9ca3af;">Monthly Revenue</p>
                <p style="margin: 5px 0 0 0; font-size: 28px; font-weight: 700; color: #10b981;">Rp {{ number_format($service->price * $service->subscriptions->where('status', 'active')->count(), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Subscriptions -->
<div class="table-section">
    <div class="table-header">
        <h2>Pelanggan Berlangganan</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>CUSTOMER</th>
                <th>TANGGAL MULAI</th>
                <th>TANGGAL AKHIR</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($service->subscriptions as $subscription)
                <tr>
                    <td><strong>{{ $subscription->customer->name }}</strong></td>
                    <td>{{ $subscription->start_date?->format('d M Y') ?? '-' }}</td>
                    <td>{{ $subscription->end_date?->format('d M Y') ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $subscription->status === 'active' ? 'active' : 'inactive' }}">
                            {{ strtoupper($subscription->status) }}
                        </span>
                    </td>
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

@endsection
