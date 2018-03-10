<template>

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
                >
            </datetimepicker>
        </div>
    </form>

</template>

<script>
    var london_code = 7015400;
    var paris_code = 8727100;
    var bruxelles_code = 8814001;

    export default {
        props: {
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            user: {type: Object, required: false},
            stations: {type: Array, required: true},
            csrf: {type: String, required: true},
            // defaultTickets: {type: Array, required: true}
        },
        data() {
            return {
                state: 'default',
                tickets: [],
                search: {
                    departure_station: null,
                    arrival_station: null,
                    trip_date: null,
                    trip_time: null,
                },
            }
        },
        created() {
            this.search.departure_station = (this.user != undefined && this.user.language == 'FR') ? this.getParisId : this.getLondonId;
            this.search.arrival_station = (this.user != undefined && this.user.language == 'FR') ? this.getLondonId : this.getParisId;
            this.search.trip_date = moment().format('YYYY-MM-DD');
        },
        computed: {
            getLondonId() {
                for (var stationIndex in this.stations) {
                    if (this.stations[stationIndex].eurostar_id == london_code) {
                        return this.stations[stationIndex].id;
                    }
                }
                return null;
            },
            getParisId() {
                for (var stationIndex in this.stations) {
                    if (this.stations[stationIndex].eurostar_id == paris_code) {
                        return this.stations[stationIndex].id;
                    }
                }
                return null;
            },
            sortedStations() {

            }
        },
        mounted(){
          this.changeDeparture(this.search.departure_station);
          this.changeArrival(this.search.arrival_station);
          this.changeDate(this.search.trip_date);
        },
        methods: {
            changeDeparture(station) {
                this.$emit('change-departure', station);
            },
            changeArrival(station) {
                this.$emit('change-arrival', station);

            },
            changeDate(date) {
                this.$emit('change-date', moment(date).format('YYYY-MM-DD'));
            },
            changeTime(time) {
                this.$emit('change-time', time);
            },
            searchTickets() {
//                if (this.state!='default' && this.state!='result') return null;
//                this.searchError = false;
//
//                this.state = 'searching';
//                this.$http.post(this.api.tickets.buy, this.search)
//                    .then(response => {
//                        this.state='result';
//                        this.tickets = response.data.data;
//                    })
                console.log('searching');

            }
        }
    }
</script>