import AppForm from '../app-components/Form/AppForm';

Vue.component('classification-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});