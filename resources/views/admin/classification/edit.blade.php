@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.classification.actions.edit', ['name' => $classification->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <classification-form
                :action="'{{ $classification->resource_url }}'"
                :data="{{ $classification->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.classification.actions.edit', ['name' => $classification->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.classification.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </classification-form>

        </div>
    
</div>

@endsection