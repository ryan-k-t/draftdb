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
                <li><a href="https://docs.google.com/spreadsheets/d/1MrXLOukRj_7ft2OALM8np4HemcIB9IyJ40yP4bfXXcY/edit#gid=641465746" target="_blank">Mason MacRae's Draft Board</a></li>
                <li><a href="https://www.prospectslive.com/mlb-draft/2021/4/10/450-test" target="_blank">Prospects Live</a></li>
                <li><a href="https://www.perfectgame.org/Articles/View.aspx?article=19708&src=hmrep" target="_blank">Perfect Game "612"</a></li>
            </ul>
            <div class="actions"><a href="{{ url('/admin/ranking-instances/create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Add New Ranking</a></div>
        </div>
    </div>
</div>
@endsection
