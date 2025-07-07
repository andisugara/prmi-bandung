@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Struktur Organisasi</h5>
            </div>
            <div class="card-body">
                @include('layouts.alert.success')
                @include('layouts.alert.error')
                <form id="modalUserForm" class="row g-6" method="POST"
                    action="{{ route('organizational-structure.update', $organizational_structure->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Nama -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $organizational_structure->name }}"
                            class="form-control" placeholder="Nama" required />
                    </div>

                    <!-- Posisi -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="position">Posisi</label>
                        <input type="text" id="position" name="position"
                            value="{{ $organizational_structure->position }}" class="form-control"
                            placeholder="Posisi (Opsional)" />
                    </div>

                    <!-- Instagram -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram"
                            value="{{ $organizational_structure->instagram }}" class="form-control"
                            placeholder="Link Instagram (Opsional)" />
                    </div>

                    <!-- WhatsApp -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="whatsapp">WhatsApp</label>
                        <input type="text" id="whatsapp" name="whatsapp"
                            value="{{ $organizational_structure->whatsapp }}" class="form-control"
                            placeholder="Nomor WhatsApp (Opsional)" />
                    </div>

                    <!-- LinkedIn -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="linkedin">LinkedIn</label>
                        <input type="text" id="linkedin" name="linkedin"
                            value="{{ $organizational_structure->linkedin }}" class="form-control"
                            placeholder="Link LinkedIn (Opsional)" />
                    </div>

                    <!-- Gambar -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="image">Gambar</label>
                        <input type="file" id="image" name="thumbnail" class="form-control" accept="image/*" />
                        <small class="text-muted">Maksimal ukuran file: 5MB</small>
                        <div class="mt-3">
                            <img id="image-preview" src="{{ asset($organizational_structure->image) }}" alt="Preview Gambar"
                                style="max-width: 100%; height: auto;" />
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
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
                        'position': {
                            validators: {
                                notEmpty: {
                                    message: 'The position is required'
                                }
                            }
                        },
                        'thumbnail': {
                            validators: {
                                file: {
                                    extension: 'jpeg,jpg,png,gif',
                                    type: 'image/jpeg,image/png,image/gif',
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

            $('#image').on('change', function(e) {
                const file = e.target.files[0]; // Ambil file yang dipilih)
                if (file) {
                    const reader = new FileReader(); // Gunakan FileReader untuk membaca file
                    reader.onload = function(e) {
                        // Set preview image dengan hasil pembacaan file
                        $('#image-preview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file); // Baca file sebagai Data URL
                } else {
                    // Jika tidak ada file, sembunyikan preview
                    $('#image-preview').hide();
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
