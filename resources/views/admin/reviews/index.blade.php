@extends('layouts.admin')

@section('title', 'Kelola Review')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Review</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Review</h6>
            <div>
                <form class="d-none d-sm-inline-block form-inline">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Cari berdasarkan nama"
                            aria-label="Search" aria-describedby="basic-addon2" name="search" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Paket</th>
                            <th>Rating</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Balasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{ $review->review_id }}</td>
                                <td>{{ $review->user->full_name }}</td>
                                <td>{{ $review->package->package_name }}</td>
                                <td>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td>{{ $review->comment }}</td>
                                <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</td>
                                <td>
                                    @if($review->admin_reply)
                                        <div class="text-success">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            <span class="small">{{ Str::limit($review->admin_reply, 30) }}</span>
                                        </div>
                                    @else
                                        <span class="badge badge-warning">Belum dibalas</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm {{ $review->admin_reply ? 'btn-info' : 'btn-primary' }}" 
                                            data-toggle="modal" 
                                            data-target="#replyModal{{ $review->review_id }}"
                                            title="{{ $review->admin_reply ? 'Edit Balasan' : 'Tambah Balasan' }}">
                                        <i class="fas {{ $review->admin_reply ? 'fa-edit' : 'fa-reply' }}"></i>
                                        {{ $review->admin_reply ? 'Edit' : 'Balas' }}
                                    </button>
                                    <form action="{{ route('admin.reviews.destroy', $review->review_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Reply Modal -->
                            <div class="modal fade" id="replyModal{{ $review->review_id }}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel{{ $review->review_id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="replyModalLabel{{ $review->review_id }}">
                                                {{ $review->admin_reply ? 'Edit Balasan' : 'Tambah Balasan' }} Review
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.reviews.reply', $review->review_id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <h6 class="font-weight-bold">Detail Review:</h6>
                                                    <div class="card bg-light p-3 mb-3">
                                                        <p class="mb-1"><strong>Dari:</strong> {{ $review->user->full_name }}</p>
                                                        <p class="mb-1"><strong>Paket:</strong> {{ $review->package->package_name }}</p>
                                                        <p class="mb-1"><strong>Rating:</strong> 
                                                            <span class="text-warning">
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                                                @endfor
                                                            </span>
                                                        </p>
                                                        <p class="mb-0"><strong>Komentar:</strong> {{ $review->comment }}</p>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="admin_reply">Balasan Admin:</label>
                                                        <textarea 
                                                            class="form-control" 
                                                            id="admin_reply" 
                                                            name="admin_reply" 
                                                            rows="4" 
                                                            required 
                                                            placeholder="Ketik balasan Anda di sini..."
                                                        >{{ $review->admin_reply }}</textarea>
                                                        <small class="form-text text-muted">Balasan akan ditampilkan kepada semua pengunjung website.</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                    <i class="fas fa-times mr-1"></i>Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane mr-1"></i>Kirim Balasan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $reviews->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 