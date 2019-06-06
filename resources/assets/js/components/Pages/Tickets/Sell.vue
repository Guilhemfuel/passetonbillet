<template>
    <div class="col-12">
        <!-- Input and ticket selecting -->

        <h1 class="card-title mb-3" v-if="state=='input'">{{trans('tickets.sell.step_1')}}</h1>
        <h1 class="card-title mb-3" v-else-if="state=='select'">{{trans('tickets.sell.step_1')}}</h1>
        <h1 class="card-title mb-3" v-else-if="state=='searching'">{{trans('tickets.sell.searching')}}</h1>

        <!-- NAME + REFERENCE -->
        <div class="card" v-if="startCardVisible">
            <div class="card-body">
                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='input'">
                        <p class="card-text text-justify">
                            {{trans('tickets.sell.description')}}
                        </p>

                        <div class="row justify-content-center">
                            <form class="col-sm-12 col-md-10 col-lg-6">
                                <div class="col-xs-12 form-group">

                                    <input-text id="email" validation="required|email"
                                                class="animated pulse"
                                                type="email"
                                                :label="trans('tickets.sell.inputs.email')"
                                                :placeholder="trans('tickets.sell.inputs.email')"
                                                v-model="form.email"
                                                required
                                                name="email"
                                                :default-value="form.email"
                                                v-if="formExtraFields"
                                    ></input-text>

                                    <input-text id="last_name" validation="required"
                                                :label="trans('tickets.sell.inputs.last_name')"
                                                :placeholder="trans('tickets.sell.inputs.last_name')"
                                                v-model="form.last_name"
                                                required
                                                name="last_name"
                                                :default-value="form.last_name"
                                    ></input-text>

                                </div>
                                <div class="col-xs-12 form-group">

                                    <input-text id="booking_code" validation="required|max:6|min:6"
                                                :label="trans('tickets.sell.inputs.booking_code')"
                                                placeholder="ex: QNUSHT"
                                                v-model="form.booking_code"
                                                required
                                                name="booking_code"
                                                :default-value="form.booking_code"
                                                :help="trans('tickets.sell.help_booking_code')"
                                    >

                                    </input-text>

                                </div>
                                <button type="submit" class="btn btn-ptb-blue btn-block" @click.prevent="search">
                                    {{trans('tickets.sell.search')}}
                                </button>
                            </form>
                        </div>
                    </div>

                </transition>

                <!-- LOADING -->

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='searching'">
                        <div class="p-5">
                            <loader :class-name="'mx-auto'"></loader>
                        </div>
                    </div>
                </transition>

                <!-- SELECT TICKET -->

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='select'">
                        <p class="card-text text-justify">
                            {{trans('tickets.sell.select')}}
                        </p>
                    </div>
                </transition>

            </div>

        </div>

        <!-- SELECT TICKET -->

        <template v-if="state=='select' && tickets.length>1">
            <div class="row mt-4 px-sm-4 px-md-0">
                <div v-for="(ticket,index) in tickets" class="col-12 col-sm-6 col-lg-6 col-xl-4" :key="index">
                    <ticket :ticket="ticket" :selecting="true"
                            v-on:sell="sell(ticket.id)"></ticket>
                </div>
            </div>
        </template>

        <!-- selling details and confirm sale -->
        <div class="row" v-if="state=='selling_details'">
            <div class="col-12 mb-3">
                <h4 class="card-title mb-0">
                    {{trans('tickets.sell.step_2')}}
                </h4>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-justify">
                            {{trans('tickets.sell.details')}}
                        </p>
                        <vue-form method="post" :action="route('public.ticket.sell.post')" ref="sell_form">
                            <input type="hidden" name="index" :value="selectedTicket.id">

                            <div class="form-group">
                                <label>{{trans('tickets.sell.inputs.price')}}</label>
                                <div class="input-group">
                                    <!-- Todo: ajouter l'option de la currency-->
                                    <span class="input-group-addon">{{selectedTicket.bought_currency_symbol}}</span>
                                    <input type="text"
                                           :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                           :aria-label="trans('tickets.sell.inputs.price')"
                                           :placeholder="trans('tickets.sell.inputs.price')"
                                           v-model="selectedTicket.price"
                                           name="price"
                                           v-validate="'required|numeric|min_value:1'">
                                </div>
                                <span v-if="errors.has('price')" class="invalid-feedback">{{ errors.first('price')
                                    }}</span>
                            </div>

                            <input-text
                                    name="cgu"
                                    type="checkbox"
                                    :label="trans('tickets.sell.manual.form.cgu')"
                                    validation="required">
                            </input-text>

                            <button type="submit" class="btn btn-ptb btn-block mt-4">
                                {{trans('tickets.sell.submit')}}
                            </button>
                        </vue-form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <ticket :ticket="selectedTicket" :display="true"
                        class-name="mb-0 mt-sm-4 mt-md-0 max-sized"></ticket>
                <p class="text-center">{{trans('tickets.sell.preview')}}</p>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            user: {type: Object, required: true},
        },
        data() {
            return {
                csrf: window.csrf,
                state: 'input',
                form: {
                    email: null,
                    last_name: this.user.last_name,
                    first_name: this.user.first_name,
                    booking_code: null,
                    _token: this.csrf,
                },
                formExtraFields: false,
                tickets: [],
                selectedTicket: {},
            }
        },
        computed: {
            startCardVisible: function () {
                return ['input', 'searching', 'select'].includes(this.state);
            },
        },
        methods: {
            search() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.state = 'searching';
                        this.$http.post(this.api.tickets.search, this.form)
                            .then(response => {

                                if (response.ok) {
                                    if (response.data.data.length == 1) {
                                        this.state = 'selling_details';
                                        this.tickets = response.data.data;
                                        this.tickets[0].user = this.user;
                                        this.tickets[0].id = 0;
                                        this.tickets[0].currency = this.tickets[0].bought_currency;
                                        this.tickets[0].price = Math.floor(this.tickets[0].bought_price);
                                        this.selectedTicket = this.tickets[0];
                                    } else {
                                        this.state = 'select';
                                        for (var i = 0; i < response.data.data.length; i++) {
                                            response.data.data[i].id = i;
                                            this.tickets.push(response.data.data[i]);
                                        }
                                    }
                                }
                            }, response => {

                                // Extra form of fields not present yet, we add them
                                if (! this.formExtraFields) {
                                    this.formExtraFields = true;
                                    this.form.email = this.user.email;
                                    this.$notify({
                                        title: this.trans('tickets.sell.manual.fail_retrieval.title'),
                                        message: this.trans('tickets.sell.manual.fail_retrieval.message_extra_fields'),
                                        type: 'warning',
                                    });
                                } else {
                                    this.$notify({
                                        title: this.trans('tickets.sell.manual.fail_retrieval.title'),
                                        message: this.trans('tickets.sell.manual.fail_retrieval.message'),
                                        type: 'warning',
                                    });
                                }

                                this.state = 'input';
                                return;
                            });

                    }
                }, response => {
                    this.$notify({
                        title: this.trans('tickets.sell.manual.fail_retrieval.title'),
                        message: this.trans('tickets.sell.manual.fail_retrieval.message'),
                        type: 'warning',
                    });
                    this.state = 'input';
                });
            },
            sell(id) {
                this.selectedTicket = this.tickets[id];
                this.selectedTicket.user = this.user;
                this.selectedTicket.currency = this.selectedTicket.bought_currency;
                this.selectedTicket.price = Math.floor(this.selectedTicket.bought_price);
                this.state = 'selling_details';
            },
        }
    }
</script>