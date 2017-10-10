<template>
    <div class="col-12">
        <!-- Input and ticket selecting -->

        <div class="card" v-if="startCardVisible">
            <div class="row mr-0">
                <div class="col-sm-12 col-md-8">
                    <div class="card-body">
                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="state=='input'">
                                <h4 class="card-title">{{lang.sell.title}}</h4>

                                <p class="card-text text-justify">
                                    {{lang.sell.description}}
                                </p>

                                <form>
                                    <div class="col-xs-12 form-group">
                                        <input id="last_name" type="text"
                                               :class="{'form-control': true, 'is-invalid': errors.has('last_name') }"
                                               name="last_name" required v-validate="'required'"
                                               :placeholder="lang.sell.inputs.last_name" v-model="form.last_name">
                                        <span v-if="errors.has('last_name')"
                                              class="invalid-feedback">{{ errors.first('last_name')}}</span>

                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <input id="booking_code" type="text"
                                               :class="{'form-control': true, 'is-invalid': errors.has('booking_code') }"
                                               name="booking_code" required v-validate="'required|max:6|min:6'"
                                               :placeholder="lang.sell.inputs.booking_code" v-model="form.booking_code">
                                        <span v-if="errors.has('booking_code')"
                                              class="invalid-feedback">{{ errors.first('booking_code')}}</span>

                                    </div>
                                    <button type="submit" class="btn btn-lastar-blue btn-block" @click.prevent="search">
                                        Search Ticket
                                    </button>
                                </form>
                            </div>

                        </transition>

                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="state=='searching'">
                                <h4 class="card-title">Searching for your ticket(s)</h4>
                                <div class="p-5">
                                    <loader :class-name="'mx-auto'"></loader>
                                </div>
                            </div>
                        </transition>

                        <transition enter-class="pre-animated"
                                    enter-active-class="animated fadeIn"
                                    leave-active-class="animated fadeOut">
                            <div v-if="state=='select'">
                                <h4 class="card-title">Your tickets</h4>
                                <p class="card-text text-justify">
                                    Hooray ! We find your tickets. <br>
                                    Select the ticket you want to sell.
                                </p>
                            </div>
                        </transition>

                    </div>
                </div>
                <div class="d-none d-sm-none d-md-block col-md-4 bg-ticket-sell"></div>
            </div>
        </div>
        <template v-if="state=='select' && tickets.length>1">
            <div class="row mt-4">
                <div v-for="(ticket,index) in tickets" class="col-12 col-sm-6 col-lg-4" :key="index">
                    <ticket :ticket="ticket" :lang="lang.component" :selecting="true"
                            v-on:sell="sell(ticket.id)"></ticket>
                </div>
            </div>
        </template>

        <!-- selling details and confirm sale -->
        <div class="row" v-if="state=='selling_details'">
            <div class="col-12 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Ticket details
                        </h4>
                        <p class="card-text text-justify">
                            We're almost done! Just setup a price, and add notes if you want to. You can preview your changes directly on the ticket.
                        </p>
                        <form>
                            <div class="input-group">
                                <span class="input-group-addon">{{selectedTicket.bought_currency=='GBP'?'£':'€'}}</span>
                                <input type="text" class="form-control" aria-label="Selling price" v-model="selectedTicket.price">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <ticket :ticket="selectedTicket" :lang="lang.component" class-name="mb-0"></ticket>
                <p class="text-center">Ticket Preview</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            api: {type: Object, required: true},
            lang: {type: Object, required: true},
            user: {type: Object, required: true}

        },
        data() {
            return {
                state: 'input',
                form: {last_name: this.user.last_name},
                tickets: [],
                selectedTicket: {},
                searchError: false
            }
        },
        computed: {
            startCardVisible: function () {
                return ['input', 'searching', 'select'].includes(this.state);
            }
        },
        methods: {
            search() {
                this.searchError = false;
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.state = 'searching';
                        this.$http.post(this.api.tickets.search, this.form)
                            .then(response => {
                                if (!response.data.data.length > 0) {
                                    this.searchError = true;
                                    this.state = 'input';
                                    return;
                                }

                                if (response.data.data.length == 1) {
                                    this.state = 'selling_details';
                                    this.tickets = response.data.data;
                                    this.tickets[0].user = this.user;
                                    this.tickets[0].currency = this.tickets[0].bought_currency;
                                    this.tickets[0].price = this.tickets[0].bought_price;
                                    this.selectedTicket = this.tickets[0];
                                } else {
                                    this.state = 'select';
                                    for (var i = 0; i < response.data.data.length; i++) {
                                        response.data.data[i].id = i;
                                        this.tickets.push(response.data.data[i]);
                                    }
                                }

                                return;
                            })
                        this.loading = false;

                    }
                }, response => {
                    this.searchError = true;
                    this.state = 'input';
                });
            },
            sell(id) {
                this.selectedTicket = this.tickets[id];
                this.selectedTicket.user = this.user;
                this.selectedTicket.currency = this.selectedTicket.bought_currency;
                this.selectedTicket.price = this.selectedTicket.bought_price;
                this.state = 'selling_details';
            }
        }
    }
</script>