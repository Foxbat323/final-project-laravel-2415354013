@extends('layouts.master')

@section('title', 'Customers - ERPSystem')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Customers</h1>
        <p>Kelola semua data pelanggan Anda.</p>
    </div>
    <div class="header-actions">
        <button class="btn btn-dark" onclick="openModal('modal-add-customer')">
            + Tambah Customer
        </button>
    </div>
</div>

<div class="table-section">
    <table>
        <thead>
            <tr>
                <th>NAMA</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>ADDRESS</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td><strong>{{ $customer->name }}</strong></td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ Str::limit($customer->address, 30) ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $customer->status ? 'badge-active' : 'badge-inactive' }}">
                            {{ $customer->status ? 'AKTIF' : 'INACTIVE' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                        Belum ada data customers
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($customers->hasPages())
    <div style="margin-top: 20px; display: flex; justify-content: center;">
        {{ $customers->links() }}
    </div>
@endif

<!-- Modal Add Customer -->
<div class="modal-overlay" id="modal-add-customer">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Customer Baru</h2>
            <button class="btn-close" onclick="closeModal('modal-add-customer')">&times;</button>
        </div>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" class="form-control" name="phone" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea class="form-control" name="address" rows="3"></textarea>
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