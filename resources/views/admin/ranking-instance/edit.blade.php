@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.ranking-instance.actions.edit', ['name' => $rankingInstance->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <ranking-instance-form
                :action="'{{ $rankingInstance->resource_url }}'"
                :data="{{ $rankingInstance->toJson() }}"
                :sources="{{ $sources->toJson() }}"
                v-cloak
                inline-template>
            
                <form 
                    class="form-horizontal form-edit" 
                    method="post" 
                    @submit.prevent="onSubmit" 
                    :action="action" 
                    novalidate
                >


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.ranking-instance.actions.edit', ['name' => $rankingInstance->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.ranking-instance.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </ranking-instance-form>

        </div>
    
</div>

@endsection