<template>
    <div class="smart-table">
        <div class="table-index" ref="tableIndex">
            <div class="row">
                <div class="col d-flex search" v-if="searchableKeys.length > 0">
                    <button class="btn btn-sm btn-primary mr-1" @click="this.resetFilters">
                        <i class="fa fa-times-circle-o"></i>
                        Reset filters
                    </button>
                    <input type="text"
                           class="form-control form-control-sm"
                           placeholder="Search table..."
                           v-model="filters.search"
                           @input="changeSearch()"
                    >
                </div>
                <div class="col text-right">
                    <slot name="header-actions"></slot>
                    <a class="btn  btn-hover-icon btn-sm btn-primary text-white" :href="routes.create"
                       v-if="routes && routes.create">
                        <i class="fa fa-plus"></i>
                        <span class="btn-text"> Add new</span>
                    </a>
                </div>
            </div>
        </div>
        <table :class="{'table':true,  'table-striped': true, 'not-remote': !remote, 'not-searchable': searchableKeys.length == 0}" ref="table">
            <thead>
            <tr>
                <template v-for="col in structure.columns">
                    <th scope="col" @click="sortByCol(col)" :class="{'d-none':col.hiddenMobile, 'd-sm-flex':true, 'd-flex':!col.hiddenMobile}" :style="colStyle(col)">
                        <p :class="colClass(col, null, true)">
                            {{col.name}}
                            <template v-if="col.sortable">
                                <i class="fa fa-sort"></i>
                                <i class="fa fa-sort-desc text-primary"></i>
                                <i class="fa fa-sort-asc text-primary"></i>
                            </template>
                        </p>
                    </th>
                </template>
                <th scope="col" v-if="hasActionColumn">
                    <p>
                        Actions
                    </p>
                </th>
            </tr>
            </thead>
            <tbody v-if="!loading" class="scrollable">
            <template v-for="item in filteredData">
                <!-- Render Row -->
                <tr :class="{'row-link':rowLink!=null}" @click="rowClicked(item)">
                    <template v-for="col in structure.columns">
                        <td :class="colClass(col,get(item, col.key, col))" :style="colStyle(col)">
                            <!-- String -->
                            <template v-if="col.type=='string'">
                                <!-- Optional link with string -->
                                <template v-if="col.hasOwnProperty('link') && col.hasOwnProperty('link_keys')">
                                    <a :href="linkRoute(col.link,item,col.link_keys)" target="_blank">
                                        {{get(item, col.key, col)}}
                                    </a>
                                </template>
                                <template v-else>
                                    {{get(item, col.key, col)}}
                                </template>
                            </template>
                            <template v-else-if="col.type=='number'">
                                {{get(item, col.key, col) | numeral(col.number_format)}}
                            </template>
                            <template v-else-if="col.type=='boolean'">
                                <template v-if="get(item, col.key, col)">
                                    <i class="fa fa-check text-primary"></i>
                                </template>
                                <template v-else>
                                    <i class="fa fa-times text-primary"></i>
                                </template>
                            </template>
                            <template v-else-if="col.type=='date'">
                                {{get(item, col.key, col) | date}}
                            </template>
                        </td>

                    </template>

                    <!-- Render Actions -->
                    <td v-if="hasActionColumn">
                        <template v-for="action in structure.actions" v-if="(structure.actions && structure.actions.length>0)">
                            <a :class="'btn btn-sm '+action.btn_class" :href="actionRoute(action.route,item)">
                                <i :class="action.icon"></i> {{action.name}}
                            </a>
                        </template>
                        <slot name="actions" v-bind:item="item"></slot>
                    </td>
                </tr>
            </template>
            </tbody>
            <tbody v-else>
            <tr>
                <td :colspan="columnCount">
                    <loader class-name="mx-auto d-block"></loader>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="table-pagination" v-if="remote">
            <div class="left">
                <pagination :data="pagination" v-model="pagination.page" @change="loadData()"></pagination>
            </div>
            <div class="right">
                <div class="total d-none d-sm-block">
                    <p>Total: {{pagination.totalItems}} item(s)</p>
                </div>
                <div class="item-per-page">
                    <p class="m-0 label">Show</p>
                    <el-select v-model="pagination.itemsPerPage" placeholder="50" @change="loadData(true)">
                        <el-option
                                label="10"
                                value="10">
                        </el-option>
                        <el-option
                                label="20"
                                value="20">
                        </el-option>
                        <el-option
                                label="50"
                                value="50">
                        </el-option>
                        <el-option
                                label="100"
                                value="100">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {debounce} from 'lodash';
    import Pagination from './pagination';

    /**
     * Table that can be used with remote data or not.
     *
     * Actions can be passed as slots or as json to call endpoint (buttons <a>)
     *
     */

    export default {
        components: {
          'pagination': Pagination
        },
        props: {
            /**
             * Structure of the table. Array of objects with thw following properties:
             * - key (key used to retrieve value)
             * - name (column name)
             * - type (boolean, string, date, number)
             * - searchable (boolean, to use if is string)
             * - align (center, left, right, justify)
             * - classFunction (function use to add class depending on value)
             * - hiddenMobile (wheter to hide col on mobile or not)
             * - transformer (function taking an item as input and ouput a value/format. Note that key won't be used)
             * - width (flexbox width, 1 is same size a all other columns, 2 is twice the size of others...)
             * - link and link_keys to add a link around the value
             *  String columns can also have the attributes 'link' and 'link_keys' to add a link. If so, the 'link' must
             *  be the name of a route in the route object. 'link_keys' must then contains element to replace route's
             *  placeholder with.
             *
             */
            structure: {required: true, type: Object},
            routes: {required: false, type: Object},
            /**
             * Array of api routes (going to call the index property of given object)
             */
            api: {required: false, type: Object},
            data: {required: false, type: Array},
            /**
             * Wether data should be pulled remotly or not
             */
            remote: {required: false, type: Boolean, default: false},
            /**
             * Date format used to display dates
             */
            dateFormat: {required: false, type: String, default: 'DD/MM/YYYY'},
            /**
             * If a row is clicked, redirect (simulate <a>) to the rowLink route specified. rowLink has to be the name
             * of one of the route in the route object. If it's not set (left to null), rows won't be clickable.
             *
             * Note that this feature in not compatible with the actions columns.
             */
            rowLink: { type: String, default: null}
        },
        data() {
            return {
                filters: {
                    search: '',
                    sortBy: null,
                    sortByDesc: false,
                },
                loadedData: [],
                loading: false,

                // Pagination
                pagination: {
                    page: 1,
                    itemsPerPage: 50,
                    firstPage: 1,
                    from: 1,
                    lastPage: 1,
                    totalItems: 0,
                },

                // Position
                tablePosition: 0,
            }
        },
        methods: {
            /**
             * Avoid querying at each letter typed
             */
            changeSearch: debounce(function () {
                this.loadData(true);
            }, 500),

            /**
             * Give a class to a column depending on table structure
             */
            colClass(col, value ,header = false) {
                let colClass = '';

                if (col.hiddenMobile) {
                    colClass += 'd-none d-sm-block';
                }

                if (col.align == 'center') {
                    colClass += " text-center"
                } else if (col.align == 'left') {
                    colClass += " text-left"
                } else if (col.align == 'right') {
                    colClass += " text-right"
                } else if (col.align == 'justify') {
                    colClass += " text-justify"
                }

                if (header == true && col.sortable) {
                    colClass += " sortable"

                    if (this.filters.sortBy == col.key) {
                        if (this.filters.sortByDesc) {
                            colClass += " sorted desc"
                        } else {
                            colClass += " sorted asc"
                        }
                    }
                }

                if (!header && value && col.classFunction) {
                    colClass += ' '+ col.classFunction(value)
                }

                return colClass;
            },
            /**
             * Compute Style of a given column
             */
            colStyle(col) {
                if (col.width) {
                    return {
                        flex: col.width,
                    }
                }

                return {}
            },
            /**
             * Reset all filters
             */
            resetFilters() {
                this.filters.search = '';
                this.filters.sortBy = null;
                this.filters.sortByDesc = false;

                this.loadData(true);
            },
            /**
             * Transform given route to replace string 'id' with given string
             */
            actionRoute(routeKey, item) {
                let route = this.$lodash.get(this.routes, routeKey);

                // Replace each parameter in route
                this.keys.forEach((parameter)=> {
                    route = route.replace(parameter, this.get(item,parameter));
                })
                return route
            },
            /**
             * Transform given link (route) to replace string with actual properties
             */
            linkRoute(linkKey, item, linkKeys) {
                let route = this.$lodash.get(this.routes, linkKey);
                // Replace each parameter in route
                linkKeys.forEach((parameter)=> {
                    route = route.replace(parameter, this.get(item,parameter));
                })
                return route
            },
            /**
             * If the row click feature is activated, a click to an item's row will redirect to the given route.
             */
            rowClicked(item) {
                // Make sure rowlink is activated
                if (!this.rowLink) {
                    return null;
                }

                let url = this.actionRoute(this.rowLink,item);
                window.location = url;
            },
            /**
             * Get object property
             */
            get (item, field, col=null) {
                if (col && col.hasOwnProperty('transformer')) {
                    return col.transformer(item);
                }
                let fieldData = this.$lodash.get(item,field);
                if (typeof fieldData === 'object' && fieldData.hasOwnProperty('value')) {
                    return fieldData.value;
                } else {
                    return fieldData;
                }
            },

            /**
             * Load remote data with pagination and filters
             */
            loadData(resetPage = false) {

                // Only in remote table
                if(!this.remote) return;

                //Loading true
                this.loading = true;

                if (resetPage) {
                    this.pagination.page = 1;
                }

                let requestParams = {
                    page: this.pagination.page,
                    "items_per_page": this.pagination.itemsPerPage,
                };

                // Add sorting
                if (this.filters.sortBy != null) {
                    requestParams["sort_by"] = this.filters.sortBy;
                    requestParams["sort_desc"] = this.filters.sortByDesc;
                }

                // Add search
                if (this.filters.search != ''){
                    requestParams["search_value"] = this.filters.search;
                    requestParams["search_columns"] = this.searchableKeys;
                }


                this.$http.get(this.api.index, {
                    params: requestParams
                })
                    .then((response) => {
                        this.loadedData = response.data.data;
                        this.updatePagination(response.data.meta);
                        this.loading = false;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            /**
             * Update pagination object from meta
             */
            updatePagination(meta) {
                this.pagination = {
                    page: meta.current_page,
                    itemsPerPage: this.pagination.itemsPerPage,
                    "from": meta.from,
                    "to": meta.to,
                    firstPage: 1,
                    lastPage: meta.last_page,
                    totalItems: meta.total,
                }
            },
            sortByCol(col) {
                if (!col.sortable) return;

                if (this.filters.sortBy == null) {
                    this.filters.sortBy = col.key;
                    this.filters.sortByDesc = false;
                } else if (this.filters.sortBy == col.key && !this.filters.sortByDesc) {
                    this.filters.sortByDesc = true;
                } else if (this.filters.sortBy == col.key && this.filters.sortByDesc) {
                    this.filters.sortBy = null;
                    this.filters.sortByDesc = false;
                } else {
                    this.filters.sortBy = col.key;
                    this.filters.sortByDesc = false;
                }
                this.loadData();
            },
        },
        mounted() {
            // Make sure that incompatible behaviours are not used together.
            if (this.hasActionColumn && this.rowLink) {
                throw "Smart Table Error: you can't use row links along with actions.";
            }

            // Load Data if needed
            if (this.remote) {
                this.loadData();
            }

            // Save position of table
            let table = this.$refs.tableIndex;
            this.tablePosition = table.getBoundingClientRect().top
                + (window.pageYOffset || document.documentElement.scrollTop);
        },
        computed: {
            /**
             * Returns true if actions column is used, false otherwise
             */
            hasActionColumn() {
                return this.$scopedSlots.actions || (this.structure.actions && this.structure.actions.length>0)
            },

            /**
             * Return the primary key of the model (by default 'id')
             */
            keys() {
                if (this.structure.keys) {
                    return this.structure.keys;
                }
                return ['id'];
            },
            /**
             * Return number of columns
             */
            columnCount() {
                let count = this.structure.columns.length;
                if (this.structure.actions) {
                    count++;
                }
                return count;
            },

            /**
             * Simply used to know which data to use (if table uses remote data or not)
             */
            actualData() {
                return this.remote ? this.loadedData : this.data;
            },

            /**
             * Return all the columns that are searchable
             * @returns {Array}
             */
            searchableKeys() {
                let keys = [];
                for (let i = 0; i < this.structure.columns.length; i++) {
                    if (this.structure.columns[i].searchable) {
                        keys.push(this.structure.columns[i].key);
                    }
                }
                return keys;
            },
            /**
             * Return all items once filtered by search string
             * @returns {Array}
             */
            filteredData() {
                let data = this.actualData;

                if (this.filters.search == "" || this.remote) {
                    return data;
                }

                let filtered = [];

                if (data == undefined || data == null) return filtered;

                for (let i = 0; i < data.length; i++) {
                    for (let j = 0; j < this.searchableKeys.length; j++) {
                        if (this.get(data[i], this.searchableKeys[j]).toLowerCase().indexOf(this.filters.search.toLowerCase()) != -1) {
                            filtered.push(data[i]);
                            break;
                        }
                    }
                }

                return filtered;
            }
        }

    }
</script>









