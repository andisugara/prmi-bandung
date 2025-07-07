@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Member</h5>
            </div>
            <div class="card-body">
                @include('layouts.alert.success')
                @include('layouts.alert.error')
                <form id="modalUserForm" class="row g-6" action="{{ route('member.store') }}" method="POST">
                    @csrf
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalmodalUserFirstName">Nama</label>
                        <input type="text" id="modalmodalUserFirstName" name="name" value="{{ old('name') }}"
                            class="form-control" placeholder="Castilla" value="" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalmodalUserFirstName">Badge</label>
                        <input type="text" id="modalmodalUserFirstName" name="badge" value="{{ old('badge') }}"
                            class="form-control" placeholder="" value="" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalmodalUserFirstName">Harga</label>
                        <input type="text" id="modalmodalUserFirstName" name="price" value="{{ old('price') }}"
                            class="form-control numeral-mask" placeholder="" value="" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="html5-color-input" class="form-label">Color</label>
                        <input class="form-control" name="color" type="color" value="#666EE8" id="html5-color-input" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">Benefits</label>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                @foreach ($benefits as $benefit)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="benefits[]"
                                            id="benefit-{{ $benefit->id }}" value="{{ $benefit->id }}"
                                            {{ is_array(old('benefits')) && in_array($benefit->id, old('benefits')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="benefit-{{ $benefit->id }}">
                                            {{ $benefit->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-12  text-end">
                        <button type="submit" class="btn btn-primary me-3">Submit</button>
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
                        'price': {
                            validators: {
                                notEmpty: {
                                    message: 'The price is required'
                                },

                            }
                        },
                        'color': {
                            validators: {
                                notEmpty: {
                                    message: 'The color is required'
                                }
                            }
                        },
                        'benefits[]': {
                            validators: {
                                notEmpty: {
                                    message: 'Please select at least one benefit'
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
        });
    </script>
@endpush
