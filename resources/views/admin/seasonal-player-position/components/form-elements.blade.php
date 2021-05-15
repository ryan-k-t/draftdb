<div class="form-group row align-items-center" :class="{'has-danger': errors.has('seasonal_player_id'), 'has-success': fields.seasonal_player_id && fields.seasonal_player_id.valid }">
    <label for="seasonal_player_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player-position.columns.seasonal_player_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.seasonal_player_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('seasonal_player_id'), 'form-control-success': fields.seasonal_player_id && fields.seasonal_player_id.valid}" id="seasonal_player_id" name="seasonal_player_id" placeholder="{{ trans('admin.seasonal-player-position.columns.seasonal_player_id') }}">
        <div v-if="errors.has('seasonal_player_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('seasonal_player_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('position_id'), 'has-success': fields.position_id && fields.position_id.valid }">
    <label for="position_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player-position.columns.position_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.position_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('position_id'), 'form-control-success': fields.position_id && fields.position_id.valid}" id="position_id" name="position_id" placeholder="{{ trans('admin.seasonal-player-position.columns.position_id') }}">
        <div v-if="errors.has('position_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('position_id') }}</div>
    </div>
</div>


