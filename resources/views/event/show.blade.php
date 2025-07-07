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
    </div>
@endsection
