<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('source_id'), 'has-success': this.fields.source_id && this.fields.source_id.valid }">
    <label for="source_id"
           class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking-instance.columns.source_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">

        <multiselect
            v-model="form.source"
            :options="sources"
            :multiple="false"
            track-by="id"
            label="name"
            tag-placeholder="{{ __('Select Source') }}"
            placeholder="{{ __('Source') }}">
        </multiselect>

        <div v-if="errors.has('source_id')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('source_id') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('season'), 'has-success': fields.season && fields.season.valid }">
    <label for="season" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking-instance.columns.season') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <input type="number" v-model="form.season" v-validate="'required|date_format:yyyy'" class="form-control" :class="{'form-control-danger': errors.has('season'), 'form-control-success': fields.season && fields.season.valid}" id="season" name="season" placeholder="{{ trans('admin.ranking-instance.columns.season') }}">
        <div v-if="errors.has('season')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('season') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date'), 'has-success': fields.date && fields.date.valid }">
    <label for="date" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking-instance.columns.date') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date" :config="datePickerConfig" v-validate="'required|date_format:yyyy-MM-dd'" class="flatpickr" :class="{'form-control-danger': errors.has('date'), 'form-control-success': fields.date && fields.date.valid}" id="date" name="date" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date') }}</div>
    </div>
</div>


