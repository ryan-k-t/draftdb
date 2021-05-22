@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">

            <seasonal-player-listing
                :current-season="{{ $currentSeason }}"
                :seasons="{{ $seasons->toJson() }}"
                :initial-items="{{ $data->toJson() }}"
            ></seasonal-player-listing>

        </div>
        <div class="col-2">
            <a href="{{ url('/admin/ranking-instances/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Add New Ranking</a>
            <a href="#">Other stuff</a>
        </div>
    </div>
</div>
@endsection
