<template>
    <div class="container py-4">
        <p>{{ totalPlayers }} total rankings</p>
        <div
            v-for="(breakdown, key) in breakdowns"
            :key="key"
            class="meta-listing"
        >
            <h3>{{ key }}</h3>
            <div class="meta-listing-items">
                <meta-info
                    label="Rankings"
                    :value="breakdown.players.length"
                />

                <meta-info
                    label="% of Total Rankings"
                    :value="calcPercentage(breakdown.players.length, totalPlayers)"
                />
            </div>
            <div class="meta-listing-items">
                <meta-info
                    label="Drafted"
                    :value="breakdown.drafted"
                />

                <meta-info
                    label="% Drafted"
                    :value="calcPercentage(breakdown.drafted, breakdown.players.length)"
                />
            </div>
            <div class="meta-listing-items">
                <meta-info
                    label="Signed"
                    :value="breakdown.signed"
                />

                <meta-info
                    label="% Signed"
                    :value="calcPercentage(breakdown.signed, breakdown.drafted)"
                />

            </div>

            <ranking-summary-breakdown-tiers
                :name="key"
                :tiers="breakdown.tiers"
            />
        </div>
    </div>

</template>
<script>
import { percentage } from '../utils/calculations'
export default {
    props: {
        records: {
            required: true,
            type: Array
        },
        numberOfTiers: {
            type: Number,
            default: 3
        },
        recordsPerTier: {
            type: Number,
            default: 100
        }
    },
    computed: {
        totalPlayers: function() {
            return this.records.length;
        },
        classifications() {
            const list = this.records.reduce((accumulator, ranking) => {
                if (ranking.classification) {
                    if (accumulator.indexOf(ranking.classification) === -1) {
                        accumulator.push(ranking.classification);
                    }
                }
                return accumulator;
            }, []);

            list.sort();

            return list;
        },
        tiers() {
            const result = [];
            for(let i = 1; i <= this.numberOfTiers; i++) {
                const start = i === 1 ? i : ((i - 1) * this.recordsPerTier) + 1;
                if (start > this.records.length) {
                    continue;
                }
                const end = i * this.recordsPerTier;
                result.push({
                    tier: i,
                    startPos: start,
                    endPos: Math.min(end, this.records.length),
                });

                // classifications:
                // total / drafted / signed
            }

            return result;
        },
        breakdowns() {
            return this.records.reduce((accumulator, ranking) => {
                if (!accumulator.hasOwnProperty(ranking.classification)){
                    accumulator[ranking.classification] = {
                        players: [],
                        drafted: 0,
                        signed: 0,
                        tiers: {}
                    }
                    this.tiers.forEach((tier) => {
                        accumulator[ranking.classification].tiers[tier.tier] = {
                            rankings: 0,
                            drafted: 0,
                            signed: 0,
                            startPos: tier.startPos,
                            endPos: tier.endPos
                        }
                    });
                }

                accumulator[ranking.classification].players.push(ranking);
                if (ranking.selection) {
                    accumulator[ranking.classification].drafted += 1;
                    if (ranking.signed) {
                        accumulator[ranking.classification].signed += 1;
                    }
                }

                const tier = this.tiers.find((t) => {
                    if (ranking.rankings_mean < t.startPos ) {
                        return false;
                    }
                    if (ranking.rankings_mean > t.endPos) {
                        return false;
                    }
                    return true;
                });

                if (!tier) {
                    return accumulator;
                }

                accumulator[ranking.classification].tiers[tier.tier].rankings += 1;
                if (ranking.selection) {
                    accumulator[ranking.classification].tiers[tier.tier].drafted += 1;
                    if (ranking.signed) {
                        accumulator[ranking.classification].tiers[tier.tier].signed += 1;
                    }
                }

                return accumulator;
            }, {});
        }
    },
    methods: {
        calcPercentage(dividend, divisor) {
            return percentage(dividend, divisor);
        }
    }
    
}
</script>