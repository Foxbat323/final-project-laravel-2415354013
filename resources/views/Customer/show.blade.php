@extends('layouts.master')

@section('title', 'Customer Detail - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>{{ $customer->name }}</h1>
        <p>Detail informasi pelanggan.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('customers.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- Customer Info -->
    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Informasi Pelanggan</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Nama</label>
                <p style="margin: 0; font-weight: 500;">{{ $customer->name }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Email</label>
                <p style="margin: 0;">{{ $customer->email }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Telepon</label>
                <p style="margin: 0;">{{ $customer->phone ?? '-' }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Alamat</label>
                <p style="margin: 0;">{{ $customer->address ?? '-' }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Status</label>
                <span class="badge {{ $customer->status ? 'badge-active' : 'badge-inactive' }}">
                    {{ $customer->status ? 'AKTIF' : 'INACTIVE' }}
                </span>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Bergabung Sejak</label>
                <p style="margin: 0;">{{ $customer->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Statistik</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            <div style="padding: 15px; background: #f3f4f6; border-radius: 8px;">
                <p style="margin: 0; font-size: 12px; color: #9ca3af;">Total Subscriptions</p>
                <p style="margin: 5px 0 0 0; font-size: 28px; font-weight: 700;">{{ $customer->subscriptions->count() }}</p>
            </div>
            <div style="padding: 15px; background: #f3f4f6; border-radius: 8px;">
                <p style="margin: 0; font-size: 12px; color: #9ca3af;">Active Subscriptions</p>
                <p style="margin: 5px 0 0 0; font-size: 28px; font-weight: 700;">{{ $customer->subscriptions->where('status', 'active')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Subscriptions -->
<div class="table-section">
    <div class="table-header">
        <h2>Subscriptions</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>SERVICE</th>
                <th>TANGGAL MULAI</th>
                <th>TANGGAL AKHIR</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customer->subscriptions as $subscription)
                <tr>
                    <td><strong>{{ $subscription->service->name }}</strong></td>
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
