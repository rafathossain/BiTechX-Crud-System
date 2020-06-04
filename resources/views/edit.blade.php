@extends('Layout.app')

@section('content')
<form action="{{ route('entires.update') }}" method="POST" enctype="multipart/form-data" class="mx-auto pt-1" style="max-width:700px;">
    @csrf
    <input type="text" value="{{ Request::get('id') }}" name="id" required hidden />
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $entires[0]->email }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Upload file (Max Size: 2MB)</label>
        <input type="file" name="file" class="form-control-file" required>
    </div>
    <a href="{{ asset(Storage::url($entires[0]->file)) }}" target="_blank">
        <button type="button" class="btn btn-success btn-block">View Currently Uploaded File</button>
    </a>
    <br>
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
    <br>
    <a href="{{ route('home') }}">
        <button type="button" class="btn btn-danger btn-block">Go to Homepage</button>
    </a>
</form>
@endsection