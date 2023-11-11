@extends('auth.layouts')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    @if(count($galleries) > 0)
                    @foreach ($galleries as $gallery)
                    <div class="col-sm-4">
                        <div>
                            <a class="example-image-link" href="{{asset('storage/posts_image/'.$gallery->picture)}}" data-lightbox="roadtrip" data-title="{{$gallery->description}}">
                                <img class="example-image img-fluid mb-2" src="{{asset('storage/posts_image/'.$gallery->picture)}}" alt="image-1" />
                            </a>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h3>Tidak ada data.</h3>
                    @endif
                </div>
                <div class="d-flex">
                    {{ $galleries->links() }}
                </div>
                <div class="mt-3">
                    <a href="{{ route('gallery.create') }}" class="btn btn-success">Tambah Gambar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
