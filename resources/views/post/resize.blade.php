@extends('auth.layouts')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">

    <div class="card">
        <div class="card-header">Resize Photo</div>
        <div class="card-body">
            <form action="{{ route('resizeImage', ['users' => $users->id]) }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="photo" value="{{ $users->photo }}">

                <div class="mb-3 row">
                    <label for="size" class="col-md-4 col-form-label text-md-end text-start">Choose image size:</label>
                    <div class="col-md-6">
                        <select name="size" id="size" class="form-control">
                            <option value="square" {{ $users->size === 'square' ? 'selected' : '' }}>Square</option>
                            <option value="thumbnail" {{ $users->size === 'thumbnail' ? 'selected' : '' }}>Thumbnail</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-warning">
                            Resize Image
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </div>
</div>

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
                    <img src="{{ asset('storage/photos/original/' . $users->photo) }}">
                @else
                    <p>Tidak Ada Photo</p>
                @endif
            </td>
            <td>
                @if (File::exists(storage_path('app/public/photos/square/' . $users->photo)))
                    <img src="{{ asset('storage/photos/square/' . $users->photo) }}">
                @else
                    <p>Photo Belum Diresize</p>
                @endif
            </td>
            <td>
                @if (File::exists(storage_path('app/public/photos/thumbnail/' . $users->photo)))
                    <img src="{{ asset('storage/photos/thumbnail/' . $users->photo) }}">
                @else
                    <p>Photo Belum Diresize</p>
                @endif
            </td>
        </tr>
    </tbody>
</table>

@endsection
