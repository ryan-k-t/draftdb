<div class="form-group row align-items-center" :class="{'has-danger': errors.has('seasonal_player_id'), 'has-success': fields.seasonal_player_id && fields.seasonal_player_id.valid }">
    <label for="seasonal_player_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking.columns.seasonal_player_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            id="seasonal_player_id"
            name="seasonal_player_id"
            v-model="form.seasonal_player"
            :options="sortedSeasonalPlayers"
            :multiple="false"
            :clear-on-select="false"
            :allow-empty="false"
            track-by="id"
            label="id"
            :custom-label="playerName"
            tag-placeholder="{{ __('Select Seasonal Player') }}"
            placeholder="{{ __('Seasonal Player') }}"
            :class="{'form-control-danger': errors.has('seasonal_player_id'), 'form-control-success': fields.seasonal_player_id && fields.seasonal_player_id.valid}"
        >
        </multiselect>

        <div v-if="errors.has('seasonal_player_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('seasonal_player_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center"
    :class="{'has-danger': errors.has('ranking_instance_id'), 'has-success': fields.ranking_instance_id && fields.ranking_instance_id.valid }">
    <label for="ranking_instance_id" 
           class="col-form-label text-md-right"
           :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ranking.columns.ranking_instance_id') }}
    </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <multiselect
            id="ranking_instance_id"
            name="ranking_instance"
            v-model="form.ranking_instance"
            :options="rankingInstances"
            :multiple="false"
            track-by="id"
            tag-placeholder="{{ __('Select Ranking Instance') }}"
            placeholder="{{ __('Ranking Instance') }}"
            :class="{'form-control-danger': errors.has('ranking_instance_id'), 'form-control-success': fields.ranking_instance_id && fields.ranking_instance_id.valid}"
        >
            <template slot="singleLabel" slot-scope="{ option }">@{{ option.source.name }} : @{{ option.description }}</template>
            <template slot="option" slot-scope="{ option }">@{{ option.source.name }} : @{{ option.description }}</template>
        </multiselect>

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


