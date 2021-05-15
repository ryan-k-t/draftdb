<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.player.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.player.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('middle_name'), 'has-success': fields.middle_name && fields.middle_name.valid }">
    <label for="middle_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.player.columns.middle_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.middle_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('middle_name'), 'form-control-success': fields.middle_name && fields.middle_name.valid}" id="middle_name" name="middle_name" placeholder="{{ trans('admin.player.columns.middle_name') }}">
        <div v-if="errors.has('middle_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('middle_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('last_name'), 'has-success': fields.last_name && fields.last_name.valid }">
    <label for="last_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.player.columns.last_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.last_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('last_name'), 'form-control-success': fields.last_name && fields.last_name.valid}" id="last_name" name="last_name" placeholder="{{ trans('admin.player.columns.last_name') }}">
        <div v-if="errors.has('last_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('last_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('preferred_name'), 'has-success': fields.preferred_name && fields.preferred_name.valid }">
    <label for="preferred_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.player.columns.preferred_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.preferred_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('preferred_name'), 'form-control-success': fields.preferred_name && fields.preferred_name.valid}" id="preferred_name" name="preferred_name" placeholder="{{ trans('admin.player.columns.preferred_name') }}">
        <div v-if="errors.has('preferred_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('preferred_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('date_of_birth'), 'has-success': fields.date_of_birth && fields.date_of_birth.valid }">
    <label for="date_of_birth" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.player.columns.date_of_birth') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <datetime v-model="form.date_of_birth" :config="datePickerConfig" v-validate="'date_format:yyyy-MM-dd HH:mm:ss'" class="flatpickr" :class="{'form-control-danger': errors.has('date_of_birth'), 'form-control-success': fields.date_of_birth && fields.date_of_birth.valid}" id="date_of_birth" name="date_of_birth" placeholder="{{ trans('brackets/admin-ui::admin.forms.select_a_date') }}"></datetime>
        </div>
        <div v-if="errors.has('date_of_birth')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('date_of_birth') }}</div>
    </div>
</div>


