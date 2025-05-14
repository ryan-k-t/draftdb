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
        <div class="col-2 sidebar">
            <h3 class="sidebar-title">Other Items of Interest</h3>
            <ul class="list-unstyled other-items">
                <li><a href="https://www.perfectgame.org/Articles/View.aspx?article=19708&src=hmrep" target="_blank">Perfect Game "612"</a></li>
                <li><a href="https://www.mlb.com/draft/tracker/2024" target="_blank">2024 Draft Tracker</a></li>
            </ul>
            <div class="actions"><a href="{{ url('/admin/ranking-instances/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Add New Ranking</a></div>
        </div>
    </div>
</div>
@endsection
