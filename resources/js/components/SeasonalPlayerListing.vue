<template>
    <div class="container px-0">
        <div class="row no-gutters">
            <div class="col-12">
                <div class="row justify-content-between align-items-center">
                    <div class="col d-flex align-items-center">
                        <h1>{{ season }} Draft Player Analysis</h1>
                        <b-button size="sm" v-on:click="summarySidebarShown = !summarySidebarShown" variant="outline-secondary mx-3">{{ summarySidebarShown ? 'Hide' : 'Show' }} Summary</b-button>
                    </div>

                    <b-form-group
                        label="Year"
                        label-for="season-filter"
                        label-size="sm"
                        label-cols="4"
                        label-align="right"
                        class="mb-0 col-3"
                    >
                        <b-form-select name="season-filter" v-model="season" :options="seasonOptions" size="sm" />
                    </b-form-group>
                </div>

                <div class="font-weight-bold text-uppercase">Filters:</div>
                <div class="row mb-3 justify-content-between">
                    <div class="col">
                        <b-form-group
                            label="Position"
                            label-for="position-filter"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-form-select name="position-filter" v-model="position" :options="positionOptions" size="sm" />
                        </b-form-group>
                    </div>
                    <div class="col">
                        <b-form-group
                            label="Class"
                            label-for="class-filter"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-form-select name="class-filter" v-model="classification" :options="classificationOptions" size="sm" />
                        </b-form-group>
                    </div>
                    <div class="col">
                        <b-form-group
                            label="Search Name or School"
                            label-for="filter-input"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    id="filter-input"
                                    v-model="searchText"
                                    type="search"
                                    placeholder="Type to Search"
                                ></b-form-input>

                                <b-input-group-append>
                                    <b-button :disabled="!searchText" @click="searchText = ''">Clear</b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </div>
                    <div class="col">
                        <b-form-group
                            label="Draft Status"
                            label-for="draft-filter"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-form-select name="draft-filter" v-model="draftStatus" :options="draftOptions" size="sm" />
                        </b-form-group>
                    </div>
                    <div class="col" v-if="draftStatus === 'drafted'">
                        <b-form-group
                            label="Signing Status"
                            label-for="signing-filter"
                            label-size="sm"
                            class="mb-0"
                        >
                            <b-form-select name="signing-filter" v-model="signingStatus" :options="signingOptions" size="sm" />
                        </b-form-group>
                    </div>
                </div>


                <div class="row justify-content-between align-items-center">
                    <div class="col col-sm-2">
                        <b-form-group
                            label="Per page"
                            label-for="per-page-select"
                            label-cols-sm="4"
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
                    <div class="col text-right">
                        {{ unfilteredRowCount.toLocaleString() }} total record{{unfilteredRowCount === 1 ? '' : 's'}}
                    </div>
                </div>

                <b-table
                    striped
                    hover
                    small
                    :busy="isBusy"
                    :items="items"
                    :fields="fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :filter-function="filterTable"
                    @filtered="onFiltered"
                    class="mt-3 mb-5"
                >
                    <template #cell(name)="data">
                        <a href="#" @click.prevent="displayRecord(data.item)">{{ data.item.last_name }}, {{ data.item.first_name }}</a>
                    </template>
                </b-table>

                <div class="row mb-2 justify-content-between align-items-center" v-if="totalRows > 0">
                    <div class="col text-center">
                        Showing {{ paginationDisplaying }} of {{ totalRows.toLocaleString() }} record{{ totalRows === 1 ? '' : 's' }}
                    </div>
                </div>

                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            align="center"
                            class="my-0"
                        ></b-pagination>
                    </div>
                </div>

                <b-sidebar
                    id="summary-sidebar"
                    left
                    shadow
                    v-model="summarySidebarShown"
                    :aria-expanded="summarySidebarShown ? 'true' : 'false'"
                    class="summary-sidebar"
                    title="Summary Analysis"
                >
                    <ranking-summaries :records="items" />
                </b-sidebar>

                <b-sidebar
                  id="sidebar-1"
                  :title="selectedRecord.first_name + ' ' + selectedRecord.last_name"
                  shadow
                  right
                  v-model="playerSidebarShown"
                  :aria-expanded="playerSidebarShown ? 'true' : 'false'"
                  class="player-sidebar"
                >
                    <div class="container py-4">
                        <seasonal-player-profile
                            v-if="selectedRecord"
                            :player="selectedRecord"
                        />
                    </div>
                </b-sidebar>
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
                playerSidebarShown: false,
                summarySidebarShown: false,
                selectedRecord: {},
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
                        key: 'positions',
                        label: 'Pos'
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
                        formatter: 'impericalHeight'
                    },
                    {
                        key: 'weight',
                        label: 'Wt',
                        formatter: value => {
                            return value == 0 ? "" : value;
                        }
                    },
                    {
                        key: 'age',
                        formatter: value => {
                            if( isNaN(value) || value === null ) return value;
                            return value.toFixed(1);
                        }
                    },
                    {
                        key: 'rankings_count',
                        label: "Rankings",
                        class: 'text-right'
                    },
                    {
                        key: 'rankings_average',
                        label: 'Average',
                        class: 'text-right',
                        sortable: true,
                        formatter: value => {
                            if( isNaN(value) || value === null ) return value;
                            return value.toFixed(2);
                        }
                    },
                    {
                        key: 'rankings_mean',
                        label: 'Mean',
                        class: 'text-right',
                        sortable: true,
                        formatter: value => {
                            if( isNaN(value) || value === null ) return value;
                            return value.toFixed(2);
                        }
                    },
                    {
                        key: 'selection',
                        label: 'Drafted',
                        class: 'text-right',
                        sortable: true
                    }
                ],
                items: [],
                season: null,
                // start filters
                classification: '',
                position: '',
                signingStatus: '',
                draftStatus: '',
                searchText: '',
                //end filters
                isBusy: false,
                unfilteredRowCount: 0,
                totalRows: 1,
                currentPage: 1,
                perPage: 25,
                pageOptions: [10, 25, 50, 100, 250],
                filter: null,
                draftOptions: [
                    {
                        value: '',
                        text: 'All'
                    },
                    {
                        value:'drafted',
                        text: 'Drafted'
                    },
                    {
                        value: 'undrafted',
                        text: 'Undrafted'
                    }
                ],
                signingOptions: [
                    {
                        value: '',
                        text: 'All'
                    },
                    {
                        value:'signed',
                        text: 'Signed'
                    },
                    {
                        value: 'unsigned',
                        text: 'Unsigned'
                    }
                ]
            }
        },
        mounted() {
            this.items = this.initialItems;
            this.season = this.currentSeason;
            // Set the initial number of items
            this.totalRows = this.items.length;
            this.unfilteredRowCount = this.totalRows;
        },
        watch: {
            season: function(newVal, oldVal){
                if (!oldVal) return;
                this.fetchData();
                this.filter = null;
                this.searchText = '';
                this.position = '';
                this.classification = '';
                this.signingStatus = '';
                this.draftStatus = '';
                this.currentPage = 1;
            },
            searchText: function(newVal) {
                if (newVal) {
                    if (!this.filter) {
                        this.filter = {
                            searchText: newVal,
                            position: '',
                            classification: '',
                            signingStatus: '',
                            draftStatus: '',
                        }
                    } else {
                        this.filter.searchText = newVal;
                    }

                    return;
                }

                if (this.filter) {
                    this.filter.searchText = '';
                }
            },
            position: function(newVal) {
                if (newVal) {
                    if (!this.filter) {
                        this.filter = {
                            searchText: '',
                            position: newVal,
                            classification: '',
                            draftStatus: '',
                            signingStatus: ''
                        }
                    } else {
                        this.filter.position = newVal;
                    }

                    return;
                }

                if (this.filter) {
                    this.filter.position = '';
                }
            },
            classification: function(newVal) {
                if (newVal) {
                    if (!this.filter) {
                        this.filter = {
                            searchText: '',
                            position: '',
                            classification: newVal,
                            draftStatus: '',
                            signingStatus: ''
                        }
                    } else {
                        this.filter.classification = newVal;
                    }

                    return;
                }

                if (this.filter) {
                    this.filter.classification = '';
                }
            },
            signingStatus: function(newVal) {
                if (newVal) {
                    if (!this.filter) {
                        this.filter = {
                            searchText: '',
                            position: '',
                            draftStatus: '',
                            signingStatus: newVal,
                            classification: ''
                        }
                    } else {
                        this.filter.signingStatus = newVal;
                    }

                    return;
                }

                if (this.filter) {
                    this.filter.signingStatus = '';
                }
            },
            draftStatus: function(newVal) {
                if (newVal) {
                    if (!this.filter) {
                        this.filter = {
                            searchText: '',
                            position: '',
                            signingStatus: '',
                            draftStatus: newVal,
                            classification: ''
                        }
                    } else {
                        this.filter.draftStatus = newVal;
                    }

                    return;
                }

                if (this.filter) {
                    this.filter.draftStatus = '';
                }
            }

        },
        computed: {
            paginationDisplaying() {
                if (this.totalRows === 0) {
                    return '';
                };
                if (this.totalRows === 1) {
                    return 1;
                }
                const low = (this.currentPage - 1) * this.perPage + 1;
                const high = this.currentPage * this.perPage;
                const displayHigh = Math.min(high, this.totalRows);

                return `${low.toLocaleString()} of ${displayHigh.toLocaleString()}`;
            },
            classifications() {
                return this.initialItems.reduce((current, listItem) => {
                    if (!current.hasOwnProperty(listItem.classification)){
                        current[listItem.classification] = 0;
                    }

                    current[listItem.classification] += 1;

                    return current;
                }, {});
            },
            classificationOptions() {
                const options = [
                    {
                        value: '',
                        text: 'All'
                    }
                ];
                for(const key in this.classifications) {
                    options.push({
                        value: key,
                        text: key
                    });
                }
                return options;
            },
            positions() {
                return this.initialItems.reduce((current, listItem) => {
                    const posList = listItem.positions.split('/');
                    posList.forEach((pos) => {
                        pos = pos.trim();
                        if (!current.hasOwnProperty(pos)){
                            current[pos] = 0;
                        }

                        current[pos] += 1;
                    });

                    return current;
                }, {});
            },
            positionOptions() {
                const options = [
                    {
                        value: '',
                        text: 'All'
                    }
                ];
                for(const key in this.positions) {
                    options.push({
                        value: key,
                        text: key
                    });
                }

                options.sort((a, b) => {
                    if (a.value < b.value) {
                        return -1;
                    }
                    if (a.value > b.value) {
                        return 1;
                    }
                    return 0;
                });

                return options;
            },
            seasonOptions() {
                return this.seasons.map(function(i) {
                    return {
                        value: i,
                        text: i
                    };
                }, []);
            },
        },
        methods: {
            filterTable(row, filters) {
                if (filters.searchText) {
                    const fields = ['last_name', 'first_name', 'school'];
                    const regx = new RegExp(filters.searchText, 'i');
                    const passes = fields.some(field => {
                        return regx.test(row[field]);
                    });

                    if (!passes) {
                        return false;
                    }
                }

                if (filters.position) {
                    const rawPlayerPositions = row.positions.split('/');
                    const playerPositions = rawPlayerPositions.map(item => item.trim());
                    if (playerPositions.indexOf(filters.position) === -1){
                        return false;
                    }
                }
                
                if (filters.classification) {
                    if (row.classification !== filters.classification) {
                        return false;
                    }
                }

                if (filters.draftStatus) {
                    if (filters.draftStatus === 'drafted') {
                        if (!row.selection) {
                            return false;
                        }

                        if (filters.signingStatus) {
                            if (filters.signingStatus === 'signed' && row.signed !== 1) {
                                return false;
                            }
                            if (filters.signingStatus === 'unsigned' && row.signed !== 0) {
                                return false;
                            }
                        }

                    }

                    if (filters.draftStatus === 'undrafted') {
                        if (row.selection) {
                            return false;
                        }
                    }
                }

                return true;
            },
            onFiltered(filteredItems){
                this.totalRows = filteredItems.length;
                this.currentPage = 1;
            },
            displayRecord(record){
                this.selectedRecord = record;
                if( !this.playerSidebarShown ) this.playerSidebarShown = true;
            },
            impericalHeight(value){
                if( isNaN(value) || !value ) return "";

                const inches = 12;
                let feet = Math.floor( value / inches );
                return feet + "-" + (value - (feet * inches));
            },
            fetchData(){
                this.isBusy = true;
                if (this.season === this.currentSeason){
                    this.items = this.initialItems;
                    this.totalRows = this.items.length;
                    this.unfilteredRowCount = this.totalRows;
                    this.isBusy = false;
                    return;
                }

                axios.post('/api/rankings', {
                    season: this.season
                })
                .then((response) => {
                    if(response.status == 200){
                        if(!response.data)
                        {
                            return;
                        }

                        this.items = response.data.records;
                        this.totalRows = this.items.length;

                    } else {
                        console.log(response.status+" : "+response.statusText);
                        return;
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.isBusy = false;
                });
            },

        }
    }
</script>
