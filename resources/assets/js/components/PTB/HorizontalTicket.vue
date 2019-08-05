<template>
    <div class="ticket-horizontal">
        <div class="container">
            <div class="row">
                <div class="trip-info d-flex">
                    <div class="price-duration">
                        <p class="price">{{ticket.bought_currency_symbol}}{{ticket.price}}</p>
                        <p class="duration">{{duration}}</p>
                    </div>
                    <svg height="100" width="30">
                        <polygon points="0,0 0,100 30,0 " style="fill:white;"/>
                    </svg>
                    <div class="trip col">
                        <div class="row justify-content-center align-content-center d-md-flex d-none">
                            <div class="from">
                                <p class="city">{{ticket.train.departure_city.name}}</p>
                                <p class="time">{{departure_time}}</p>
                            </div>
                            <div class="arrow px-2">
                                <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                            </div>
                            <div class="to">
                                <p class="city">{{ticket.train.arrival_city.name}}</p>
                                <p class="time">{{arrival_time}}</p>
                            </div>
                        </div>
                        <div class="row flex-column justify-content-center align-content-center mobile-view d-md-none d-flex">
                            <div class="from d-flex">
                                <p class="city">{{ticket.train.departure_city.name}}</p>
                                <p class="time">{{departure_time}}</p>
                            </div>
                            <div class="to d-flex">
                                <p class="city">{{ticket.train.arrival_city.name}}</p>
                                <p class="time">{{arrival_time}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col justify-content-between d-flex">

                    <template v-if="!contact">
                        <!-- Displaying information -->
                        <div class="user-info d-flex">
                            <div class="user-picture">
                                <img :src="ticket.user.picture" alt="seller profile picture"/>
                                <div class="user-verification">
                                    <div class="white-bg"></div>
                                    <el-tooltip v-if="ticket.user.verified" class="item" effect="dark"
                                                :content="trans('tickets.component.user_verified')"
                                                placement="bottom-end">
                                        <i aria-hidden="true"
                                           class="fa fa-check-circle text-success verif-status"></i>

                                    </el-tooltip>
                                    <el-tooltip v-else-if="ticket.user.verification_pending" class="item" effect="dark"
                                                :content="trans('tickets.component.user_verification_pending')"
                                                placement="bottom-end">
                                        <i aria-hidden="true"
                                           class="fa fa-clock-o text-primary verif-status"></i>

                                    </el-tooltip>
                                    <el-tooltip v-else class="item" effect="dark"
                                                :content="trans('tickets.component.user_not_verified')"
                                                placement="bottom-end">
                                        <i class="fa fa-exclamation-triangle text-danger verif-status"
                                           aria-hidden="true"></i>
                                    </el-tooltip>
                                </div>
                            </div>
                            <div class="user-name col">
                                <p class="name">{{ticket.user.first_name}}</p>
                                <p class="published-date" v-html="publishedBy"></p>
                            </div>
                        </div>

                        <div class="security-info d-flex">
                            <!-- Security info regarding seller -->

                            <div class="shield mr-3" @click="showSecurity=true" v-if="!showSecurity">
                                <el-tooltip class="item" effect="dark"
                                            :content="trans('tickets.component.security_infos')">
                                    <i class="fa fa-shield" aria-hidden="true"></i>
                                </el-tooltip>
                            </div>

                            <div class="seller-details d-flex" v-if="showSecurity">
                                <div class="col">
                                    <p class="mb-0 mt-2">Facebook<br>Connect</p>
                                    <p class="value mb-0">
                                        <i class="fa fa-facebook-square" aria-hidden="true"
                                           v-if="ticket.user.fb_connect"></i>
                                        <span class="fa-stack fa-lg no-fb-connect" v-else>
                                          <i class="fa fa-facebook-square fa-stack-1x"></i>
                                          <i class="fa fa-ban fa-stack-2x text-danger"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="mb-0 mt-2" v-html="trans('tickets.component.seller_ticket_sold')"></p>
                                    <p class="value mb-0">
                                        {{ticket.user.ticket_sold}}
                                    </p>
                                </div>
                                <div class="col">
                                    <p class="mb-0 mt-2" v-html="trans('tickets.component.member_since')"></p>
                                    <p class="value mb-0">
                                        {{ticket.user.register_date}}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="action-type d-flex">
                            <p v-if="!showSecurity" class="ticket-type"
                               v-html="trans('tickets.component.type.second_hand')">
                            </p>
                            <button class="btn btn-ptb btn-upper ml-3" @click.prevent="contactSeller()">
                                {{trans('tickets.component.contact')}}
                            </button>
                        </div>

                    </template>

                    <template v-else>

                        <!-- Offer already done -->
                        <div class="offer-form" v-if="offerJustSent">
                            <p class="mb-0 text-center text-success text-ticket-sent">
                                {{trans('tickets.component.offer_sent')}}
                            </p>
                        </div>

                        <!-- Contacting seller -->
                        <div class="offer-form" v-else-if="!showRegister">
                            <vue-form class="row">
                                <div class="col-4">
                                    <input-text
                                            :disabled="offer_done||offer_accepted"
                                            class-name="mb-0"
                                            v-model="priceOffer"
                                            type="text"
                                            name="price"
                                            :default-value="corresponding_user_offer && corresponding_user_offer.status != -1 ? corresponding_user_offer.price.toString() : ticket.price.toString()"
                                            :placeholder="trans('tickets.component.price')"
                                            :validation="'required|numeric|min_value:0|max_value:'+ticket.price">
                                        <template slot="prepend">
                                            <span>{{ticket.currency_symbol}}</span>
                                        </template>
                                    </input-text>
                                </div>
                                <div class="col-8 pl-0">
                                    <!-- Different buttons for different states of offer -->
                                    <button class="btn btn-secondary btn-block px-1 btn-upper btn-offer text-white"
                                            @click.prevent=""
                                            v-if="offer_done"
                                            disabled
                                    >
                                        <i class="fa fa-clock-o text-white" aria-hidden="true"></i>
                                        {{trans('tickets.component.status.awaiting')}}
                                    </button>
                                    <a class="btn btn-success px-1 btn-upper btn-offer text-white px-3"
                                            v-else-if="offer_accepted"
                                       :href="route('public.message.discussion.page',[ticket.id, corresponding_user_offer.id])"
                                    >
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                        {{trans('tickets.component.status.accepted')}}
                                    </a>
                                    <button class="btn btn-light-gray btn-block px-1 btn-upper btn-offer"
                                            @click.prevent="makeOffer" v-else>
                                        <span v-if="!loading">{{trans('tickets.component.send_offer')}}</span>
                                        <loader v-else class-name="loader-btn mx-auto"></loader>
                                    </button>
                                </div>
                            </vue-form>

                        </div>

                        <div class="offer-form" v-else-if="showRegister">
                            <p class="mb-0 text-center">
                                {{trans('tickets.component.register')}}
                                <a :href="route('register.page')+'?source=guest-offer'">
                                    {{trans('tickets.component.register_cta')}}
                                </a>
                            </p>
                        </div>

                        <div class="help" @click.prevent="modalExplanationOpened=true">
                            <i class="fa fa-question" aria-hidden="true"></i>
                        </div>
                        <div class="call">
                            <button class="btn btn-ptb btn-upper" >
                                {{trans('tickets.component.buying_actions.call.btn')}}
                            </button>
                        </div>
                    </template>

                </div>
            </div>
        </div>

        <!-- Modal explanation -->
        <modal :is-open="modalExplanationOpened"
               :title="trans('tickets.component.help_modal.title')"
               @close-modal="modalExplanationOpened=false"
        >

            <div class="row">
                <div class="col-md-4 col-12 text-center py-3">
                    <button class="btn btn-light-gray px-1 btn-upper btn-offer px-3">
                        {{trans('tickets.component.send_offer')}}
                    </button>
                </div>
                <div class="col-md-8 col-12">
                    <h4>{{trans('tickets.component.help_modal.offer.title')}}</h4>
                    <p>{{trans('tickets.component.help_modal.offer.content')}}</p>
                </div>
                <div class="col-md-4 col-12 text-center py-3">
                    <button class="btn btn-ptb btn-upper">
                        {{trans('tickets.component.buying_actions.call.btn')}}
                    </button>
                </div>
                <div class="col-md-8 col-12">
                    <h4>{{trans('tickets.component.help_modal.call.title')}}</h4>
                    <p>{{trans('tickets.component.help_modal.call.content')}}</p>
                </div>
            </div>

        </modal>
    </div>

</template>

<script>

    export default {
        props: {
            ticket: {type: Object, required: true},
        },
        data() {
            return {
                user: this.$root.user,
                showSecurity: false,
                contact: false,

                modalExplanationOpened: false,
                offerJustSent: false,
                showRegister: false,
                loading: false,

                priceOffer: this.ticket.price
            }
        },
        mounted() {
            if (!this.ticket.currency) {
                this.ticket.currency = this.ticket.bought_currency;
            }
            if (!this.ticket.currency_symbol) {
                this.ticket.currency_symbol = this.ticket.bought_currency_symbol;
            }
        },
        computed: {
            corresponding_user_offer() {
                if (this.user) {
                    if (this.user.offers_sent && Array.isArray(this.user.offers_sent)
                        && this.user.offers_sent.length > 0) {
                        let ticketsId = this.user.offers_sent.map(a => a.ticket ? a.ticket.id : a.ticket_id);

                        if (ticketsId.includes(this.ticket.id)) {
                            return this.user.offers_sent[ticketsId.indexOf(this.ticket.id)];
                        }
                    }
                }
                return null;
            },
            offer_done: function () {
                return this.corresponding_user_offer.status == 0 || this.corresponding_user_offer.status == null;
            },
            offer_accepted: function () {
                return this.corresponding_user_offer.status == 1;
            },
            offer_refused: function () {
                return this.corresponding_user_offer.status == -1;
            },
            arrival_time: function () {
                return moment(this.ticket.train.arrival_time, 'HH:mm:ss').format('HH:mm')
            },
            departure_time: function () {
                return moment(this.ticket.train.departure_time, 'HH:mm:ss').format('HH:mm')
            },
            duration: function () {
                return Math.floor(this.ticket.train.duration / 60) + 'h' + (this.ticket.train.duration % 60);
            },
            pastTicket: function () {
                var now = moment();
                var departure = moment(this.ticket.departure_date + ' ' + this.departure_time, 'YYYY-MM-DD HH:mm');
                return now.isAfter(departure.subtract(2, 'h'))
            },
            offerDone: function () {
                if (this.buying && this.user) {
                    if (this.user.offers_sent && Array.isArray(this.user.offers_sent)
                        && this.user.offers_sent.length > 0 && this.user.offers_sent.map(a => a.ticket_id).includes(this.ticket.id)) {
                        this.user.offers_sent.forEach((offer) => {
                            if (offer.ticket_id == this.ticket.id && offer.status != -1) {
                                return true;
                            }
                        });
                    }
                }
                return false;
            },
            publishedBy: function () {
                let trans = this.trans('tickets.component.sold_ago');

                if (this.ticket.created_at) {
                    return trans.replace('{{days}}', moment(this.ticket.created_at.date).fromNow(true));
                } else {
                    return trans.replace('{{days}}', moment().fromNow(true));
                }
            },
            userIsOwner: function () {
                return (this.user != null && this.ticket.user && this.ticket.user.id == this.user.id)
            }
        },
        methods: {
            ucFirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
            contactSeller() {
                this.contact = true;

                // Log Offer
                this.$root.logEvent('show_ticket_contact', {
                    ticket_id: this.ticket.id
                });
            },
            callSeller() {
                this.buyingState = 'call';
                this.editing = true;

                // Query contact number if null
                if (this.contactNumber == null) {

                    this.$http.get(this.route('api.tickets.phone_number', {
                        ticket: this.ticket.id
                    })).then((response) => {
                        // Success in offer
                        if (response.ok) {

                            this.contactNumber = response.body.phone;

                            // Log Offer
                            this.$root.logEvent('show_number', {
                                ticket_id: this.ticket.id
                            });

                            // Expire number after 3 minutes
                            setTimeout(() => {
                                this.contactNumber = null;
                            }, 3 * 60 * 1000);

                            return;
                        } else {
                            this.editing = false;
                            this.$message({
                                dangerouslyUseHTMLString: true,
                                message: response.body.message,
                                type: 'error',
                                showClose: true,
                                duration: 1000
                            });
                        }
                    }, response => {
                        if (!response.ok) {
                            this.editing = false;
                            this.$message({
                                dangerouslyUseHTMLString: true,
                                message: response.body.message,
                                type: 'error',
                                showClose: true,
                                duration: 1000
                            });
                        }
                    });
                }
            },
            makeOffer() {

                // Show register
                if (this.user == undefined || this.user == null) {
                    this.showRegister = true;
                    return;
                }

                // Send request
                this.$validator.validateAll().then((result) => {
                    this.loading = true;
                    this.$http.post(this.route('api.tickets.offer'), {
                        price: this.priceOffer,
                        ticket_id: this.ticket.id
                    }).then((response) => {
                        // Success in offer
                        if (response.ok) {


                            // Log Offer
                            this.$root.logEvent('send_offer', {
                                price: this.priceOffer,
                                currency: this.ticket.currency,
                                ticket_id: this.ticket.id
                            });

                            // Emit to reflect changes in parents
                            this.$emit('make-offer', {
                                price: this.priceOffer,
                                ticket_id: this.ticket.id
                            });

                            // Push offer to user's offer
                            this.user.offers_sent.push(response.body.data);
                            this.offerJustSent = true;
                            this.loading = false;

                            return;
                        } else {
                            this.loading = false;
                            this.$message({
                                message: response.body.message ? response.body.message : this.trans('common.error'),
                                type: 'error',
                                duration: 5000
                            });
                        }
                    }, response => {
                        if (!response.ok) {
                            this.loading = false;
                            this.$message({
                                message: response.body.message ? response.body.message : this.trans('common.error'),
                                type: 'error',
                                duration: 5000
                            });
                        }
                    });
                });
            }
        }
    }
</script>