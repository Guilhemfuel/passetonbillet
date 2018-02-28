<template>
    <div class="col-12">
        <div class="card card-buy-sell-welcome">
            <div class="card-body">
                <div class="buttons-search">
                    <button :class="{'btn':true, 'btn-lastar':state=='buy','btn-outline-purple':state!='buy'} " @click="switchState('buy')">{{lang.buy.title}}</button>
                    <button :class="{'btn':true, 'btn-lastar':state=='sell','btn-outline-purple':state!='sell'} " @click="switchState('sell')">{{lang.sell.title}}</button>
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
                            <button class="btn btn-lastar-blue mt-3 mr-auto" @click.prevent="searchTickets">
                                <span v-if="sellState!='searching'">{{lang.buy.research}}</span>
                                <loader v-else class-name="loader-btn"></loader>
                            </button>
                            <transition enter-class="pre-animated"
                                        enter-active-class="animated fadeIn"
                                        leave-active-class="animated fadeOut">
                                <p v-if="sellState=='result'" class="text-center mt-4 mb-0"><span class="text-pink">{{sellingTickets.length}}</span> billet(s) corresponde(nt) à votre recherche.</p>
                            </transition>

                            <transition enter-class="pre-animated"
                                        enter-active-class="animated fadeInUpBig"
                                        leave-active-class="animated fadeOut">
                                <div class="row mt-4" v-if="sellingTickets.length > 0">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-4" v-for="ticket in sellingTickets">
                                        <ticket :ticket="ticket" :routes="routes" :api="api" :lang="lang.component" :buying="true" class-name="mt-4"></ticket>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </transition>
                    <transition enter-class="pre-animated"
                                enter-active-class="animated fadeIn"
                                leave-active-class="animated fadeOut">
                        <div v-if="state=='sell'">
                            <sell-ticket-welcome :lang="lang" :csrf="csrf" :routes="routes" ></sell-ticket-welcome>
                            <button v-if="buyingState=='default'" class="btn btn-lastar-blue mt-3 mr-auto" @click.prevent="sellTicket">
                                <span>{{lang.sell.title}}</span>
                            </button>
                            <p v-else class="text-center mt-3">
                                Safety is our number one concern! You must register to sell one of your tickets!<br>
                                <a :href="routes.register">Create a Lastar account</a>
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
            csrf: {type: String, required:true},
            state: {type: String, Default: 'buy', required: true}
        },
        data() {
            return {
                buyingState: 'default',
                sellState: 'default',
                sellingTickets: [],
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
                if (this.sellState!='default' && this.sellState!='result') return null;

                if(this.search.departure_station == null
                    || this.search.arrival_station == null
                    || this.search.trip_date == null) return;

                this.searchError = false;

                this.sellState = 'searching';
                this.$http.post(this.api.tickets.buy, this.search)
                    .then(response => {
                        this.sellState='result';
                        this.sellingTickets = response.data.data;
                    })

            },
            sellTicket(){
                this.buyingState = 'register'
            }
        }
    }
</script>