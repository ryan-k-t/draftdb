<div class="form-group row align-items-center" :class="{'has-danger': errors.has('seasonal_player_id'), 'has-success': fields.seasonal_player_id && fields.seasonal_player_id.valid }">
    <label for="seasonal_player_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking.columns.seasonal_player_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.seasonal_player_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('seasonal_player_id'), 'form-control-success': fields.seasonal_player_id && fields.seasonal_player_id.valid}" id="seasonal_player_id" name="seasonal_player_id" placeholder="{{ trans('admin.ranking.columns.seasonal_player_id') }}">
        <div v-if="errors.has('seasonal_player_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('seasonal_player_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('ranking_instance_id'), 'has-success': fields.ranking_instance_id && fields.ranking_instance_id.valid }">
    <label for="ranking_instance_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking.columns.ranking_instance_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ranking_instance_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ranking_instance_id'), 'form-control-success': fields.ranking_instance_id && fields.ranking_instance_id.valid}" id="ranking_instance_id" name="ranking_instance_id" placeholder="{{ trans('admin.ranking.columns.ranking_instance_id') }}">
        <div v-if="errors.has('ranking_instance_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ranking_instance_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('rank'), 'has-success': fields.rank && fields.rank.valid }">
    <label for="rank" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking.columns.rank') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.rank" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('rank'), 'form-control-success': fields.rank && fields.rank.valid}" id="rank" name="rank" placeholder="{{ trans('admin.ranking.columns.rank') }}">
        <div v-if="errors.has('rank')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('rank') }}</div>
    </div>
</div>


