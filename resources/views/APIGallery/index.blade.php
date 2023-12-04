@extends('auth.layouts')
@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Gallery Photos</h4>
                <a href="{{ route('PostGallery') }}" class="btn btn-success">Tambah Gambar</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($datas as $gallery)
                    <div class="col-sm-3 mt-3" style="display: flex; flex-direction: column;">
                        <div style="position: relative;">
                            <a class="example-image-link" href="{{ asset('public/posts_image/' . $gallery->picture) }}"
                                data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                <img class="example-image img-fluid mb-2"
                                    src="{{ asset('public/posts_image/' . $gallery->picture) }}" alt="image-1" />
                            </a>
                        
                            <div
                                style="padding: 10px; background-color: #f8f9fa; border-radius: 5px; margin-top: 10px;">
                                <h5>{{ $gallery->title }}</h5>
                                <p>{{ $gallery->description }}</p>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">
                            <form action="{{ route('gallery.edit', $gallery->id) }}" method="get"
                                style="margin-right: 5px;">
                                @csrf
                                <button class="btn btn-primary cute-button edit-button" type="submit"
                                    onclick="return confirm('Yakin mau melakukan edit')">Edit</button>
                            </form>

                            <form action="{{ route('gallery.destroy', $gallery->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger cute-button hapus-button" type="submit"
                                    onclick="return confirm('Yakin mau dihapus')">Hapus</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection