@extends('layouts.base')

@section('body')

    <x-navbar> </x-navbar>  

    <div class="mt-4">
        @yield('content')
    </div>

@endsection