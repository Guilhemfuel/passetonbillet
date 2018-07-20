<template>
    <div class="col-12" id="home-search">
        <div id="action-content">
            <vue-form action="d" :csrf-disabled="true" method="GET">
                <div class="row text-left justify-content-center">
                    <input-station name="departure_station"
                                   :label="lang.buy.inputs.homepicker.depart"
                                   class-name="col-sm-4"
                                   validation="required"
                    ></input-station>
                    <input-station name="arrival_station"
                                   :label="lang.buy.inputs.homepicker.depart"
                                   class-name="col-sm-4"
                                   validation="required"
                    ></input-station>
                    <input-date
                            name="departure_date"
                            class-name="col-sm-4"
                            label="Date"
                            validation="required|date_format:DD/MM/YYYY"
                            placeholder="DD/MM/YYYY"
                            format="dd/MM/yyyy"
                            value-format="dd/MM/yyyy"
                            default-value-format="DD/MM/YYYY"
                            :picker-options="datePickerOptions"
                    ></input-date>

                    <button class="btn btn-primary text-uppercase" id="btn-search" type="submit">
                        {{lang.buy.research}}
                    </button>
                </div>
            </vue-form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            state: {type: String, Default: 'buy', required: true},
        },
        data() {
            return {
                buyingState: 'default',
                sellState: 'default',
                sellingTickets: [],
                datePickerOptions: {
                    disabledDate: function (myDate) {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().startOf('day'));
                    },
                    firstDayOfWeek: 1
                },
            }
        },
        computed: {

        },
        methods: {
        }
    }
</script>