<template>
    <div class="container px-0">
        <div class="row no-gutters">
            <div class="col-12">
                <h1>Seasonal Draft Player Listing</h1>
                <code>{{ currentSeason }}</code>


                <div class="row justify-content-between mb-3">
                    <div class="col">
                        Filter by Years
                    </div>
                    <div class="col">
                        <b-form-group
                            label="Filter"
                            label-for="filter-input"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    id="filter-input"
                                    v-model="filter"
                                    type="search"
                                    placeholder="Type to Search"
                                ></b-form-input>

                                <b-input-group-append>
                                    <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </div>
                </div>


                <b-table
                    striped
                    hover
                    small
                    :items="items"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :filter-included-fields="filterOn"
                    @filtered="onFiltered"
                >
                    <template #cell(name)="data">
                        {{ data.item.last_name }}, {{ data.item.first_name }}
                    </template>
                </b-table>

                <div class="row justify-content-between align-items-center">
                    <div class="col-3">
                        <b-form-group
                            label="Per page"
                            label-for="per-page-select"
                            label-cols-sm="6"
                            label-align-sm="right"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-form-select
                                id="per-page-select"
                                v-model="perPage"
                                :options="pageOptions"
                                size="sm"
                            ></b-form-select>
                        </b-form-group>
                    </div>

                    <div class="col-8">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            align="fill"
                            class="my-0"
                        ></b-pagination>
                    </div>
                </div>



            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            currentSeason : {
                required: true
            },
            seasons: {
                required: false
            },
            initialItems: {
                required: false
            }
        },
        data() {
            return {
                fields: [
                    {
                        key: 'name',
                        sortable: true
                    },
                    {
                        key: 'school',
                        sortable: true
                    },
                    {
                        key: 'bats',
                        label: 'B'
                    },
                    {
                        key: 'throws',
                        label: 'T'
                    },
                    {
                        key: 'height',
                        label: 'Ht',
                        class: 'text-right',
                        formatter: value => {
                            if( isNaN(value) ) return value;

                            const inches = 12;
                            let feet = Math.floor( value / inches );
                            return feet + "-" + (value - (feet * inches));
                        }
                    },
                    {
                        key: 'weight',
                        label: 'Wt'
                    },
                    {
                        key: 'age'
                    }
                ],
                items: [],
                totalRows: 1,
                currentPage: 1,
                perPage: 25,
                pageOptions: [10, 25, 50, 100, 250],
                filter: null,
                filterOn: [], // only needed when we limit fields
            }
        },
        mounted() {
            this.items = this.initialItems;
            // Set the initial number of items
            this.totalRows = this.items.length;
        },
        methods: {
            onFiltered(filteredItems){
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            }
        }
    }
</script>
