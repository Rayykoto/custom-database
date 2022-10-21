@extends('layouts.backend')

@extends('components.navbar')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-md mt-3">
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">

                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>

                        </thead class="thead-dark">

                        <tbody>

                            @foreach ($users as $index => $user )
                            <tr>

                                <td>{{ $users->count() * ($users->currentPage() -1) + $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                </td>

                            </tr>

                            @endforeach

                        </tbody>
                </div>
            </div>
        </div>
    </div>
</div>

</table>

{{ $users->links() }}

@endsection