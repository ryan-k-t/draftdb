<div class="form-group row align-items-center" :class="{'has-danger': errors.has('player_id'), 'has-success': fields.player_id && fields.player_id.valid }">
    <label for="player_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.player_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.player_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('player_id'), 'form-control-success': fields.player_id && fields.player_id.valid}" id="player_id" name="player_id" placeholder="{{ trans('admin.seasonal-player.columns.player_id') }}">
        <div v-if="errors.has('player_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('player_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('season'), 'has-success': fields.season && fields.season.valid }">
    <label for="season" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.season') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-sm-8'">
        <div class="input-group input-group--custom">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input type="text" v-model="form.season" v-validate="'required'" class="form-control" :class="{'form-control-danger': errors.has('season'), 'form-control-success': fields.season && fields.season.valid}" id="season" name="season" placeholder="{{ trans('admin.seasonal-player.columns.season') }}"></input>
        </div>
        <div v-if="errors.has('season')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('season') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('school'), 'has-success': fields.school && fields.school.valid }">
    <label for="school" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.school') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.school" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('school'), 'form-control-success': fields.school && fields.school.valid}" id="school" name="school" placeholder="{{ trans('admin.seasonal-player.columns.school') }}">
        <div v-if="errors.has('school')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('school') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city'), 'has-success': fields.city && fields.city.valid }">
    <label for="city" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.city') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city'), 'form-control-success': fields.city && fields.city.valid}" id="city" name="city" placeholder="{{ trans('admin.seasonal-player.columns.city') }}">
        <div v-if="errors.has('city')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('state'), 'has-success': fields.state && fields.state.valid }">
    <label for="state" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.state') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.state" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('state'), 'form-control-success': fields.state && fields.state.valid}" id="state" name="state" placeholder="{{ trans('admin.seasonal-player.columns.state') }}">
        <div v-if="errors.has('state')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('state') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('classification_id'), 'has-success': fields.classification_id && fields.classification_id.valid }">
    <label for="classification_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.classification_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.classification_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('classification_id'), 'form-control-success': fields.classification_id && fields.classification_id.valid}" id="classification_id" name="classification_id" placeholder="{{ trans('admin.seasonal-player.columns.classification_id') }}">
        <div v-if="errors.has('classification_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('classification_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('commitment'), 'has-success': fields.commitment && fields.commitment.valid }">
    <label for="commitment" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.commitment') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.commitment" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('commitment'), 'form-control-success': fields.commitment && fields.commitment.valid}" id="commitment" name="commitment" placeholder="{{ trans('admin.seasonal-player.columns.commitment') }}">
        <div v-if="errors.has('commitment')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('commitment') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('height'), 'has-success': fields.height && fields.height.valid }">
    <label for="height" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.height') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.height" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('height'), 'form-control-success': fields.height && fields.height.valid}" id="height" name="height" placeholder="{{ trans('admin.seasonal-player.columns.height') }}">
        <div v-if="errors.has('height')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('height') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('weight'), 'has-success': fields.weight && fields.weight.valid }">
    <label for="weight" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.weight') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.weight" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('weight'), 'form-control-success': fields.weight && fields.weight.valid}" id="weight" name="weight" placeholder="{{ trans('admin.seasonal-player.columns.weight') }}">
        <div v-if="errors.has('weight')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('weight') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('bats'), 'has-success': fields.bats && fields.bats.valid }">
    <label for="bats" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.bats') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.bats" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('bats'), 'form-control-success': fields.bats && fields.bats.valid}" id="bats" name="bats" placeholder="{{ trans('admin.seasonal-player.columns.bats') }}">
        <div v-if="errors.has('bats')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('bats') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('throws'), 'has-success': fields.throws && fields.throws.valid }">
    <label for="throws" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.seasonal-player.columns.throws') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.throws" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('throws'), 'form-control-success': fields.throws && fields.throws.valid}" id="throws" name="throws" placeholder="{{ trans('admin.seasonal-player.columns.throws') }}">
        <div v-if="errors.has('throws')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('throws') }}</div>
    </div>
</div>


