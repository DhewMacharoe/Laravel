@extends('layouts.admin')

@section('title', 'Dashboard - DelBites')

@section('page-title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Pesanan</h6>
                                <h4 class="mb-0">{{ $totalPesanan }}</h4>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-shopping-cart text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Pelanggan</h6>
                                <h4 class="mb-0">{{ $totalPelanggan }}</h4>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-users text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Menu</h6>
                                <h4 class="mb-0">{{ $totalMenu }}</h4>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-box text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-2">Total Stok Bahan</h6>
                                <h4 class="mb-0">{{ $totalStok }}</h4>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-boxes text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pesanan Terbaru</h5>
                        <div>
                            <span id="cafeStatusText">Aktif</span>
                            <label class="switch" style="margin-left: 10px;">
                                <input type="checkbox" id="toggleCafeStatus" checked>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pesananTerbaru as $pesanan)
                                        <tr>
                                            <td>#{{ $pesanan->id }}</td>
                                            <td>{{ $pesanan->pelanggan->nama }}</td>
                                            <td>{{ $pesanan->created_at->format('d/m/Y H:i') }}</td>
                                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($pesanan->status === 'menunggu')
                                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                                @elseif ($pesanan->status === 'pembayaran')
                                                    <span class="badge bg-info text-white">Pembayaran</span>
                                                @elseif ($pesanan->status === 'selesai')
                                                    <span class="badge bg-success ">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal" data-bs-target="#detailModal"
                                                    data-id="{{ $pesanan->id }}">
                                                    <i class="fas fa-eye"></i> Detail
                                                </button>

                                                @if ($pesanan->status === 'menunggu')
                                                    <form
                                                        action="{{ route('pesanan.status', ['id' => $pesanan->id, 'status' => 'diproses']) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check-circle"></i> Terima
                                                        </button>
                                                    </form>
                                                @elseif ($pesanan->status === 'pembayaran')
                                                    <form
                                                        action="{{ route('pesanan.status', ['id' => $pesanan->id, 'status' => 'diproses']) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check-circle"></i> Terima
                                                        </button>
                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                Tidak ada pesanan menunggu
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

        <!-- Menu Terlaris -->
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Menu Terlaris</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($menuTerlaris as $menu)
                                        <tr>
                                            <td>{{ $menu->nama_menu }}</td>
                                            <td>
                                                @if ($menu->kategori == 'makanan')
                                                    <span class="badge bg-success">Makanan</span>
                                                @else
                                                    <span class="badge bg-info">Minuman</span>
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                            <td>{{ $menu->total_terjual }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data menu</td>
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

    <!-- Modal Detail Pesanan -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pesanan #<span id="pesananId"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>ID Pelanggan:</strong> <span id="idPelanggan"></span></p>
                            <p><strong>Nama Pelanggan:</strong> <span id="namaPelanggan"></span></p>
                            <p><strong>Telepon:</strong> <span id="teleponPelanggan"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal Pesanan:</strong> <span id="tanggalPesanan"></span></p>
                            <p><strong>Total:</strong> <span id="totalHarga"></span></p>
                            <p><strong>Metode Pembayaran:</strong> <span id="metodePembayaran"></span></p>
                            <p><strong>Status:</strong> <span id="statusPesanan"></span></p>
                        </div>
                    </div>

                    <h6 class="mb-3">Daftar Pesanan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Menu</th>
                                    <th>Harga</th>
                                    <th>Jumlah </th>
                                    <th>Subtotal</th>
                                    <th>Suhu</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody id="detailPesananBody">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer" id="modalFooter">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }
    </style>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleCafeStatus = document.getElementById('toggleCafeStatus');
            const cafeStatusText = document.getElementById('cafeStatusText');
            const paymentButtons = document.querySelectorAll('.payment-button');

            // Check local storage for cafe status
            if (localStorage.getItem('cafeStatus') === 'nonaktif') {
                toggleCafeStatus.checked = false;
                cafeStatusText.textContent = 'Non Aktif';
                paymentButtons.forEach(button => {
                    button.disabled = true;
                    button.onclick = function() {
                        alert('Cafe sedang tutup');
                    };
                });
            }

            toggleCafeStatus.addEventListener('change', function() {
                if (this.checked) {
                    cafeStatusText.textContent = 'Aktif';
                    localStorage.setItem('cafeStatus', 'aktif');
                    paymentButtons.forEach(button => {
                        button.disabled = false;
                    });
                } else {
                    cafeStatusText.textContent = 'Non Aktif';
                    localStorage.setItem('cafeStatus', 'nonaktif');
                    paymentButtons.forEach(button => {
                        button.disabled = true;
                        button.onclick = function() {
                            alert('Cafe sedang tutup');
                        };
                    });
                }
            });
        });
    </script>
@endsection
            