<template>
    <div class="col-12">

        <h1 class="card-title mb-0">{{trans('tickets.buy.title')}}</h1>

        <div class="card">
            <div class="card-body">
                <form class="row px-3">
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
                        <button class="btn btn-ptb-blue btn-block d-block d-md-none btn-upper"
                                @click.prevent="searchTickets">
                            <span v-if="!loading">{{trans('tickets.buy.research')}}</span>
                            <loader v-else class-name="loader-btn mx-auto"></loader>
                        </button>
                        <button class="btn btn-ptb-blue d-none d-md-block mt-3 px-4 mx-auto btn-upper"
                                @click.prevent="searchTickets">
                            <span v-if="!loading">{{trans('tickets.buy.research')}}</span>
                            <loader v-else class-name="loader-btn"></loader>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">
            <date-selector :loading="loading" :date="search.trip_date"
                           v-on:change-date="changeDate($event,true)"></date-selector>
        </div>

        <alert-modal :default-departure-station="defaultSearch?defaultSearch.departure_station:null"
                     :default-arrival-station="defaultSearch?defaultSearch.arrival_station:null"
                     :default-trip-date="defaultSearch?defaultSearch.trip_date:null"
        >

            <div class="container-fluid card card-alert">
                <div class="row card-body p-3 px-4">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="icon-alert">
                            <i aria-hidden="true" class="fa fa-bell"></i>
                        </div>
                    </div>
                    <div class="col">
                        <p class="mb-0 alert-block-text">
                                   <span class="alert-catchline text-primary">
                                       {{trans('tickets.alerts.catchline_text')}}
                                   </span> <br>
                            {{trans('tickets.alerts.action_text')}}
                        </p>
                    </div>
                    <div class="d-md-flex d-none justify-content-center align-items-center">
                        <button class="btn btn-ptb btn-upper">
                            {{trans('tickets.alerts.create_alert')}}
                        </button>
                    </div>

                    <div class="col-12 d-flex d-md-none justify-content-center align-items-center py-3">
                        <button class="btn btn-ptb btn-upper">
                            {{trans('tickets.alerts.create_alert')}}
                        </button>
                    </div>
                </div>

            </div>
        </alert-modal>


        <train-results @loading="trainTicketLoading=$event" :search-value="search"></train-results>


        <!--<transition enter-class="pre-animated"-->
        <!--enter-active-class="animated fadeInUpBig"-->
        <!--leave-active-class="animated fadeOut">-->
        <!--<div class="row mt-4 row-ticket" v-if="ticketsWithOffers.length > 0">-->
        <!--<div class="col-12 col-sm-12 col-md-6 col-lg-4 px-md-3 row-item-ticket"-->
        <!--v-for="ticket in ticketsWithOffers"-->
        <!--:key="ticket.id">-->
        <!--<ticket :ticket="ticket"-->
        <!--:buying="true"-->
        <!--class-name="mt-4"></ticket>-->
        <!--</div>-->
        <!--</div>-->
        <!--</transition>-->

    </div>
</template>

<script>
    import DateSelector from './components/DateSelector.vue';

    export default {
        components: {
            'date-selector': DateSelector,
        },
        props: {
            defaultSearch: {type: Object, required: true}
        },
        mounted() {
            // Adjust default date to today if needed
            if (this.defaultSearch.travel_date) {

                let defaultSearchDate = new moment(this.defaultSearch.travel_date, 'DD/MM/YYYY');
                if (defaultSearchDate.isBefore(new moment().startOf('day'))) {
                    this.search.travel_date = (new moment()).format('DD/MM/YYYY');
                }
            }
        },
        data() {
            return {
                search: this.defaultSearch,
                user: this.$root.user,
                trainTicketLoading: false,
            }
        },
        computed: {
            loading: function () {
                return this.trainTicketLoading;
            }
        },
        methods: {
            changeDeparture(station) {
                this.search.departure_station = station;
            },
            changeArrival(station) {
                this.search.arrival_station = station;
            },
            changeDate(date, refresh = false) {
                let old = this.search.trip_date;
                this.search.trip_date = date;

                if (refresh && old != date) {
                    this.searchTickets();
                }
            },
            changeTime(time) {
                this.search.trip_time = time;
            },
            searchTickets() {
                this.$nextTick(()=> {
                    this.$root.$emit('search',this.search);
                });
            }
        }
    }
</script>