import AppForm from '../app-components/Form/AppForm';

Vue.component('ranking-instance-form', {
    mixins: [AppForm],
    props: [
        'sources'
    ],
    data: function() {
        return {
            form: {
                source:  '' ,
                season:  '' ,
                date:  '' ,                
            },
            mediaCollections: ['import_file']
        }
    }

});