<template>
    <b-card no-body class="ranking-summary-breakdown-tiers mt-3" role="tablist">
        <b-card-header header-tag="header" class="p-0" role="tab">
            <div
                :aria-expanded="open ? 'true' : 'false'"
                :aria-controls="'collapse-'+name"
                @click="open = !open"
                class="d-flex justify-content-between align-items-center font-weight-bold px-3 py-2"
                style="cursor:pointer"
            >
                By Tier
                <b-icon :icon="open ? 'dash-square' : 'plus-square'" />
            </div>
        </b-card-header>
        <b-collapse :id="'collapse-'+name" v-model="open" role="tabpanel">
            <b-card-body class="d-flex flex-column px-0" style="gap: 1rem; font-size: 13px;">
                <div v-for="(t, tier) in tiers" :key="tier">
                    <p class="m-0 px-3 pb-1 font-weight-bold border-bottom border-primary" style="font-size: 1.2em">Rankings {{ t.startPos }}-{{ t.endPos }}</p>
                    <div class="meta-listing-items px-3">
                        <meta-info
                            label="Rankings"
                            :value="t.rankings"
                        />

                        <meta-info
                            label="Drafted"
                            :value="t.drafted"
                        />

                        <meta-info
                            label="% Drafted"
                            :value="calcPercentage(t.drafted, t.rankings)"
                        />

                        <meta-info
                            label="Signed"
                            :value="t.signed"
                        />

                        <meta-info
                            label="% Signed"
                            :value="calcPercentage(t.signed, t.drafted)"
                        />

                    </div>
                </div>
            </b-card-body>
        </b-collapse>
    </b-card>
</template>

<script>
import { percentage } from '../utils/calculations'

export default {
    props: {
        name: {
            type: String,
            required: true
        },
        tiers: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            open: false
        }
    },
    methods: {
        calcPercentage(dividend, divisor) {
            return percentage(dividend, divisor);
        }
    }
}
</script>
