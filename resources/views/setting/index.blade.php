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
                <form action="{{ route('setting.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Sub Title -->
                    <div class="mb-3">
                        <label class="form-label" for="sub_title">Sub Title</label>
                        <input type="text" id="sub_title" name="sub_title"
                            value="{{ old('sub_title', $setting->sub_title) }}" class="form-control"
                            placeholder="Sub Title">
                    </div>

                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $setting->title) }}"
                            class="form-control" placeholder="Title">
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label" for="desc">Description</label>
                        <textarea id="desc" name="desc" class="form-control" rows="4" placeholder="Description">{{ old('desc', $setting->desc) }}</textarea>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $setting->email) }}"
                            class="form-control" placeholder="Email">
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $setting->phone) }}"
                            class="form-control" placeholder="Phone">
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <textarea id="address" name="address" class="form-control" rows="2" placeholder="Address">{{ old('address', $setting->address) }}</textarea>
                    </div>

                    <!-- Instagram -->
                    <div class="mb-3">
                        <label class="form-label" for="instagram">Instagram</label>
                        <input type="text" id="instagram" name="instagram"
                            value="{{ old('instagram', $setting->instagram) }}" class="form-control"
                            placeholder="Instagram">
                    </div>

                    <!-- WhatsApp -->
                    <div class="mb-3">
                        <label class="form-label" for="whatsapp">WhatsApp</label>
                        <input type="text" id="whatsapp" name="whatsapp"
                            value="{{ old('whatsapp', $setting->whatsapp) }}" class="form-control" placeholder="WhatsApp">
                    </div>


                    <!-- Member Periode -->
                    <div class="mb-3">
                        <label class="form-label" for="member_periode">Member Periode</label>
                        <div class="input-group">
                            <input type="text" id="member_periode" name="member_periode"
                                value="{{ old('member_periode', $setting->member_periode) }}" class="form-control"
                                placeholder="Member Periode">
                            <span class="input-group-text">Tahun</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
