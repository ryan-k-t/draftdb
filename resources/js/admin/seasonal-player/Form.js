import AppForm from '../app-components/Form/AppForm';

Vue.component('seasonal-player-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                player_id:  '' ,
                season:  '' ,
                school:  '' ,
                city:  '' ,
                state:  '' ,
                classification_id:  '' ,
                commitment:  '' ,
                height:  '' ,
                weight:  '' ,
                bats:  '' ,
                throws:  '' ,
                
            }
        }
    }

});