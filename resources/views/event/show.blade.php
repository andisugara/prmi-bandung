@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Detail Event</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nama Event -->
                                <div class="mb-3">
                                    <h6>Nama Event:</h6>
                                    <p>{{ $event->name }}</p>
                                </div>

                                <!-- Lokasi -->
                                <div class="mb-3">
                                    <h6>Lokasi:</h6>
                                    <p>{{ $event->location }}</p>
                                </div>

                                <!-- Tanggal Mulai -->
                                <div class="mb-3">
                                    <h6>Tanggal Mulai:</h6>
                                    <p>{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y H:i') }}</p>
                                </div>

                                <!-- Tanggal Selesai -->
                                <div class="mb-3">
                                    <h6>Tanggal Selesai:</h6>
                                    <p>{{ \Carbon\Carbon::parse($event->end_date)->format('d-m-Y H:i') }}</p>
                                </div>

                                {{-- harga --}}
                                <!-- Harga -->
                                <div class="mb-3">
                                    <h6>Harga:</h6>
                                    <p>
                                        <i class="icon-base ti tabler-user"></i> Member: Rp
                                        {{ number_format($event->member_price, 0, ',', '.') }}<br>
                                        <i class="icon-base ti tabler-user"></i> Non Member: Rp
                                        {{ number_format($event->non_member_price, 0, ',', '.') }}<br>
                                        <i class="icon-base ti tabler-user"></i> Normal: Rp
                                        {{ number_format($event->normal_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Deskripsi -->
                                <div class="mb-3">
                                    <h6>Deskripsi:</h6>
                                    <p>{{ $event->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <h6>Status:</h6>
                                    <span class="badge bg-primary">{{ ucfirst($event->status) }}</span>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="mt-4">
                                    <a href="{{ route('event.index') }}" class="btn btn-secondary">Kembali</a>
                                    <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning">Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Thumbnail -->
                        @if ($event->image)
                            <div class="mb-4 text-center">
                                <img src="{{ asset($event->image) }}" alt="Thumbnail" class="img-fluid rounded"
                                    style="max-width: 300px;">
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0 text-md-start text-center pb-md-0 pb-6">Daftar Peserta</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered" id="participantTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Transaksi ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Hp</th>
                            <th>Qty</th>
                            <th>Bukti Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->event_transactions as $participant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $participant->transaction_id }}</td>
                                <td>{{ $participant->name }}</td>
                                <td>{{ $participant->email }}</td>
                                <td>{{ $participant->phone }}</td>
                                <td>{{ number_format($participant->qty, 0, ',', '.') }}</td>
                                <td>
                                    @if ($participant->bukti_pembayaran)
                                        <a href="{{ asset($participant->bukti_pembayaran) }}" target="_blank"
                                            class="btn btn-info btn-sm">Lihat Bukti Bayar</a>
                                    @else
                                        Tidak ada bukti bayar
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $participant->status == 'success' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($participant->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($participant->status == 'pending')
                                        <button class="btn btn-primary btn-sm mt-1"
                                            onclick="updateStatus('{{ $participant->id }}',  'success')">
                                            Konfirmasi Pembayaran
                                        </button>
                                        <button class="btn btn-danger btn-sm ml-1 mt-1"
                                            onclick="updateStatus('{{ $participant->id }}',  'failed')">
                                            Tolak
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#participantTable').DataTable({});
        });

        function updateStatus(participantId, status) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('event') }}/" + participantId + '/update-status-participant',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            event_transaction_id: participantId,
                            status: status
                        },
                        success: function(response) {
                            Swal.fire(
                                'Berhasil!',
                                response.message,
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endpush
