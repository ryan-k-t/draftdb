import AppForm from '../app-components/Form/AppForm';

Vue.component('hand-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});