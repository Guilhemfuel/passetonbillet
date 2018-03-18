<template>
    <div class="col-12">

        <div class="row">
            <div class="col-12 text-center py-3">
                <el-radio-group v-model="state" class="mx-auto">
                    <el-radio-button :label="stateValues.selling">{{lang.owned.selling}}</el-radio-button>
                    <el-radio-button :label="stateValues.sold">{{lang.owned.sold}}</el-radio-button>
                    <el-radio-button :label="stateValues.bought">{{lang.owned.bought}}</el-radio-button>
                </el-radio-group>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-4" v-for="ticket in currentTickets">
                <template v-if="state==stateValues.bought">
                    <ticket :ticket="ticket" :lang="lang.component" :user="user" :bought="true" :routes="routes" :csrf="csrf"></ticket>
                </template>
                <template v-else-if="state==stateValues.sold">
                    <ticket :ticket="ticket" :lang="lang.component" :user="user" :routes="routes" :csrf="csrf"></ticket>
                </template>
                <template v-else-if="state==stateValues.selling">
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

            stateValues: {
                type: Object, default: () => {
                    return {
                        sold: 1,
                        bought: 2,
                        selling: 3
                    }
                }
            },
        },
        data() {
            return {
                state: this.stateValues.selling,
            }
        },
        computed: {
            sellingTickets: function () {
                var ticketsToReturn = [];
                for (var i=0;i<this.tickets.length;i++){
                    var now = moment();
                    var departure = moment(this.tickets[i].train.departure_date, 'YYYY-MM-DD');
                    if(!now.isAfter(departure)){
                        ticketsToReturn.push(this.tickets[i])
                    }
                }
                return ticketsToReturn;
            },
            soldTickets: function () {
                var ticketsToReturn = [];
                for (var i=0;i<this.tickets.length;i++){
                    var now = moment();
                    var departure = moment(this.tickets[i].train.departure_date, 'YYYY-MM-DD');
                    if(now.isAfter(departure)){
                        ticketsToReturn.push(this.tickets[i])
                    }
                }
                return ticketsToReturn;
            },
            currentTickets: function(){
                var actualTickets = null;
                if (this.state == this.stateValues.sold) {
                    actualTickets = this.soldTickets;
                } else if(this.state == this.stateValues.bought) {
                    actualTickets = this.boughtTickets;
                }
                else if(this.state == this.stateValues.selling) {
                    actualTickets = this.sellingTickets;
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