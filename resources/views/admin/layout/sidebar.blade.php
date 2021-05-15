<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/sources') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.source.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/players') }}"><i class="nav-icon icon-people"></i> {{ trans('admin.player.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/positions') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.position.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/classifications') }}"><i class="nav-icon icon-book-open"></i> {{ trans('admin.classification.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/ranking-instances') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.ranking-instance.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/hand-types') }}"><i class="nav-icon fa fa-hand-paper-o"></i> {{ trans('admin.hand-type.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/seasonal-players') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.seasonal-player.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/rankings') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.ranking.title') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/seasonal-player-positions') }}"><i class="nav-icon icon-puzzle"></i> {{ trans('admin.seasonal-player-position.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
