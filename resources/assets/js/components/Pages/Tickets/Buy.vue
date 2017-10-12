<template>
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{lang.buy.title}}</h4>
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
                                v-on:change-time="changeTime($event)">
                                    <!--:default-depart="search.departure_station"-->
                                    <!--:default-arrival="search.arrival_station"-->
                        </datetimepicker>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-lastar-blue btn-block d-block d-md-none">{{lang.buy.research}}</button>
                        <button class="btn btn-lastar-blue d-none d-md-block mt-4 px-4 pull-right">{{lang.buy.research}}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-6 col-lg-4" v-for="ticket in tickets">
                <ticket :ticket="ticket" :lang="lang.component"></ticket>
            </div>
        </div>

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
            csrf: {type: String, required: true},
           // defaultTickets: {type: Array, required: true}
        },
        data() {
            return {
                state: 'default',
                tickets: null,
                search: {
                    departure_station: null,
                    arrival_station: null,
                    trip_date: null,
                    trip_time: null,
                }
            }
        },
        created() {
            this.search.departure_station = this.user.language == 'FR'?this.getParisId:this.getLondonId;
            this.search.arrival_station = this.user.language == 'FR'?this.getLondonId:this.getParisId;
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
                this.search.trip_date = date;
            },
            changeTime(time){
                this.search.trip_time = time;
            },
        }
    }
</script>