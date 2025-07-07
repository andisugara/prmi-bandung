@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Sponsor</h5>
            </div>
            <div class="card-body">
                @include('layouts.alert.success')
                @include('layouts.alert.error')
                <form id="modalUserForm" class="row g-6" action="{{ route('sponsor.update', $sponsor->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Nama -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="name">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $sponsor->name }}"
                            class="form-control" placeholder="Nama" />
                    </div>

                    <!-- Gambar -->
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="image">Gambar</label>
                        <input type="file" id="image" name="thumbnail" class="form-control" accept="image/*" />
                        <small class="text-muted">Maksimal ukuran file: 5MB</small>
                        <div class="mt-3">
                            <img id="image-preview" src="{{ $sponsor->image }}" alt="Preview Gambar"
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
                        'thumbnail': {
                            validators: {
                                notEmpty: {
                                    message: 'The image is required'
                                },
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
            })
        });
    </script>
@endpush
