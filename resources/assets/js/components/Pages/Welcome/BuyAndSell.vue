<template>
    <div class="col-12">
        <div class="card card-buy-sell-welcome">
            <div class="card-body">
                <div class="buttons-search">
                    <button :class="{'btn':true, 'btn-lastar-blue':true} " @click="switchState('buy')">{{lang.buy.title}}</button>
                    <button :class="{'btn':true, 'btn-danger':true} " @click="switchState('sell')">{{lang.sell.title}}</button>
                </div>
                <div id="action-content">

                    <transition enter-class="pre-animated"
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div v-if="state=='buy'" class="pt-4">
                            <buy-ticket-welcome :lang="lang" :csrf="csrf" :routes="routes" :api="api" :stations="stations"
                                                v-on:change-departure="changeDeparture($event)"
                                                v-on:change-arrival="changeArrival($event)"
                                                v-on:change-date="changeDate($event)"
                                                v-on:change-time="changeTime($event)"
                            ></buy-ticket-welcome>
                            <div class="row">
                                <button class="btn btn-primary mt-3 mx-auto btn-action-submit" @click.prevent="searchTickets">
                                    <span v-if="sellState!='searching'">{{lang.buy.research}}</span>
                                    <loader v-else class-name="loader-btn"></loader>
                                </button>
                            </div>
                            <transition enter-class="pre-animated"
                                        enter-active-class="animated fadeIn no-space"
                                        leave-active-class="animated fadeOut no-space">
                                <p v-if="sellState=='result'" class="text-center mt-4 mb-0"><span class="text-pink">{{sellingTickets.length}}</span> {{lang.buy.search_result}}</p>
                            </transition>

                            <transition enter-class="pre-animated"
                                        enter-active-class="animated fadeInUpBig no-space"
                                        leave-active-class="animated fadeOut no-space">
                                <div class="row mt-4" v-if="sellingTickets.length > 0">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4" v-for="ticket in sellingTickets" :key="ticket.id">
                                        <ticket :ticket="ticket" :routes="routes" :api="api" :lang="lang.component" :buying="true" class-name="mt-4"></ticket>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </transition>
                    <transition enter-class="pre-animated"
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div v-if="state=='sell'" class="text-center">
                            <sell-ticket-welcome :lang="lang" :csrf="csrf" :routes="routes" ></sell-ticket-welcome>
                            <button v-if="buyingState=='default'" class="btn btn-lastar-blue mt-3 mx-auto btn-action-submit" @click.prevent="sellTicket">
                                <span>{{lang.sell.title}}</span>
                            </button>
                            <p v-else class="text-center mt-3">
                                {{lang.buy.safety}}<br>
                                <a :href="routes.register">{{lang.buy.create_account}}</a>
                            </p>
                        </div>
                    </transition>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            stations: {type: Array, required: true},
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            state: {type: String, Default: 'buy', required: true}
        },
        data() {
            return {
                buyingState: 'default',
                sellState: 'default',
                sellingTickets: [],
                csrf: window.csrf,
                search: {
                    departure_station: null,
                    arrival_station: null,
                    trip_date: null,
                    trip_time: null,
                },
            }
        },
        computed: {},
        methods: {
            changeDeparture(station){
                this.search.departure_station = station;
            },
            changeArrival(station){
                this.search.arrival_station = station;
            },
            changeDate(date){
                this.search.trip_date = moment(date).format('YYYY-MM-DD');
            },
            changeTime(time){
                this.search.trip_time = time;
            },
            switchState(newState) {
                this.$emit('change-state', newState);
            },
            searchTickets(){

                if (this.sellState!='default' && this.sellState!='result'){
                    this.searchError = true;
                    return null;
                }

                if(this.search.departure_station == null
                    || this.search.arrival_station == null
                    || this.search.trip_date == null) {
                    this.searchError = true;
                    return null;
                }

                this.searchError = false;

                this.sellState = 'searching';
                this.$http.post(this.api.tickets.buy, this.search)
                    .then(response => {
                        function compare(a, b) {
                            if (a.train.departure_date < b.train.departure_date)
                                return -1;
                            if (a.train.departure_date > b.train.departure_date)
                                return 1;
                            return 0;
                        }

                        this.sellState='result';
                        this.sellingTickets = response.data.data.sort(compare);
                    })

            },
            sellTicket(){
                this.buyingState = 'register'
            }
        }
    }
</script>