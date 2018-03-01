<template>
    <div class="col-12">

        <div class="row">
            <div class="col-12 text-center py-3">
                <el-radio-group v-model="state" class="mx-auto">
                    <el-radio-button :label="stateValues.sold">{{lang.owned.sold}}</el-radio-button>
                    <el-radio-button :label="stateValues.bought">{{lang.owned.bought}}</el-radio-button>
                </el-radio-group>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4" v-for="ticket in currentTickets">
                <template v-if="state==stateValues.bought">
                    <ticket :ticket="ticket" :lang="lang.component" :user="user" :bought="true" :routes="routes" :csrf="csrf"></ticket>
                </template>
                <template v-else>
                    <ticket :ticket="ticket" :lang="lang.component" :user="user" :routes="routes" :csrf="csrf"></ticket>
                </template>
            </div>
            <p class="text-center" v-if="currentTickets.length==0">
                <template v-if="state==stateValues.bought">
                    {{lang.owned.no_bought_tickets}}
                </template>
                <template v-else>
                    {{lang.owned.no_sold_tickets}}
                </template>
            </p>
        </div>

    </div>
</template>

<script>

    export default {
        props: {
            tickets: {type: Array, required: true},
            boughtTickets : {type: Array, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            user: {type: Object, required: true},
            csrf: {type: String, required:true},

            stateValues: {type: Object, default:{
                sold: 1,
                bought: 2
            }}
        },
        data() {
            return {
                state: 1,
            }
        },
        computed: {
            currentTickets: function(){
                var actualTickets = null;
                if (this.state == this.stateValues.sold) {
                    actualTickets = this.tickets;
                } else {
                    actualTickets = this.boughtTickets;
                }

                function compare(a, b) {
                    if (a.train.departure_date < b.train.departure_date)
                        return 1;
                    if (a.train.departure_date > b.train.departure_date)
                        return -1;
                    return 0;
                }

                return actualTickets.sort(compare);
            }
        },
        methods: {

        }
    }
</script>