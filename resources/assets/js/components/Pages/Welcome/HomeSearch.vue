<template>
    <div class="col-12" id="home-search">
        <div id="action-content">
            <vue-form :action="this.route('public.ticket.buy.page')"
                      method="GET"
                      :callback="this.$parent.logEvent('ticket_search',this.formContent)"
                      :submit-after-callback="true"
            >
                <div class="row text-left justify-content-center">
                    <input-station name="departure_station"
                                   :label="trans('tickets.buy.inputs.homepicker.depart')"
                                   class-name="col-sm-3"
                                   validation="required"
                                   default-value="4916"
                                   v-model="formContent.departure_station"
                    ></input-station>
                    <input-station name="arrival_station"
                                   :label="trans('tickets.buy.inputs.homepicker.arrival')"
                                   class-name="col-sm-3"
                                   validation="required"
                                   default-value="8267"
                                   v-model="formContent.arrival_station"
                    ></input-station>
                    <input-date
                            name="departure_date"
                            class-name="col-sm-3"
                            label="Date"
                            validation="required"
                            placeholder="DD/MM/YYYY"
                            format="dd/MM/yyyy"
                            value-format="dd/MM/yyyy"
                            default-value-format="DD/MM/YYYY"
                            :default-value="defaultDate"
                            :with-icon="true"
                            :picker-options="datePickerOptions"
                            v-model="formContent.trip_date"
                    ></input-date>

                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-input text-uppercase" id="btn-search" type="submit">
                            {{trans('tickets.buy.research')}}
                        </button>
                    </div>
                </div>
            </vue-form>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data() {
            return {
                formContent: {
                    departure_station: 4916,
                    arrival_station: 8267,
                    trip_date: moment().format('DD/MM/YYYY'),
                    trip_time: null,
                },
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
            defaultDate() {
                return moment().format('DD/MM/YYYY');
            }
        },
        methods: {

        }
    }
</script>