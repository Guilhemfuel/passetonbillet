<template>
    <div id="manual-ticket-sell">

        <h4 class="card-title mb-0">{{trans('tickets.sell.manual.title')}}</h4>

        <div class="card">
            <div class="card-body">

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='form'">
                        <p>{{trans('tickets.sell.manual.text')}}</p>
                        <a href="#" @click.prevent="automaticTicketRetrieval()">{{trans('tickets.sell.manual.back_link')}}</a>

                        <vue-form class="mt-4" method="POST" :action="this.route('public.ticket.sell.manual')">
                            <div class="row">
                                <div class="col-12">
                                     <h4>{{trans('tickets.sell.manual.form.title_travel')}}</h4>
                                </div>
                                <input-date class="col-12 col-sm-6"
                                            name="travel_date"
                                            :label="trans('tickets.sell.manual.form.travel_date')"
                                            validation="required|date_format:DD/MM/YYYY"
                                            placeholder="DD/MM/YYYY"
                                            format="dd/MM/yyyy"
                                            value-format="dd/MM/yyyy"
                                            default-value-format="DD/MM/YYYY"
                                            :picker-options="datePickerOptions"
                                ></input-date>
                                <input-text class="col-12 col-sm-6"
                                            name="train_number"
                                            :label="trans('tickets.sell.manual.form.train_number')"
                                            :placeholder="trans('tickets.sell.manual.form.train_number')"
                                            validation="required">
                                </input-text>
                                <input-station name="departure_station"
                                               :label="trans('tickets.sell.manual.form.departure_station')"
                                               :placeholder="trans('tickets.sell.manual.form.departure_station')"
                                               validation="required"
                                               class="col-12 col-sm-6"
                                               :with-icon="false"
                                ></input-station>
                                <input-station name="arrival_station"
                                               :label="trans('tickets.sell.manual.form.arrival_station')"
                                               :placeholder="trans('tickets.sell.manual.form.arrival_station')"
                                               validation="required"
                                               class="col-12 col-sm-6"
                                               :with-icon="false"
                                ></input-station>
                                <input-time class="col-12 col-sm-6"
                                            name="departure_time"
                                            :label="trans('tickets.sell.manual.form.departure_time')"
                                            placeholder="12:00"
                                            validation="required"
                                ></input-time>
                                <input-time class="col-12 col-sm-6"
                                            name="arrival_time"
                                            :label="trans('tickets.sell.manual.form.arrival_time')"
                                            placeholder="12:00"
                                            validation="required"
                                ></input-time>

                                <div class="col-12">
                                    <h4>{{trans('tickets.sell.manual.form.title_ticket')}}</h4>
                                </div>
                                <input-select class="col-12 col-sm-6"
                                              name="company"
                                              :label="trans('tickets.sell.manual.form.company')"
                                              :placeholder="trans('tickets.sell.manual.form.company')"
                                              :options="providers"
                                              validation="required"
                                ></input-select>
                                <input-select class="col-12 col-sm-6"
                                              name="flexibility"
                                              :label="trans('tickets.sell.manual.form.flexibility')"
                                              :placeholder="trans('tickets.sell.manual.form.flexibility')"
                                              :options="flexibility"
                                              validation="required"
                                ></input-select>
                                <input-select class="col-12 col-sm-6"
                                              name="classe"
                                              :label="trans('tickets.sell.manual.form.classe')"
                                              :placeholder="trans('tickets.sell.manual.form.classe')"
                                              :options="classe"
                                              validation="required"
                                ></input-select>
                                <input-currency class="col-12 col-sm-6"
                                              name="currency"
                                              :label="trans('tickets.sell.manual.form.currency')"
                                              :placeholder="trans('tickets.sell.manual.form.currency')"
                                              validation="required"
                                ></input-currency>
                                <input-text class="col-12 col-sm-6"
                                            name="bought_price"
                                            :label="trans('tickets.sell.manual.form.bought_price')"
                                            :placeholder="trans('tickets.sell.manual.form.bought_price')"
                                            validation="required|numeric">
                                </input-text>
                                <input-text class="col-12 col-sm-6"
                                            name="price"
                                            :label="trans('tickets.sell.manual.form.price')"
                                            :placeholder="trans('tickets.sell.manual.form.price')"
                                            validation="required|numeric">
                                </input-text>



                                <div class="col-12">
                                    <button class="btn btn-ptb btn-block">
                                        Sell your ticket
                                    </button>
                                </div>
                            </div>
                        </vue-form>
                    </div>
                </transition>

                <!--<transition enter-class="pre-animated"-->
                <!--enter-active-class="animated fadeIn"-->
                <!--leave-active-class="animated fadeOut">-->
                <!--<div v-if="state=='select'">-->
                <!---->
                <!--</div>-->
                <!--</transition>-->

            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: {
        },
        data() {
            return {
                user: this.$root.user,
                state: 'form',
                form: {},
                datePickerOptions: {
                    disabledDate: function (myDate) {
                        // Disable all date before today
                        return moment(myDate).isBefore(moment().startOf('day'));
                    },
                    firstDayOfWeek: 1
                },
                providers: [
                    {
                        label: 'SNCF / Ouigo',
                        value: 'sncf'
                    },
                    {
                        label: 'Eurostar',
                        value: 'eurostar'
                    },
                    {
                        label: 'Thalys',
                        value: 'thalys'
                    }
                ],
                flexibility: [
                    {
                        label: 'Prem\'s',
                        value: 'Prem\'s'
                    },
                    {
                        label: 'Loisir',
                        value: 'Loisir'
                    },
                    {
                        label: 'Pro',
                        value: 'Pro'
                    },
                    {
                        label: 'No Flex',
                        value: 'No Flex'
                    },
                    {
                        label: 'Semi Flex',
                        value: 'Semi Flex'
                    },
                    {
                        label: 'Ouigo',
                        value: 'Ouigo'
                    },
                    {
                        label: 'Normal',
                        value: 'Normal'
                    },
                    {
                        label: 'Autre',
                        value: 'Autre'
                    }
                ],
                classe: [
                    {
                        label: '2nd classe',
                        value: '2nd classe'
                    },
                    {
                        label: '1ère classe',
                        value: '1ère classe'
                    },
                    {
                        label: 'Standard',
                        value: 'Standard'
                    },
                    {
                        label: 'Business Premier',
                        value: 'Business Premier'
                    },
                    {
                        label: 'Standard Premier',
                        value: 'Standard Premier'
                    }
                ]
            }
        },
        computed: {},
        methods: {
            automaticTicketRetrieval() {
                this.$emit('automatic-retrieval');
            }
        }
    }
</script>