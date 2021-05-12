import AppForm from '../app-components/Form/AppForm';

Vue.component('source-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                description:  '' ,
                creator_id:  '' ,
                
            }
        }
    }

});