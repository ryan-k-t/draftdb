import AppForm from '../app-components/Form/AppForm';

Vue.component('position-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});