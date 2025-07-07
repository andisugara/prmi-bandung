@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Update Settings</h5>
            </div>
            <div class="card-body">
                @include('layouts.alert.success')
                @include('layouts.alert.error')
                <form id="modalUserForm" action="{{ route('about-us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="image">Content</label>
                        <textarea id="about_us" name="about_us" class="form-control" placeholder="Content">{{ $about_us->about_us }}</textarea>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // tinymce
            tinymce.init({
                selector: '#content',
                plugins: 'lists link image code table',
                toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | table',
                menubar: false,
                height: 700,
                images_upload_url: "{{ route('blog.upload') }}",
                automatic_uploads: true,
                selector: 'textarea',
                file_picker_types: 'image',
                file_picker_callback: function(callback, value, meta) {
                    //    upload file

                },
                convert_urls: false,
                relative_urls: true,
                remove_script_host: true,
                document_base_url: '/'
            });
            const fv = FormValidation.formValidation(
                document.getElementById('modalUserForm'), {
                    fields: {
                        'about_us': {
                            validators: {
                                notEmpty: {
                                    message: 'The content is required'
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
            })
        });
    </script>
@endpush
