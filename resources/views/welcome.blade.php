@extends('Layout.app')

@section('content')
<form action="{{ route('entires.submit') }}" method="POST" enctype="multipart/form-data" class="mx-auto pt-1">
    @csrf
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Upload file (Max Size: 2MB)</label>
        <input type="file" name="file" class="form-control-file" required>
    </div>
    <button type="submit" class="btn btn-primary btn-block">Submit</button>
</form>
<h2 class="text-center pt-5">Entires List</h2>
<hr>
<table id="entires" class="table table-striped table-bordered mx-auto pt-5" style="width:100%;max-width:700px;">
    <thead>
        <tr>
            <th>SN</th>
            <th>Email</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>
    <tbody>
        @foreach($entires as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->email }}</td>
            <td class="text-center">
                <a href="{{ route('edit') . '?id=' . $item->id }}">
                    <button type="button" class="btn btn-primary">Edit</button>
                </a>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger" onclick="deleteEntry('{{ $item->id }}')">Delete</button>
            </td>
        </tr>
        @endforeach
    </tbody>
    </thead>
</table>
<h2 class="text-center pt-5">Change Log</h2>
<hr>
<table id="log" class="table table-striped table-bordered mx-auto pt-5 mb-5" style="width:100%;max-width:700px;">
    <thead>
        <tr>
            <th>SN</th>
            <th>Email</th>
            <th class="text-center">Action</th>
            <th class="text-center">IP</th>
            <th class="text-center">Timestamp</th>
        </tr>
    <tbody>
        @foreach($log as $key => $item)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $item->email }}</td>
            <td class="text-center">
                {{ $item->action }}
            </td>
            <td>
                {{ $item->ip }}
            </td>
            <td class="text-center">
                {{ date('d M Y h:i:s A', strtotime($item->updated_at)) }}
            </td>
        </tr>
        @endforeach
    </tbody>
    </thead>
</table>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#entires').DataTable();
        $('#log').DataTable();
    });

    function deleteEntry(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                Swal.fire({
                    title: 'Deleting Entry!',
                    html: 'Please do not close the browser.',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('entires.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function(result) {
                        if (result.error) {
                            Swal.fire({
                                position: 'center',
                                icon: 'danger',
                                title: result.message,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                timerProgressBar: true,
                                timer: 1500
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            })
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: result.message,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                timerProgressBar: true,
                                timer: 1500
                            }).then((result) => {
                                /* Read more about handling dismissals below */
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            })
                        }
                    }
                });
            }
        })
    }
</script>
@endsection