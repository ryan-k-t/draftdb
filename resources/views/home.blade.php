@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">

            <div class="title m-b-md">
                Laravel
            </div>

            <example-component></example-component>



        </div>
        <div class="col-2">
            <a href="{{ url('/admin/ranking-instances/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Add New Ranking</a>
            <a href="#">Other stuff</a>
        </div>
    </div>
</div>
@endsection
