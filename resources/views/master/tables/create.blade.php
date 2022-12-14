@extends('layouts.backend')

@extends('components.navbar')

@section('content')

@include('alert')

    <div class="card">

        <div class="card-header">New Table/Forms</div>

        <div class="card-body">

            <form action="{{ route('master.tables.create') }}" method="post">

            @csrf

            <div class="form-group">

                <label for="name">Select Database</label>
                <select class="form-control" id="table_group" name="table_group">
                    <option value="">Select Databases</option>
                    @foreach($group as $index => $g)
                        <option value="{{ $g->name }}">{{ $g->description }}</option>
                    @endforeach
                </select>

            </div>

            <br>

            <div class="form-group">

                <label for="name">Table Name</label>
                <input type="text" name="name" id="name" class="form-control">

            </div>

            <button type="submit" class="btn btn-primary mt-2">Create</button>

            </form>

        </div>

    </div>

    @endsection