import AppForm from '../app-components/Form/AppForm';

Vue.component('ranking-form', {
    mixins: [AppForm],
    props: [
        'ranking-instances',
        'seasonal-players'
    ],
    computed: {
        sortedSeasonalPlayers: function(){
            return this.seasonalPlayers.sort( (a, b) => (a.player.last_name > b.player.last_name) ? 1 : (a.player.last_name === b.player.last_name) ? ((a.player.first_name > b.player.first_name) ? 1 : -1) : -1)
        }
    },
    data: function() {
        return {
            form: {
                seasonal_player_id:  '' ,
                ranking_instance_id:  '' ,
                rank:  '' ,
                
            }
        }
    },
    methods: {
        playerName: function(object){
            return object.player.last_name + ", " + object.player.first_name;
        }
    }

});