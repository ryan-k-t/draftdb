import AppListing from '../app-components/Listing/AppListing';

Vue.component('ranking-instance-listing', {
    mixins: [AppListing],
    data: function() {
        return {
            showSourcesFilter: false,
            sourcesMultiselect: {},
    
            filters: {
                sources: [],
            },
        }
    },
    watch: {
        showSourcesFilter: function(newVal, oldVal){
            this.sourcesMultiselect = [];
        },
        sourcesMultiselect: function(newVal, oldVal){
            this.filters.sources = newVal.map(function(object) { return object['key']; });
            this.filter('sources', this.filters.sources);
        }
    }
});