@extends('layouts.admin')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Pemesanan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pemesanan</h6>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter Status
                </button>
                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                    <a class="dropdown-item" href="{{ route('admin.bookings.index') }}">Semua</a>
                    <a class="dropdown-item" href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">Menunggu Konfirmasi</a>
                    <a class="dropdown-item" href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}">Dikonfirmasi</a>
                    <a class="dropdown-item" href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}">Dibatalkan</a>
                    <a class="dropdown-item" href="{{ route('admin.bookings.index', ['status' => 'completed']) }}">Selesai</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paket</th>
                            <th>Pemesan</th>
                            <th>Tanggal</th>
                            <th>Jumlah Orang</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_id }}</td>
                                <td>{{ $booking->package->package_name }}</td>
                                <td>{{ $booking->user->full_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                                <td>{{ $booking->number_of_people }}</td>
                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : ($booking->status === 'confirmed' ? 'success' : ($booking->status === 'cancelled' ? 'danger' : 'info')) }} rounded-pill px-3">
                                        {{ $booking->status === 'pending' ? 'Menunggu Konfirmasi' : ($booking->status === 'confirmed' ? 'Dikonfirmasi' : ($booking->status === 'cancelled' ? 'Dibatalkan' : 'Selesai')) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }} rounded-pill px-3">
                                        {{ $booking->payment_status === 'paid' ? 'Lunas' : 'Belum Dibayar' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.bookings.show', $booking->booking_id) }}" 
                                           class="btn btn-info btn-sm" 
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($booking->status === 'pending')
                                            <button type="button" 
                                                    class="btn btn-success btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#confirmModal{{ $booking->booking_id }}"
                                                    title="Konfirmasi">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    data-toggle="modal" 
                                                    data-target="#cancelModal{{ $booking->booking_id }}"
                                                    title="Batalkan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Confirm Modal -->
                                    <div class="modal fade" id="confirmModal{{ $booking->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pemesanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.bookings.update-status', $booking->booking_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin mengkonfirmasi pemesanan ini?</p>
                                                        <div class="form-group">
                                                            <label for="notes">Catatan (Opsional)</label>
                                                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Cancel Modal -->
                                    <div class="modal fade" id="cancelModal{{ $booking->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="cancelModalLabel">Batalkan Pemesanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.bookings.update-status', $booking->booking_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin membatalkan pemesanan ini?</p>
                                                        <div class="form-group">
                                                            <label for="notes">Alasan Pembatalan</label>
                                                            <textarea class="form-control" id="notes" name="notes" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Batalkan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data pemesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush 