@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
        <div class="card-header text-center bg-primary text-white">
            <h3><b>Register</b></h3>    
        </div>
            <div class="card-body">
                <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end">Username</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Your Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="photo" class="col-md-4 col-form-label text-md-end">Photo</label>
                        <div class="col-md-8">
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old('photo') }}">
                            @if ($errors->has('photo'))
                                <span class="text-danger">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection