@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tambah Admin</h5>
            </div>
            <div class="card-body">
                @include('layouts.alert.success')
                @include('layouts.alert.error')
                <form id="modalUserForm" class="row g-6" action="{{ route('admin.store') }}" method="POST">
                    @csrf
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalmodalUserFirstName">First Name</label>
                        <input type="text" id="modalmodalUserFirstName" name="name" class="form-control"
                            placeholder="John" value="" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalmodalUserEmail">Email</label>
                        <input type="text" id="modalmodalUserEmail" name="email" class="form-control"
                            placeholder="example@domain.com" value="" />
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="modalmodalUserPhone">Phone Number</label>
                        <div class="input-group">
                            <span class="input-group-text">ID (+62)</span>
                            <input type="text" id="modalmodalUserPhone" name="phone"
                                class="form-control phone-number-mask" placeholder="82240356763" value="" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label class="form-label" for="modalmodalUserStatus">Status</label>
                        <label class="switch switch-square">
                            <input type="checkbox" class="switch-input" name="status" id="modalmodalUserStatus" />
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                            <span class="switch-label"></span>
                        </label>
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
                        'email': {
                            validators: {
                                notEmpty: {
                                    message: 'The email is required'
                                },
                                emailAddress: {
                                    message: 'The input is not a valid email address'
                                }
                            }
                        },
                        'phone': {
                            validators: {
                                notEmpty: {
                                    message: 'The phone number is required'
                                },
                                phone: {
                                    country: 'ID',
                                    message: 'The input is not a valid phone number'
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
