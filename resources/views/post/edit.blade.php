@extends('auth.layouts')

@section('content')
<div class="container">
    <form action="{{ route('update', ['id' => $users->id ]) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="mb-3 row">
            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
            <div class="col-md-6">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $name }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
            <div class="col-md-6">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row">
            <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
            <div class="col-md-6">
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                @error('photo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-3 row g-2">
        <div class="col-md-6 offset-md-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/users" class="btn btn-danger ml-2">Cancel</a>
    </div>
</div>

@endsection
