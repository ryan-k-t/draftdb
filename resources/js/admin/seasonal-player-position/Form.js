import AppForm from '../app-components/Form/AppForm';

Vue.component('seasonal-player-position-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                seasonal_player_id:  '' ,
                position_id:  '' ,
                
            }
        }
    }

});