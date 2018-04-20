<template>
    <div>
        <div class="container-fluid mb-3">
            <div class="row">
                <div class="col-4">
                    <el-input
                            placeholder="Search by seller name"
                            clearable
                            size="small"

                            v-model="searchValue">
                    </el-input>
                </div>
                <div class="col">
                    <button class="btn btn-warning btn-sm" @click="$refs.ticketsTable.clearFilter();$refs.ticketsTable.clearSort();searchValue=''">
                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                        Reset filter
                    </button>
                </div>
            </div>
        </div>
        <!-- Ticket admin table-->
        <el-table
                class="table table-striped"
                ref="ticketsTable"
                :data="searchedTickets"
                max-height="500"
                style="width: 100%"
                :row-class-name="tableRowClassName"
        >
            <el-table-column
                    label="Seller"
                    sortable
                    prop="seller_name"
            >
                <template slot-scope="scope">
                    <a :href="scope.row.seller_link">{{scope.row.seller_name}}</a>
                </template>
            </el-table-column>
            <el-table-column
                    prop="departure_date"
                    label="Date"
                    sortable>
            </el-table-column>
            <el-table-column
                    prop="departure_city"
                    label="From"
                    :filters="stationsFilters"
                    :filter-method="filterHandler"
            >
            </el-table-column>
            <el-table-column
                    prop="arrival_city"
                    label="To"
                    :filters="stationsFilters"
                    :filter-method="filterHandler"
            >
            </el-table-column>
            <el-table-column
                    label="Price"
                    sortable
                    prop="price"
            >
                <template slot-scope="scope">
                    {{scope.row.price}} {{scope.row.currency}}

                </template>
            </el-table-column>
            <el-table-column
                    prop="status"
                    label="Status"
                    :filtered-value="['selling']"
                    :filters="[{value:'sold',text:'sold'},{value:'passed',text:'passed'},{value:'selling',text:'selling'}]"
                    :filter-method="filterHandler"
            >
            </el-table-column>

            <el-table-column
                    label="Actions"
                    fixed="right"

            >
                <template slot-scope="scope">
                    <button class="btn btn-sm btn-primary btn-fill" @click="share(scope.row.id)">
                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                    </button>
                    <a class="btn btn-sm btn-info btn-fill" :href="scope.row.edit_link">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <input style="height: 10px;width: 10px;opacity: 0;" :value="scope.row.share_link" :id="'share-'+scope.row.id">

                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>


    export default {
        props: {
            tickets: {type: Array, required: true},
            stations: {type: Array, required: true},
        },
        data() {
            return {
                searchValue: ''
            }
        },
        methods: {
            filterHandler(value, row, column) {
                const property = column['property'];
                return row[property] === value;
            },
            share(id) {
                document.getElementById('share-'+id).select();
                document.getElementById('share-'+id).setSelectionRange(0,  document.getElementById('share-'+id).value.length);

                document.execCommand("Copy");
            },
            tableRowClassName({row, rowIndex}) {
                if (row.status === 'sold') {
                    return 'table-success';
                } else if (row.status === 'passed') {
                    return 'table-danger';
                }
                return '';
            }
        },
        computed: {
            stationsFilters() {
                let stationsFilters = [];
                for(let i=0;i<this.stations.length;i++){
                    stationsFilters.push({
                        text: this.stations[i],
                        value: this.stations[i]
                    })
                }
                return stationsFilters;
            },
            searchedTickets() {
                let filtered = [];
                for (let i = 0; i < this.tickets.length; i++) {
                    if (this.tickets[i].seller_name.toLowerCase().indexOf(this.searchValue.toLowerCase()) != -1) {
                        filtered.push(this.tickets[i]);
                    }
                }
                return filtered;
            }
        }
    }
</script>
