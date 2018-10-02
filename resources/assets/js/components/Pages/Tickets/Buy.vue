<template>
    <div class="col-12">

        <div class="card-title mb-0">{{trans('tickets.buy.title')}}</div>

        <div class="card">
            <div class="card-body">
                <p class="card-text">
                    {{trans('tickets.buy.catchline')}}
                </p>
                <form class="row">
                    <div class="col-12 col-sm-12 col-md-6 mb-4 mb-md-0">
                        <input-stations v-on:change-departure="changeDeparture($event)"
                                        v-on:change-arrival="changeArrival($event)"
                                        :default-depart="search.departure_station"
                                        :default-arrival="search.arrival_station"
                        ></input-stations>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 mb-4 mb-md-0">
                        <input-date-time v-on:change-date="changeDate($event)"
                                         v-on:change-time="changeTime($event)"
                                         :default-time="search.trip_time"
                                         :default-date="search.trip_date"
                        >
                        </input-date-time>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-ptb-blue btn-block d-block d-md-none" @click.prevent="searchTickets">
                            <span v-if="state!='searching'">{{trans('tickets.buy.research')}}</span>
                            <loader v-else class-name="loader-btn"></loader>
                        </button>
                        <button class="btn btn-ptb-blue d-none d-md-block mt-4 px-4 mx-auto"
                                @click.prevent="searchTickets">
                            <span v-if="state!='searching'">{{trans('tickets.buy.research')}}</span>
                            <loader v-else class-name="loader-btn"></loader>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeIn"
                    leave-active-class="animated fadeOut">
            <p v-if="state=='result'" class="text-center mt-4 mb-0"><span
                    class="text-primary">{{ticketsWithOffers.length}}</span> {{trans('tickets.buy.search_result')}}</p>
        </transition>

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOut">
            <div class="row mt-4 row-ticket" v-if="ticketsWithOffers.length > 0">
                <div class="col-12 col-sm-12 col-md-6 col-lg-4 px-5 px-sm-5 px-md-3 row-item-ticket" v-for="ticket in ticketsWithOffers"
                     :key="ticket.id">
                    <ticket :ticket="ticket"
                            :buying="true"
                            class-name="mt-4"></ticket>
                </div>
            </div>
        </transition>

    </div>
</template>

<script>
    export default {
        props: {
            defaultSearch: {type: Object, required: true}
        },
        data() {
            return {
                csrf: window.csrf,
                state: 'default',
                tickets: [],
                offerSentNow: [],
                search: this.defaultSearch,
                countSearch: 0,
                user: this.$root.user
            }
        },
        computed: {
            ticketsWithOffers() {
                // Add offer information to each ticket
                var tickets = this.tickets;
                if (this.user == null || this.user.offers_sent === {} ) return tickets;
                for (var i = 0; i < tickets.length; i++) {
                    for (var key in this.user.offers_sent) {
                        if (this.user.offers_sent[key].ticket_id == tickets[i].id) {
                            tickets[i].discussionId = this.user.offers_sent[key].id;
                            tickets[i].offerStatus = this.user.offers_sent[key].status;
                            tickets[i].offerPrice = this.user.offers_sent[key].price;
                        }
                    }
                }
                return tickets;
            }
        },
        mounted(){
           this.searchTickets();
        },
        methods: {
            changeDeparture(station) {
                this.search.departure_station = station;
            },
            changeArrival(station) {
                this.search.arrival_station = station;
            },
            changeDate(date) {
                this.search.trip_date = date;
            },
            changeTime(time) {
                this.search.trip_time = time;
            },
            searchTickets() {
                if (this.state != 'default' && this.state != 'result') return null;
                this.searchError = false;

                this.state = 'searching';
                this.$http.get(this.route('api.tickets.buy'),  {params: this.search})
                    .then(response => {
                        function compare(a, b) {
                            if (a.train.departure_date < b.train.departure_date)
                                return -1;
                            if (a.train.departure_date > b.train.departure_date)
                                return 1;
                            return 0;
                        }

                        this.countSearch++;
                        this.state = 'result';
                        this.tickets = response.data.data.sort(compare);
                    }, response => {
                        console.log(response)
                    });
            }
        }
    }
</script>