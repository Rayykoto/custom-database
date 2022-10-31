@extends('layouts.base')

@section('body')

        <div class="container-fluid py-3">

            <div class="row">

                <div class="col-md-3">
                    <x-sidebar> </x-sidebar>
                </div>

                <div class="col-md-9 bg-light">

                    @yield('content')

                </div>

            </div>

        </div>

@endsection