<template>
    <div class="col-12" id="home-search">
        <div id="action-content">
            <vue-form :action="this.route('public.ticket.buy.page')" :csrf-disabled="true" method="GET">
                <div class="row text-left justify-content-center">
                    <input-station name="departure_station"
                                   :label="trans('tickets.buy.inputs.homepicker.depart')"
                                   class-name="col-sm-3"
                                   validation="required"
                                   default-value="4916"
                    ></input-station>
                    <input-station name="arrival_station"
                                   :label="trans('tickets.buy.inputs.homepicker.arrival')"
                                   class-name="col-sm-3"
                                   validation="required"
                                   default-value="8267"
                    ></input-station>
                    <input-date
                            name="departure_date"
                            class-name="col-sm-3"
                            label="Date"
                            validation="required|date_format:DD/MM/YYYY"
                            placeholder="DD/MM/YYYY"
                            format="dd/MM/yyyy"
                            value-format="dd/MM/yyyy"
                            default-value-format="DD/MM/YYYY"
                            :default-value="defaultDate"
                            :with-icon="true"
                            :picker-options="datePickerOptions"
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
        methods: {}
    }
</script>