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
                max-height="650"
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
            >
            </el-table-column>
            <el-table-column
                    prop="arrival_city"
                    label="To"
            >
            </el-table-column>
            <el-table-column
                    prop="provider"
                    label="Provider"
                    :filters="[{value:'sncf',text:'Sncf'},{value:'eurostar',text:'Eurostar'},{value:'thalys',text:'Thalys'}]"
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
                    :filters="[{value:'sold',text:'sold'},{value:'passed',text:'passed'},{value:'selling',text:'selling'},{value:'scam',text:'scam'}]"
                    :filter-method="filterHandler"
            >
            </el-table-column>
            <el-table-column
                    prop="offers_count"
                    label="Offers"
                    sortable
            >
            </el-table-column>
            <el-table-column
                    label="Actions"
                    fixed="right"

            >
                <template slot-scope="scope">
                    <button :class="{'btn btn-sm btn-fill':true, 'btn-primary':scope.row.id!=copied, 'btn-success':scope.row.id==copied}" @click="share(scope.row.id)">
                        <i class="fa fa-clipboard" aria-hidden="true" v-if="scope.row.id!=copied"></i>
                        <i class="fa fa-check" aria-hidden="true" v-else></i>
                    </button>
                    <a class="btn btn-sm btn-info btn-fill" :href="scope.row.edit_link">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <input type="hidden" :value="scope.row.share_link" :id="'share-'+scope.row.id" >

                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>


    export default {
        props: {
            tickets: {type: Array, required: true},
        },
        data() {
            return {
                searchValue: '',
                copied: null
            }
        },
        methods: {
            filterHandler(value, row, column) {
                const property = column['property'];
                return row[property] === value;
            },
            share(id) {
                const copyToClipboard = str => {
                    const el = document.createElement('textarea');  // Create a <textarea> element
                    el.value = str;                                 // Set its value to the string that you want copied
                    el.setAttribute('readonly', '');                // Make it readonly to be tamper-proof
                    el.style.position = 'absolute';
                    el.style.left = '-9999px';                      // Move outside the screen to make it invisible
                    document.body.appendChild(el);                  // Append the <textarea> element to the HTML document
                    const selected =
                        document.getSelection().rangeCount > 0        // Check if there is any content selected previously
                            ? document.getSelection().getRangeAt(0)     // Store selection if found
                            : false;                                    // Mark as false to know no selection existed before
                    el.select();                                    // Select the <textarea> content
                    document.execCommand('copy');                   // Copy - only works as a result of a user action (e.g. click events)
                    document.body.removeChild(el);                  // Remove the <textarea> element
                    if (selected) {                                 // If a selection existed before copying
                        document.getSelection().removeAllRanges();    // Unselect everything on the HTML document
                        document.getSelection().addRange(selected);   // Restore the original selection
                    }
                };

                this.copied = id;

                copyToClipboard(document.getElementById('share-'+id).value);
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
