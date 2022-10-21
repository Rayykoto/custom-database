@extends('layouts.backend')

@extends('components.navbar')

@section('content')

@include('alert')

    <div class="card">

        <div class="card-header">New Table</div>

        <div class="card-body">

            <form action="{{ route('master.tables.create') }}" method="post">

            @csrf

            <div class="form-group">

                <label for="name">Table Name</label>
                <input type="text" name="name" id="name" class="form-control">

            </div>

            <button type="submit" class="btn btn-primary mt-2">Create</button>

            </form>

        </div>

    </div>

    @endsection