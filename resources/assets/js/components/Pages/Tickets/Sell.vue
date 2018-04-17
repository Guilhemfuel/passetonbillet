<template>
    <div class="col-12">
        <!-- Input and ticket selecting -->

        <div class="card" v-if="startCardVisible">
            <div class="card-header reverse">
                <h4 class="card-title mb-0" v-if="state=='input'">{{lang.sell.title}}</h4>
                <h4 class="card-title mb-0" v-else-if="state=='select'">{{lang.sell.your_tickets}}</h4>
                <h4 class="card-title mb-0" v-else-if="state=='searching'">{{lang.sell.searching}}</h4>

            </div>
            <div class="card-body">
                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='input'">
                        <p class="card-text text-justify">
                            {{lang.sell.description}}
                        </p>

                        <p class="card-text text-justify text-danger" v-if="searchError">
                            {{lang.sell.errors.search}}
                        </p>

                        <div class="row justify-content-center">
                            <form class="col-sm-12 col-md-10 col-lg-6">
                                <div class="col-xs-12 form-group">
                                    <!-- Name input-->
                                    <el-tooltip class="item" effect="dark" :content="lang.sell.other_name"
                                                placement="top-start" v-if="!user.admin">
                                        <div>
                                        <input id="last_name" type="text"
                                               :class="{'form-control': true, 'is-invalid': errors.has('last_name') }"
                                               name="last_name" required v-validate="'required'"
                                               :placeholder="lang.sell.inputs.last_name" v-model="form.last_name"
                                               disabled>
                                        </div>
                                    </el-tooltip>
                                    <input v-else id="last_name" type="text"
                                           :class="{'form-control': true, 'is-invalid': errors.has('last_name') }"
                                           name="last_name" required v-validate="'required'"
                                           :placeholder="lang.sell.inputs.last_name" v-model="form.last_name">

                                    <span v-if="errors.has('last_name')"
                                          class="invalid-feedback">{{ errors.first('last_name')}}</span>
                                    <!--Reference number-->
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
                                    {{lang.sell.search}}
                                </button>
                            </form>
                        </div>
                    </div>

                </transition>

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='searching'">
                        <div class="p-5">
                            <loader :class-name="'mx-auto'"></loader>
                        </div>
                    </div>
                </transition>

                <transition enter-class="pre-animated"
                            enter-active-class="animated fadeIn"
                            leave-active-class="animated fadeOut">
                    <div v-if="state=='select'">
                        <p class="card-text text-justify">
                            {{lang.sell.select}}
                        </p>
                    </div>
                </transition>

            </div>

        </div>
        <template v-if="state=='select' && tickets.length>1">
            <div class="row mt-4">
                <div v-for="(ticket,index) in tickets" class="col-12 col-sm-6 col-lg-6 col-xl-4" :key="index">
                    <ticket :ticket="ticket" :lang="lang.component" :selecting="true"
                            v-on:sell="sell(ticket.id)"></ticket>
                </div>
            </div>
        </template>

        <!-- selling details and confirm sale -->
        <div class="row" v-if="state=='selling_details'">
            <div class="col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-header reverse">
                        <h4 class="card-title mb-0">
                            {{lang.sell.details_title}}
                        </h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text text-justify">
                            {{lang.sell.details}}
                        </p>
                        <form method="post" :action="routes.tickets.sell" ref="sell_form">
                            <input type="hidden" name="_token" :value="csrf">
                            <input type="hidden" name="index" :value="selectedTicket.id">

                            <div class="input-group">
                                <!-- Todo: ajouter l'option de la currency-->
                                <span class="input-group-addon">{{selectedTicket.bought_currency_symbol}}</span>
                                <input type="text" :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                       :aria-label="lang.sell.inputs.price"
                                       :placeholder="lang.sell.inputs.price"
                                       v-model="selectedTicket.price"
                                       name="price"
                                       v-validate="'required|numeric|max_value:'+selectedTicket.bought_price">
                            </div>
                            <span v-if="errors.has('price')" class="invalid-feedback">{{ errors.first('price') }}</span>

                            <!--<textarea class="form-control mt-4" :placeholder="lang.sell.inputs.notes"-->
                            <!--name="notes"></textarea>-->
                            <button type="submit" class="btn btn-pink btn-block mt-4" :disabled="selectedTicket.bought_price < selectedTicket.price" @click.prevent="sellTicket">
                                {{lang.sell.submit}}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <ticket :ticket="selectedTicket" :lang="lang.component"
                        class-name="mb-0 mt-sm-4 mt-md-0 max-sized"></ticket>
                <p class="text-center">{{lang.sell.preview}}</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            api: {type: Object, required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            user: {type: Object, required: true},
        },
        data() {
            return {
                csrf: window.csrf,
                state: 'input',
                form: {last_name: this.user.last_name, _token: this.csrf},
                tickets: [],
                selectedTicket: {},
                searchError: false
            }
        },
        computed: {
            startCardVisible: function () {
                return ['input', 'searching', 'select'].includes(this.state);
            },
        },
        methods: {
            search() {
                this.searchError = false;
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
                                this.searchError = true;
                                this.state = 'input';
                                return;
                            });
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
                this.selectedTicket.price = Math.floor(this.selectedTicket.bought_price);
                this.state = 'selling_details';
            },
            sellTicket() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.$refs.sell_form.submit();
                    }
                });
            }
        }
    }
</script>