@extends('layouts.master')

@section('title', 'Subscription Detail - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Detail Subscription</h1>
        <p>Informasi detail subscription pelanggan.</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('subscriptions.index') }}" class="btn btn-outline">← Kembali</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- Customer Info -->
    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Informasi Pelanggan</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Nama</label>
                <p style="margin: 0; font-weight: 500;">{{ $subscription->customer->name }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Email</label>
                <p style="margin: 0;">{{ $subscription->customer->email }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Telepon</label>
                <p style="margin: 0;">{{ $subscription->customer->phone ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Service Info -->
    <div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb;">
        <h3 style="margin-bottom: 15px; font-size: 16px;">Informasi Layanan</h3>
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Nama Service</label>
                <p style="margin: 0; font-weight: 500;">{{ $subscription->service->name }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Harga</label>
                <p style="margin: 0; font-weight: 600; color: #10b981;">Rp {{ number_format($subscription->service->price, 0, ',', '.') }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Description</label>
                <p style="margin: 0;">{{ $subscription->service->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Subscription Details -->
<div style="background: white; padding: 20px; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 30px;">
    <h3 style="margin-bottom: 15px; font-size: 16px;">Detail Subscription</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        <div>
            <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Tanggal Mulai</label>
            <p style="margin: 0; font-weight: 500;">{{ $subscription->start_date?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Tanggal Akhir</label>
            <p style="margin: 0; font-weight: 500;">{{ $subscription->end_date?->format('d M Y') ?? '-' }}</p>
        </div>
        <div>
            <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Durasi</label>
            <p style="margin: 0; font-weight: 500;">
                @if($subscription->start_date && $subscription->end_date)
                    {{ $subscription->end_date->diffInDays($subscription->start_date) }} hari
                @else
                    -
                @endif
            </p>
        </div>
        <div>
            <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Status</label>
            <span class="badge badge-{{ $subscription->status === 'active' ? 'active' : 'inactive' }}">
                {{ strtoupper($subscription->status) }}
            </span>
        </div>
        <div>
            <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Dibuat</label>
            <p style="margin: 0; font-size: 13px;">{{ $subscription->created_at->format('d M Y H:i') }}</p>
        </div>
        <div>
            <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 4px;">Terakhir Diperbarui</label>
            <p style="margin: 0; font-size: 13px;">{{ $subscription->updated_at->format('d M Y H:i') }}</p>
        </div>
    </div>
</div>

@endsection
