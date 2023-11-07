@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card" style="background-color: #EDF6F9;">
        <div class="card-header text-center bg-primary text-white">
            <h3><b>Resize Photo</b></h3>
        </div>
            <div class="card-body">
                <form action="{{ route('resizeImage', ['users' => $users->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="photo" value="{{ $users->photo }}">

                    <div class="mb-3 row">
                        <label for="size" class="col-md-4 col-form-label text-md-end text-start">Choose image size:</label>
                        <div class="col-md-6">
                            <select name="size" id="size" class="form-select">
                                <option value="square" {{ $users->size === 'square' ? 'selected' : '' }}>Square</option>
                                <option value="thumbnail" {{ $users->size === 'thumbnail' ? 'selected' : '' }}>Thumbnail</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-warning">Resize Image</button>
                            <a href="{{ route('users') }}" class="btn btn-secondary">Back to Users</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Original Photo</th>
                    <th scope="col">Square Photo</th>
                    <th scope="col">Thumbnail Photo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if($users->photo)
                            <img src="{{ asset('storage/photos/original/' . $users->photo) }}" class="img-thumbnail" alt="Original">
                        @else
                            <p>Tidak Ada Photo</p>
                        @endif
                    </td>
                    <td>
                        @if (File::exists(storage_path('app/public/photos/square/' . $users->photo)))
                            <img src="{{ asset('storage/photos/square/' . $users->photo) }}" class="img-thumbnail" alt="Square">
                        @else
                            <p>Photo Belum Diresize</p>
                        @endif
                    </td>
                    <td>
                        @if (File::exists(storage_path('app/public/photos/thumbnail/' . $users->photo)))
                            <img src="{{ asset('storage/photos/thumbnail/' . $users->photo) }}" class="img-thumbnail" alt="Thumbnail">
                        @else
                            <p>Photo Belum Diresize</p>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
