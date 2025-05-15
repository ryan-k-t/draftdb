<template>
    <div class="seasonal-player-profile">
        <section class="player-profile meta-listing">
            <h3>Player Profile</h3>
            <div class="meta-listing-items">
                <div class="meta-info">
                    <div class="label">Pos.</div>
                    <div class="value">{{ player.positions }}</div>
                </div>
                <div class="meta-info" v-if="player.classification">
                    <div class="label">Class.</div>
                    <div class="value">{{ player.classification }}</div>
                </div>
                <div class="meta-info" v-if="player.commitment && player.classification != '4yr'">
                    <div class="label">Commitment.</div>
                    <div class="value">{{ player.commitment }}</div>
                </div>
                <div class="meta-info">
                    <div class="label">School</div>
                    <div class="value">{{ player.school }}</div>
                </div>
                <div class="meta-info" v-if="player.age">
                    <div class="label">Age</div>
                    <div class="value">{{ player.age }}</div>
                </div>
                <div class="meta-info" v-if="player.height">
                    <div class="label">Height</div>
                    <div class="value">{{ impericalHeight( player.height ) }}</div>
                </div>
                <div class="meta-info" v-if="player.weight">
                    <div class="label">Weight</div>
                    <div class="value">{{ player.weight }}</div>
                </div>
                <div class="meta-info" v-if="player.bats || player.throws">
                    <div class="label">B/T</div>
                    <div class="value">{{ player.bats }}/{{ player.throws}}</div>
                </div>
            </div>
        </section>

        <section class="meta-listing draft-summary" v-if="player.selection">
            <h3>Draft Information</h3>
            <div class="meta-listing-items">
                <div class="meta-info">
                    <div class="label">Rnd.</div>
                    <div class="value">{{ player.round }}</div>
                </div>
                <div class="meta-info">
                    <div class="label">Sel.</div>
                    <div class="value">{{ player.selection }}</div>
                </div>
                <div class="meta-info">
                    <div class="label">Team</div>
                    <div class="value">{{ player.team }}</div>
                </div>
                <div class="meta-info">
                    <div class="label">Signed</div>
                    <div class="value">{{ player.signed ? 'Y' : 'N'}}</div>
                </div>
            </div>
        </section>

        <section class="meta-listing rankings-summary">
            <h3>Rankings</h3>
            <div class="meta-listing-items">
                <div class="meta-info">
                    <div class="label">Count</div>
                    <div class="value">{{ player.rankings_count }}</div>
                </div>
                <div class="meta-info">
                    <div class="label">Average</div>
                    <div class="value">{{ player.rankings_average }}</div>
                </div>
                <div class="meta-info">
                    <div class="label">Mean</div>
                    <div class="value">{{ player.rankings_mean }}</div>
                </div>
            </div>

            <section class="seasonal-player-ranking-histories pt-4">
                <div class="seasonal-player-ranking-history" v-for="source in player.rankings" :key="source.source_id">
                    <h5 v-html="source.source_name"></h5>
                    <ranking-history-detail
                        v-for="ranking in source.history"
                        :key="ranking.date"
                        :record="ranking"
                        :records="source.history"
                        v-on:modal-requested="triggerModal"
                    >
                    </ranking-history-detail>

                </div>
            </section>
        </section>

        <b-modal
            :id="modalId"
            :title="playerName + ' Draft Notes'"
            ok-only
            ok-title="Close"
        >
            <div class="ranking-notes-modal-header">
                <h3>
                    <span v-html="selectedRanking.source"></span>: <span v-html="selectedRanking.description"></span>
                </h3>
                <time :datetime="selectedRanking.date" v-html="selectedRankingDateFormatted"></time>
            </div>
            <div class="notes" v-html="selectedRanking.notes"></div>
        </b-modal>
    </div>
</template>
<script>
export default {
    props: {
        player: {
            required: true,
        }
    },
    data() {
        return {
            selectedRanking: {},
            modalId: "ranking-notes-modal"
        }
    },
    computed: {
        playerName: function(){
            return this.player.first_name + ' ' + this.player.last_name;
        },
        selectedRankingDateFormatted: function(){
            if( !this.selectedRanking ) return "";

            return this.formatDate( this.selectedRanking.date );
        }
    },
    methods: {
        impericalHeight(value){
            if( isNaN(value) ) return value;

            const inches = 12;
            let feet = Math.floor( value / inches );
            return feet + "-" + (value - (feet * inches));
        },
        triggerModal(record){
            this.selectedRanking = record;
            this.$bvModal.show( this.modalId );
        },
        formatDate( dateString ){
            let d = new Date( dateString );
            return d.toLocaleDateString( 'en-US', { timeZone: 'America/New_York' } );
        },
    }
}
</script>