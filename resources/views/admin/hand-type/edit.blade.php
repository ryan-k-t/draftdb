@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.hand-type.actions.edit', ['name' => $handType->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <hand-type-form
                :action="'{{ $handType->resource_url }}'"
                :data="{{ $handType->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.hand-type.actions.edit', ['name' => $handType->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.hand-type.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </hand-type-form>

        </div>
    
</div>

@endsection