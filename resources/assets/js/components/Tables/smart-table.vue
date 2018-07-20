<template>
    <div class="smart-table">
        <div class="table-index">
            <div class="row">
                <div class="col d-flex">
                    <button class="btn btn-sm btn-bnp mr-1" @click="this.resetFilters">
                        <i class="fas fa-times-circle"></i>
                        Reset filters
                    </button>
                    <input type="text"
                           class="form-control form-control-sm"
                           placeholder="Search table..."
                           v-model="filters.search"
                           >
                </div>
                <div class="col text-right">
                    <slot name="header-actions"></slot>
                    <a class="btn  btn-hover-icon btn-sm btn-primary text-white" :href="routes.create" v-if="routes.create">
                        <i class="fas fa-plus"></i>
                        <span class="btn-text"> Add new</span>
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <template v-for="col in structure.columns">
                    <th :class="colClass(col)" scope="col">{{col.name}}</th>
                </template>
                <th scope="col" v-if="structure.actions && structure.actions.length>0">Actions</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="item in filteredData">
                <tr>
                    <template v-for="col in structure.columns">
                        <td :class="colClass(col)" v-if="col.type=='string'">{{$lodash.get(item, col.key)}}</td>
                        <td :class="colClass(col)" v-else-if="col.type=='boolean'">
                            <template v-if="$lodash.get(item, col.key)">
                                <i class="fas fa-check text-primary"></i>
                            </template>
                            <template v-else>
                                <i class="fas fa-times text-primary"></i>
                            </template>
                        </td>

                    </template>
                    <td v-if="structure.actions && structure.actions.length>0">
                        <template v-for="action in structure.actions">
                            <a :class="'btn btn-sm '+action.btn_class" :href="actionRoute(action.route,item.id)">
                                <i :class="action.icon"></i> {{action.name}}
                            </a>
                        </template>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: {
            structure: {required: true, type: Object},
            routes: {required: true, type: Object},
            data: {required: true, type: Array}
        },
        methods: {
            colClass(col) {
                let colClass = '';

                if (col.align == 'center') {
                    colClass = "text-center"
                } //TODO: support right and left align

                return colClass;
            },
            resetFilters() {
                this.filters.search = '';
            },
            actionRoute(routeKey, id) {
                let route = this.$lodash.get(this.routes,routeKey);
                return route.replace('id',id);
            }
        },
        data () {
            return {
                filters: {
                    search: ''
                }
            }
        },
        computed: {
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
                if(this.filters.search == "") {
                    return this.data;
                }

                let filtered = [];
                for (let i = 0; i < this.data.length; i++) {
                    for (let j = 0; j < this.searchableKeys.length; j++) {
                        if (this.$lodash.get(this.data[i],this.searchableKeys[j]).toLowerCase().indexOf(this.filters.search.toLowerCase()) != -1) {
                            filtered.push(this.data[i]);
                            break;
                        }
                    }
                }
                return filtered;
            }
        }

    }
</script>









