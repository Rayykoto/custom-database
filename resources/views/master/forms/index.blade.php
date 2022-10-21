@extends('layouts.backend')

@extends('components.navbar')

@section('content')

<div class="container-sm">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-md mt-3">
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Tanggal Dibuat</th>
                                <th>Tanggal Diupdate</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($forms as $index => $form )
                            <tr>

                                <td>{{ $forms->count() * ($forms->currentPage() -1) + $loop->iteration }}</td>
                                <td>{{ $form->name }}</td>
                                <td>{{ $form->description }}</td>
                                <td>{{ $form->created_at }}</td>
                                <td>{{ $form->updated_at }}</td>
                                <td>
                                    <a href="{{ route('master.forms.edit', $form->name) }}" class="btn btn-primary btn-sm">Detail</a>
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

{{ $forms->links() }}

@endsection