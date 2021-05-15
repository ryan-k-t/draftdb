@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.seasonal-player-position.actions.edit', ['name' => $seasonalPlayerPosition->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <seasonal-player-position-form
                :action="'{{ $seasonalPlayerPosition->resource_url }}'"
                :data="{{ $seasonalPlayerPosition->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.seasonal-player-position.actions.edit', ['name' => $seasonalPlayerPosition->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.seasonal-player-position.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </seasonal-player-position-form>

        </div>
    
</div>

@endsection