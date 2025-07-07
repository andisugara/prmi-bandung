@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Event</h5>
            </div>
            <div class="card-body">
                @include('layouts.alert.success')
                @include('layouts.alert.error')
                <form id="modalUserForm" class="row g-6" action="{{ route('event.update', $event->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Nama Event -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">Nama Event</label>
                        <input type="text" id="name" name="name" value="{{ $event->name }}" class="form-control"
                            placeholder="Nama Event" />
                    </div>

                    <!-- Lokasi -->
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="location">Lokasi</label>
                        <input type="text" id="location" name="location" value="{{ $event->location }}"
                            class="form-control" placeholder="Lokasi Event" />
                    </div>

                    <!-- Quota -->
                    <div class="col-12 col-md-2">
                        <label class="form-label" for="location">Kuota</label>
                        <input type="number" id="quota" autocomplete="off" name="quota" value="{{ $event->quota }}"
                            class="form-control" placeholder="Kuota Event" min="1" />
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="start_date">Tanggal Mulai</label>
                        <input type="text" id="start_date" name="start_date" value="{{ $event->start_date }}"
                            class="form-control flatpickr-datetime" />
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="end_date">Tanggal Selesai</label>
                        <input type="text" id="end_date" name="end_date" value="{{ $event->end_date }}"
                            class="form-control flatpickr-datetime" />
                    </div>

                    <!-- Harga Member -->
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="member_price">Harga Member</label>
                        <input type="text" id="member_price" autocomplete="off" name="member_price"
                            value="{{ formatRupiah($event->member_price) }}" class="form-control numeral-mask"
                            placeholder="Harga Member" required />
                    </div>

                    <!-- Harga Non-Member -->
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="non_member_price">Harga Non-Member</label>
                        <input type="text" id="non_member_price" autocomplete="off" name="non_member_price"
                            value="{{ formatRupiah($event->non_member_price) }}" class="form-control numeral-mask"
                            placeholder="Harga Non-Member" required />
                    </div>

                    <!-- Harga Normal -->
                    <div class="col-12 col-md-4">
                        <label class="form-label" for="normal_price">Harga Normal</label>
                        <input type="text" id="normal_price" autocomplete="off" name="normal_price"
                            value="{{ formatRupiah($event->normal_price) }}" class="form-control numeral-mask"
                            placeholder="Harga Normal" required />
                    </div>


                    <!-- Deskripsi -->
                    <div class="col-12">
                        <label class="form-label" for="description">Deskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="4" placeholder="Deskripsi Event">{{ $event->description }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="status">Status</label>
                        <select id="status" name="status" class="form-select">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="upcoming" {{ $event->status == 'upcoming' ? 'selected' : '' }}>Upcoming
                            </option>
                            <option value="ongoing" {{ $event->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="closed" {{ $event->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Thumbnail -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="thumbnail">Thumbnail</label>
                        <input type="file" id="thumbnail" name="thumbnail" class="form-control" accept="image/*" />
                        <input type="hidden" name="old_thumbnail" value="{{ $event->image }}">
                        <small class="text-muted">Maksimal ukuran file: 5MB</small>
                        <div class="preview mt-2">
                            <img id="thumbnailPreview" src="{{ asset($event->image) ?? asset('images/prmi-logo.webp') }}"
                                alt="Thumbnail Preview" class="img-thumbnail"
                                style="max-width: 100%; max-height: 200px;" />
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            const numeralMasks = document.querySelectorAll('.numeral-mask');
            numeralMasks.forEach(mask => {
                mask.addEventListener('input', event => {
                    mask.value = formatNumeral(event.target.value, {
                        prefix: 'Rp ',
                        thousandsSeparator: '.',
                        decimalSeparator: ',',
                        decimalDigits: 0,
                    });
                });
            });

            const fv = FormValidation.formValidation(
                document.getElementById('modalUserForm'), {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'The name is required'
                                }
                            }
                        },
                        'location': {
                            validators: {
                                notEmpty: {
                                    message: 'The location is required'
                                }
                            }
                        },
                        'quota': {
                            validators: {
                                notEmpty: {
                                    message: 'The quota is required'
                                },
                                numeric: {
                                    message: 'The quota must be a number'
                                },
                            }
                        },
                        'start_date': {
                            validators: {
                                notEmpty: {
                                    message: 'The start date is required'
                                }
                            }
                        },
                        'end_date': {
                            validators: {
                                notEmpty: {
                                    message: 'The end date is required'
                                }
                            }
                        },
                        'description': {
                            validators: {
                                notEmpty: {
                                    message: 'The description is required'
                                }
                            }
                        },
                        'status': {
                            validators: {
                                notEmpty: {
                                    message: 'The status is required'
                                }
                            }
                        },
                        'thumbnail': {
                            validators: {
                                file: {
                                    extension: 'jpeg,jpg,png',
                                    type: 'image/jpeg,image/png',
                                    maxSize: 5 * 1024 * 1024, // 5 MB
                                    message: 'The selected file is not valid'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap5: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.col-12',
                            eleValidClass: '',
                            eleInvalidClass: ''
                        }),
                        defaultSubmit: new FormValidation.plugins.DefaultSubmit()
                    },
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                }
            );

            $('#thumbnail').on('change', function(e) {
                const file = e.target.files[0]; // Ambil file yang dipilih)
                if (file) {
                    const reader = new FileReader(); // Gunakan FileReader untuk membaca file
                    reader.onload = function(e) {
                        // Set preview image dengan hasil pembacaan file
                        $('#thumbnailPreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file); // Baca file sebagai Data URL
                } else {
                    // Jika tidak ada file, sembunyikan preview
                    $('#thumbnailPreview').hide();
                }
            });

            $('#modalUserForm').on('submit', function(e) {
                e.preventDefault();
                fv.validate().then(function(status) {
                    if (status === 'Valid') {
                        // Submit the form
                        this.submit();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please fill in the form correctly!',
                        });
                    }
                })
            });

            $('.flatpickr-datetime').flatpickr({
                enableTime: true,
                dateFormat: "d-m-Y H:i",
                time_24hr: true,
                allowInput: true,
                minDate: "today",
            });
        });
    </script>
@endpush
