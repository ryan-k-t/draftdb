import AppForm from '../app-components/Form/AppForm';

Vue.component('ranking-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                seasonal_player_id:  '' ,
                ranking_instance_id:  '' ,
                rank:  '' ,
                
            }
        }
    }

});