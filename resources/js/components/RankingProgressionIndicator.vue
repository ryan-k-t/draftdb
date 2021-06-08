<template>
    <div class="progression-indicators">
        <template v-if="isNumeric">
            <div class="progression-indicator">
                <b-icon :icon="icon" :variant="variant"></b-icon>
            </div>
            <div class="progression-indicator" v-b-tooltip.hover title="Ranking has dropped 50 or more slots since previous ranking" v-if="this.isNumeric && this.change > 50">
                <b-iconstack>
                    <b-icon stacked icon="triangle-fill" variant="warning"></b-icon>
                    <b-icon stacked icon="exclamation"></b-icon>
                </b-iconstack>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        change: {
            required: true,
            type: [String, Number]
        }
    },
    computed: {
        variant: function(){
            if( !this.isNumeric ) return "";
            if( this.change < 0 ) return "success";
            if( this.change > 0 ) return "danger";
            return "secondary";
        },
        isNumeric: function(){
            return !isNaN(this.change);
        },
        icon: function(){
            if( !this.isNumeric ) return "";
            if( this.change < 0 ) return "arrow-up-circle-fill";
            if( this.change > 0 ) return "arrow-down-circle-fill";
            return "secondary";
        }
    }
}
</script>
