<template>
    <div class="col-12">

        <div class="card">
            <div class="card-header reverse">
                <h4 class="card-title mb-0">{{lang.buy.title}}</h4>
            </div>
            <div class="card-body">
                <p class="card-text">
                    {{lang.buy.catchline}}
                </p>
                <form class="row">
                    <div class="col-12 col-sm-12 col-md-6 mb-4 mb-md-0">
                        <trippicker :stations="stations"
                                    :lang="lang.buy.inputs.trippicker"
                                    v-on:change-departure="changeDeparture($event)"
                                    v-on:change-arrival="changeArrival($event)"
                                    :default-depart="search.departure_station"
                                    :default-arrival="search.arrival_station"
                        ></trippicker>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 mb-4 mb-md-0">
                        <datetimepicker
                                :lang="lang.buy.inputs.datetimepicker"
                                v-on:change-date="changeDate($event)"
                                v-on:change-time="changeTime($event)"
                                :default-date="search.trip_date">
                        </datetimepicker>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-lastar-blue btn-block d-block d-md-none" @click.prevent="searchTickets">
                            <span v-if="state!='searching'">{{lang.buy.research}}</span>
                            <loader v-else class-name="loader-btn"></loader>
                        </button>
                        <button class="btn btn-lastar-blue d-none d-md-block mt-4 px-4 mx-auto" @click.prevent="searchTickets">
                            <span v-if="state!='searching'">{{lang.buy.research}}</span>
                            <loader v-else class-name="loader-btn"></loader>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
            <p v-if="state=='result'" class="text-center mt-4 mb-0"><span class="text-pink">{{ticketsWithOffers.length}}</span> {{lang.buy.search_result}}</p>
        </transition>

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOut">
            <div class="row mt-4" v-if="ticketsWithOffers.length > 0">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4" v-for="ticket in ticketsWithOffers" :key="ticket.id">
                    <ticket :ticket="ticket" :api="api" :routes="routes" :lang="lang.component" :user="user" :buying="true" class-name="mt-4"></ticket>
                </div>
            </div>
        </transition>

    </div>
</template>

<script>
    var london_code = 7015400;
    var paris_code =  8727100;

    export default {
        props: {
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            user: {type: Object, required: true},
            stations: {type: Array, required: true},
           // defaultTickets: {type: Array, required: true}
        },
        data() {
            return {
                csrf: window.csrf,
                state: 'default',
                tickets: [],
                offerSentNow: [],
                search: {
                    departure_station: null,
                    arrival_station: null,
                    trip_date: null,
                    trip_time: null,
                },
                countSearch: 0
            }
        },
        created() {
            this.search.departure_station = this.user.language == 'FR'?this.getParisId:this.getLondonId;
            this.search.arrival_station = this.user.language == 'FR'?this.getLondonId:this.getParisId;
            this.search.trip_date = moment().format('YYYY-MM-DD');
        },
        computed: {
            getLondonId(){
                for (var stationIndex in this.stations){
                    if (this.stations[stationIndex].eurostar_id == london_code){
                        return this.stations[stationIndex].id;
                    }
                }
                return null;
            },
            getParisId(){
                for (var stationIndex in this.stations){
                    if (this.stations[stationIndex].eurostar_id == paris_code){
                        return this.stations[stationIndex].id;
                    }
                }
                return null;
            },
            ticketsWithOffers(){
                // Add offer inforation to each ticket
                var tickets = this.tickets;
                if (this.user.offers_sent === {}) return;
                for (var i=0;i<tickets.length;i++){
                    for (var key in this.user.offers_sent) {
                        if (this.user.offers_sent[key].ticket_id == tickets[i].id){
                            tickets[i].discussionId = this.user.offers_sent[key].id;
                            tickets[i].offerStatus = this.user.offers_sent[key].status;
                            tickets[i].offerPrice = this.user.offers_sent[key].price;
                        }
                    }
                }
                return tickets;
            }
        },
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
            searchTickets(){
                if (this.state!='default' && this.state!='result') return null;
                this.searchError = false;

                this.state = 'searching';
                this.$http.post(this.api.tickets.buy, this.search)
                    .then(response => {
                        function compare(a, b) {
                            if (a.train.departure_date < b.train.departure_date)
                                return -1;
                            if (a.train.departure_date > b.train.departure_date)
                                return 1;
                            return 0;
                        }

                        this.countSearch++;
                        this.state='result';
                        this.tickets = response.data.data.sort(compare);
                    })

            }
        }
    }
</script>