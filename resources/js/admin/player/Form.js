import AppForm from '../app-components/Form/AppForm';

Vue.component('player-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                first_name:  '' ,
                middle_name:  '' ,
                last_name:  '' ,
                preferred_name:  '' ,
                date_of_birth:  '' ,
                
            }
        }
    }

});