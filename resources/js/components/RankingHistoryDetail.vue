<template>
    <b-card :class="progressionWarning">
        <div class="d-flex justify-content-between">
            <main>
                <div class="labels">
                    <h6 class="ranking-label" v-html="record.description"></h6>
                    <time :datetime="record.date" v-html="formatDate( record.date )" class="ranking-date"></time>
                </div>
                <div class="d-flex align-items-center">
                    <div class="ranking-score" v-html="record.rank"></div>

                    <div class="ranking-notes-indicator" v-if="record.notes">
                        <a @click="modalRequested()" title="View notes on this ranking"><b-icon icon="chat-text-fill"></b-icon></a>
                    </div>
                </div>
            </main>
            <aside>
                <ranking-progression-indicator
                    :change="progression"
                />
            </aside>
        </div>
    </b-card>
</template>

<script>
export default {
    props: {
        record: {
            required: true,
            type: Object
        },
        records: {
            required: true,
            type: Array
        }
    },
    computed: {
        progression: function(){
            let index = this.records.indexOf( this.record );
            if( this.records.length <= (index + 1) ) return "";

            let previousIndex = index + 1;
            return this.records[index].rank - this.records[previousIndex].rank;
        },
        showWarning: function(){
            if( !this.progression ) return false;
            if( this.progression > 50 ) return true;
            return false;
        },
        progressionWarning: function(){
            return this.showWarning ? "progression-warning" : null;
        }
    },
    methods: {
        formatDate( dateString ){
            let d = new Date( dateString );
            return d.toLocaleDateString( 'en-US', { timeZone: 'America/New_York' } );
        },
        modalRequested(){
            this.$emit("modal-requested", this.record);
        }
    }
}
</script>
