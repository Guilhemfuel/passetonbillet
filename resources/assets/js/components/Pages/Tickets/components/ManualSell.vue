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
                                            validation="required"
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
                                            validation="required|numeric">
                                </input-text>
                                <input-station name="departure_station"
                                               :label="trans('tickets.sell.manual.form.departure_station')"
                                               :placeholder="trans('tickets.sell.manual.form.departure_station')"
                                               validation="required"
                                               class="col-12 col-sm-6"
                                               :with-icon="false"
                                               v-model="departureStation"
                                               @change="changeStations"
                                ></input-station>
                                <input-station name="arrival_station"
                                               :label="trans('tickets.sell.manual.form.arrival_station')"
                                               :placeholder="trans('tickets.sell.manual.form.arrival_station')"
                                               validation="required"
                                               class="col-12 col-sm-6"
                                               :with-icon="false"
                                               v-model="arrivalStation"
                                               @change="changeStations"

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
                                              @input="changeProvider"
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
                                            validation="required|numeric"
                                            v-model="boughtPrice"
                                >
                                </input-text>
                                <input-text class="col-12 col-sm-6"
                                            name="price"
                                            :label="trans('tickets.sell.manual.form.price')"
                                            :placeholder="trans('tickets.sell.manual.form.price')"
                                            :validation="'required|max_value:'+boughtPrice"
                                >
                                </input-text>

                                <input-text class="col-12"
                                            name="cgu"
                                            type="checkbox"
                                            :label="trans('tickets.sell.manual.form.cgu')"
                                            validation="required">
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

            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: {},
        data() {
            return {
                user: this.$root.user,
                state: 'form',
                boughtPrice: 0,
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
                        label: 'Carte Jeune',
                        value: 'Carte Jeune'
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
                ],
                departureStation: null,
                arrivalStation: null,

                ukStationsIds: [
                    // London
                    5892, 7840, 8172, 8260, 8263, 8265, 8266, 8267, 8268, 8269, 8270, 8273, 8274, 22654, 25012, 25717, 25718, 25722, 25814,

                    // Ebbsfleet
                    8224,

                    // Ashford
                    8155, 8154,
                ],

                eurostarStationsIds: [
                    // Disney
                    4819, 4757,

                    // Lille Europe
                    4652, 123, 1326, 4616, 4653,

                    // Paris
                    4916, 4917, 4919, 4920, 4921, 4922, 4923, 4924, 23599, 34616, 34617, 34618, 34619,

                    // Calais
                    1417, 148, 1419,

                    // Avignon
                    489, 171, 485,

                    // Lyon
                    4718, 3652, 4022, 4676, 4677, 4699, 4717,

                    // Moutiers
                    23615, 5038,

                    // Bourg St Maurice
                    5028,

                    // Marseille
                    4790,  4116, 4117, 4723, 4791, 4947, 4948, 4949, 23020,

                    // Bruxelles
                    5974, 5893, 5971, 17738,

                    // Amsterdam
                    8657, 5894, 8609, 8643,

                ]
            }
        },
        computed: {},
        methods: {
            automaticTicketRetrieval() {
                this.$emit('automatic-retrieval');
            },
            changeProvider(provider) {
                if (provider == 'eurostar') {

                    let notification = this.$notify({
                        message: this.trans('tickets.sell.manual.eurostar_back_to_automatic'),
                        type: 'warning',
                        onClick: () => {
                            notification.close()
                        }
                    });

                    this.automaticTicketRetrieval();
                }
            },
            changeStations() {
                if ( (this.ukStationsIds.includes(this.arrivalStation) && this.eurostarStationsIds.includes(this.departureStation))
                    || (this.eurostarStationsIds.includes(this.arrivalStation) && this.ukStationsIds.includes(this.departureStation))
                ) {
                    let notification = this.$notify({
                        message: this.trans('tickets.sell.manual.eurostar_back_to_automatic'),
                        type: 'warning',
                        onClick: () => {
                            notification.close()
                        }
                    });

                    this.automaticTicketRetrieval();
                }
            }
        }
    }
</script>