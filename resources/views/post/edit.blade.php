@extends('auth.layouts')

@section('content')
<div class="container" style="margin-top: 20px;">
    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <div class="card-header text-center bg-primary text-white">
            <h3><b>Edit Profile</b></h3>
        </div>
        <div class="card-body">
            <form action="{{ route('update', ['id' => $users->id ]) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="mb-3 row">
                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                    <div class="col-md-8">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="photo" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                        @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row g-2">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="/users" class="btn btn-danger ml-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
