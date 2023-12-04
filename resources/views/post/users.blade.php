@extends('auth.layouts')

@section('content')
<table class="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Photo</th>
      <th scope="col">Action</th>
      <th scope="col">Resize</th> 
    </tr>
  </thead>
  <tbody>
  @foreach($data_users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @if(File::exists(public_path('storage/photos/thumbnail/'. $user->photo )) == false)
                <p>Not Available</p>
              @else
                <img src="{{ asset('public/storage/photos/thumbnail/'. $user->photo ) }}" width="150px">
              @endif
            </td>
            <td>
              <div class="d-flex flex-row gap-3">
                <a class="btn btn-sm btn-primary" href="{{ route('edit', ['id' => $user->id]) }}">Edit</a>
                <form action="{{ route('destroy', $user->id) }}" method="post">
                  @csrf
                  @method('delete')
                  <button onclick="return confirm('Are you sure to delete?')" type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
              </div>
            </td>
            <td>
            <a class="btn btn-sm btn-success" href="{{ route('resizeForm', ['user' => $user->id]) }}">Resize</a>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>
@endsection
