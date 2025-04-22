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
            <div class="d-flex">
                <!-- Search Box -->
                <form class="d-none d-sm-inline-block form-inline mr-3 ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari pemesanan..."
                            aria-label="Search" aria-describedby="basic-addon2" name="search" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                
                <!-- Filter Dropdown -->
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
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="actionDropdown{{ $booking->booking_id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="actionDropdown{{ $booking->booking_id }}">
                                            <a class="dropdown-item" href="{{ route('admin.bookings.show', $booking->booking_id) }}">
                                                <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Detail
                                            </a>
                                            @if($booking->status === 'pending')
                                            <a class="dropdown-item text-success" href="#" data-toggle="modal" data-target="#confirmModal{{ $booking->booking_id }}">
                                                <i class="fas fa-check fa-sm fa-fw mr-2 text-success"></i>
                                                Konfirmasi
                                            </a>
                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#cancelModal{{ $booking->booking_id }}">
                                                <i class="fas fa-times fa-sm fa-fw mr-2 text-danger"></i>
                                                Batalkan
                                            </a>
                                            @elseif($booking->status === 'confirmed')
                                            <a class="dropdown-item text-info" href="#" data-toggle="modal" data-target="#completeModal{{ $booking->booking_id }}">
                                                <i class="fas fa-check-double fa-sm fa-fw mr-2 text-info"></i>
                                                Selesaikan
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#cancelModal{{ $booking->booking_id }}">
                                                <i class="fas fa-times fa-sm fa-fw mr-2 text-danger"></i>
                                                Batalkan
                                            </a>
                                            @endif
                                            
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#paymentStatusModal{{ $booking->booking_id }}">
                                                <i class="fas fa-money-bill fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Update Pembayaran
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#deleteModal{{ $booking->booking_id }}">
                                                <i class="fas fa-trash fa-sm fa-fw mr-2 text-danger"></i>
                                                Hapus Pemesanan
                                            </a>
                                        </div>
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

                                    <!-- Complete Modal -->
                                    <div class="modal fade" id="completeModal{{ $booking->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="completeModalLabel">Selesaikan Pemesanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.bookings.update-status', $booking->booking_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menyelesaikan pemesanan ini?</p>
                                                        <div class="form-group">
                                                            <label for="notes">Catatan (Opsional)</label>
                                                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-info">Selesaikan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Payment Status Modal -->
                                    <div class="modal fade" id="paymentStatusModal{{ $booking->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="paymentStatusModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentStatusModalLabel">Update Status Pembayaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.bookings.update-payment-status', $booking->booking_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="payment_status">Status Pembayaran</label>
                                                            <select class="form-control" id="payment_status" name="payment_status" required>
                                                                <option value="unpaid" {{ $booking->payment_status === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                                                                <option value="paid" {{ $booking->payment_status === 'paid' ? 'selected' : '' }}>Lunas</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="notes">Catatan (Opsional)</label>
                                                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $booking->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Pemesanan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.bookings.delete', $booking->booking_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <div class="text-center mb-3">
                                                            <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                                                        </div>
                                                        <p class="text-center mb-4">Apakah Anda yakin ingin menghapus pemesanan ini? Tindakan ini tidak dapat dibatalkan.</p>
                                                        <p class="mb-2"><strong>Paket:</strong> {{ $booking->package->package_name }}</p>
                                                        <p class="mb-2"><strong>Pemesan:</strong> {{ $booking->user->full_name }}</p>
                                                        <p class="mb-0"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
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
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $bookings->appends(request()->query())->links() }}
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