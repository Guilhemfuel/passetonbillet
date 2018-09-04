<template>
    <div class="flip-container">
        <div :class="{'flipper':true, 'flipped':editing}">

            <!-- Front of ticket -->

            <div :class="[className,{'card':true, 'card-ticket':true, 'front':true}]">
                <div class="card-travel-info">
                    <!-- Ribbon status of offer-->
                    <div :class="{'corner-ribbon':true,
                            'corner-ribbon-success':ticket.offerStatus==1,
                            'corner-ribbon-danger':ticket.offerStatus==-1}"
                         v-if="$lodash.has(ticket, 'offerStatus')">
                        <template v-if="ticket.offerStatus == 0">
                            <i class="fa fa-clock-o text-white" aria-hidden="true"></i><br>
                            <p>{{trans('tickets.component.status.awaiting')}}</p>
                        </template>
                        <template v-else-if="ticket.offerStatus == 1">
                            <i class="fa fa-check text-white" aria-hidden="true"></i><br>
                            <p>{{trans('tickets.component.status.accepted')}}</p>
                        </template>
                        <template v-else-if="ticket.offerStatus == -1">
                            <i class="fa fa-times text-white" aria-hidden="true"></i><br>
                            <p>{{trans('tickets.component.status.refused')}}</p>
                        </template>
                    </div>
                    <!-- Rest of front of ticket -->
                    <div class="day">
                        <span>{{date.format('D')}}</span>
                    </div>
                    <div class="month">
                        {{date.format('MMMM')}}
                    </div>
                    <div class="row cities">
                        <div class="col-5 departure">
                            <i class="fa fa-train fa-2x" aria-hidden="true"></i><br>
                            <span class="city">{{ticket.train.departure_city.name}}</span><br>
                            <span class="time">{{departure_time}}</span>
                        </div>
                        <div class="col-2 arrow">
                            <i class="fa fa-long-arrow-right fa-2x" aria-hidden="true"></i>
                        </div>
                        <div class="col-5 arrival">
                            <i class="fa fa-train fa-2x" aria-hidden="true"></i><br>
                            <span class="city">{{ticket.train.arrival_city.name}}</span><br>
                            <span class="time">{{arrival_time}}</span>
                        </div>
                    </div>
                </div>
                <div class="card-seller-info">
                    <!-- Discuss -->
                    <template v-if="!pastTicket && !display
                        && $lodash.has(ticket, 'discussionId')
                        && $lodash.has(ticket, 'offerStatus')
                        && ticket.offerStatus == 1">
                        <a v-if="ticket.id"
                           :href="route('public.message.discussion.page',[ticket.id, ticket.discussionId])"
                           class="btn btn-ptb btn-buy btn-sm">{{trans('tickets.component.discuss')}}</a>
                    </template>
                    <!-- Make Offer -->
                    <template v-else-if="!pastTicket && !display
                        && $lodash.has(ticket, 'discussionId')
                        && $lodash.has(ticket, 'offerStatus')
                        && ticket.offerStatus == -1">
                        <button class="btn btn-ptb btn-buy btn-sm" @click="editing=true">
                            {{trans('tickets.component.new_offer')}}
                        </button>
                    </template>
                    <!-- Buy/Sell/Download -->
                    <template v-else-if="!pastTicket && !display">
                        <button class="btn btn-ptb btn-buy btn-sm" v-if="!selecting && buying && !offerDone"
                                @click="editing=true">
                            {{trans('tickets.component.buy')}}
                        </button>
                        <button class="btn btn-ptb btn-buy btn-sm" v-if="selecting" @click.prevent="sell">
                            {{trans('tickets.component.sell')}}
                        </button>
                        <button class="btn btn-ptb btn-buy btn-sm" v-if="bought" @click="editing=true">
                            {{trans('tickets.component.infos')}}
                        </button>
                    </template>
                    <!-- Edit (in case of buying page, is a link-->
                    <template
                            v-if="!pastTicket && (user != null && ticket.user && ticket.user.id == user.id) && !display">
                        <button class="btn btn-ptb btn-buy btn-sm" @click="editing=true" v-if="!buying">
                            {{trans('tickets.component.edit')}}
                        </button>
                        <a class="btn btn-ptb btn-buy btn-sm" v-else
                           :href="route('public.ticket.owned.page')">{{trans('tickets.component.edit')}}</a>
                    </template>

                    <div class="price" v-if="!selecting">
                        <span>
                            <template v-if="ticket.offerPrice && ticket.offerPrice!=ticket.price">
                                <span class="old-price">{{ticket.currency_symbol}}{{ticket.price}}</span>
                                <span class="offer-price text-center">{{ticket.currency_symbol}}{{ticket.offerPrice}}</span>
                            </template>
                            <template v-else>
                            <span class="text-center"></span> {{ticket.currency_symbol}}{{ticket.price}}
                            </template>
                        </span>
                    </div>
                    <div class="price" v-if="selecting">
                        <span>{{ticket.bought_currency_symbol}}{{ticket.bought_price}}</span>
                    </div>
                    <div class="seller" v-if="!selecting">
                        <template v-if="user">
                            <a target="_blank"
                               :href="'/profile/user/'+ticket.user.hashid">{{publishedBy}} <b>{{ticket.user.full_name}}</b>
                                <el-tooltip v-if="ticket.user.verified" class="item" effect="dark"
                                            :content="trans('tickets.component.user_verified')"
                                            placement="bottom-end">
                                    <i aria-hidden="true"
                                       class="fa fa-check-circle text-warning"></i>

                                </el-tooltip>
                                <el-tooltip v-else class="item" effect="dark"
                                            :content="trans('tickets.component.user_not_verified')"
                                            placement="bottom-end">
                                    <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>
                                </el-tooltip>
                            </a>
                        </template>
                        <template v-else>
                            {{publishedBy}} <b>{{ticket.user.full_name}}</b> <i v-if="ticket.user.verified"
                                                                                aria-hidden="true"
                                                                                class="fa fa-check-circle text-warning"></i>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Back of ticket -->

            <div :class="{'card':true, 'card-ticket':true, 'back':true, className:className, 'past-ticket':pastTicket}"
                 v-if="editing">
                <!-----------

                 User bought ticket

                  --------->
                <template v-if="!(buying || ($lodash.has(ticket, 'discussionId')
                        && $lodash.has(ticket, 'offerStatus')
                        && ticket.offerStatus == -1 &&!pastTicket))">
                    <template v-if="bought">
                        <!-- once tiket was bought-->
                        <div class="card-travel-info">
                            <a href="#" class="float-left" @click.prevent="editing=false"><i
                                    class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i></a>
                            <p class="float-center text-center mb-0 edit-title">{{trans('tickets.component.infos')}}</p>
                        </div>
                        <div class="card-seller-info card-buying text-center">
                            <p class="text-center">
                                <a v-if="ticket.id"
                                   :href="route('public.message.discussion.page',[ticket.id, ticket.discussion_id])"
                                   class="btn btn-ptb btn-sm">{{trans('tickets.component.discuss')}}</a>
                            </p>
                        </div>
                    </template>
                    <template v-else>
                        <!--

                       =============== User modifying his ticket ===============

                       -->
                        <div class="card-travel-info">
                            <a href="#" class="float-left" @click.prevent="editing=false"><i
                                    class="fa fa-chevron-circle-left"
                                    aria-hidden="true"></i></a>
                            <p class="float-center text-center mb-0 edit-title">{{trans('tickets.component.edit_ticket')}}</p>
                        </div>
                        <div class="card-seller-info card-buying"
                             v-if="(user != null && ticket.user &&  ticket.user.id == user.id)">
                            <div class="share">
                                <p class="text-center" v-if="ticket.eurostar_ticket_number">
                                    {{trans('tickets.component.eurostar_ticket_number')}}: {{ticket.eurostar_ticket_number}}</p>
                                <p class="text-center">{{trans('tickets.component.share')}}:</p>
                                <div class="input-group">
                                    <el-popover
                                            ref="sharebtn"
                                            placement="bottom"
                                            width="200"
                                            trigger="click"
                                            :content="trans('tickets.component.copied')">
                                    </el-popover>
                                    <input ref="sharelink" readonly type="text" class="form-control"
                                           :value="route('ticket.unique.page',[ticket.hashid])"
                                           aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button v-popover:sharebtn class="btn btn-outline-primary" type="button"
                                                @click.prevent="share()">
                                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="delete mt-4">
                                <p class="text-center">{{trans('tickets.component.delete')}}</p>
                                <form method="POST" :action="route('public.ticket.delete')">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input type="hidden" name="ticket_id" :value="ticket.id">
                                    <button class="btn btn-danger mx-auto d-block mt-3">
                                        {{trans('tickets.component.delete_cta')}}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                </template>
                <!--

                =============== User buying the ticket ===============

                -->
                <!-- A ticket for an offer that was denied is in same state as buying-->
                <template v-else>
                    <div class="card-travel-info">
                        <a href="#" class="float-left text-white" @click.prevent="editing=false"><i
                                class="fa fa-chevron-circle-left"
                                aria-hidden="true"></i></a>
                        <p class="float-center text-center mb-0 edit-title">
                            {{trans('tickets.component.buy_ticket')}}</p>
                    </div>
                    <div class="card-seller-info card-buying">
                        <template v-if="state=='default'">

                            <p class="text-center"><b>{{date.format('dddd, MMMM Do YYYY')}}</b></p>
                            <p class="text-center"><span class="train-time">{{departure_time}}</span>
                                {{ticket.train.departure_city.name}}</p>
                            <p class="text-center"><span class="train-time">{{arrival_time}}</span>
                                {{ticket.train.arrival_city.name}}</p>
                            <template v-if="user">
                                <!-- Authentificated user buyting ticket -->
                                <p class="text-center">{{publishedBy}}
                                    <a target="_blank" :href="'/profile/user/'+ticket.user.hashid">
                                        <b>{{ticket.user.full_name}}</b>
                                        <el-tooltip class="item" effect="dark"
                                                    :content="trans('tickets.component.user_verified')"
                                                    placement="bottom-end">
                                            <i v-if="ticket.user.verified" aria-hidden="true"
                                               class="fa fa-check-circle text-warning"></i>
                                        </el-tooltip>
                                    </a>
                                </p>
                            </template>
                            <template v-else>
                                <!-- Unanthitificated user -->
                                <p class="text-center">{{publishedBy}} <b
                                        class="text-primary">{{ticket.user.full_name}}  <i v-if="ticket.user.verified"
                                                                                           aria-hidden="true"
                                                                                           class="fa fa-check-circle text-warning"></i></b>
                                </p>
                            </template>
                            <form class="row mt-2" v-if="state=='default'">
                                <div class="col-12 text-center">
                                 <span v-if="errors.has('price')||errorMessage!=''" class="invalid-feedback d-inline">
                                    {{errors.has('price') ? errors.first('price') : errorMessage}}
                                </span>
                                </div>
                                <div class="col-12 col-sm-10 col-md-8 mx-auto">

                                    <div class="input-group">
                                        <span class="input-group-addon">{{ticket.currency_symbol}}</span>
                                        <input type="text"
                                               :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                               :aria-label="trans('tickets.component.price')"
                                               :placeholder="trans('tickets.component.price')"
                                               v-model="priceOffer"
                                               name="price"
                                               v-validate="'required|numeric|min_value:0|max_value:'+ticket.price">
                                    </div>
                                    <button class="btn btn-ptb btn-block mt-2" @click.prevent="makeOffer">
                                        {{trans('tickets.component.send_offer')}}
                                    </button>

                                </div>
                                <div class="col-12">
                                    <p class="text-center mt-2">{{trans('tickets.component.if_interested')}}</p>
                                </div>
                            </form>
                        </template>
                        <div v-else-if="state=='offering'">
                            <loader class-name="mx-auto mt-4"></loader>
                        </div>
                        <template v-else-if="state=='offered'">
                            <p class="text-center">{{trans('tickets.component.offer_sent')}}</p>
                        </template>
                        <template v-else-if="state=='register'">
                            <p class="text-center">{{trans('tickets.component.register')}} <br><br> <a
                                    :href="route('register.page')+'?source=guest-offer'">{{trans('tickets.component.register_cta')}}</a>
                            </p>
                        </template>
                    </div>

                </template>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            ticket: {type: Object, required: true},
            // Selecting when user is selling a ticket (no in db yet, no user)
            selecting: {type: Boolean, default: false},
            // If the ticket is dislayed on the buying page
            buying: {type: Boolean, default: false},
            // Display only Mode
            display: {type: Boolean, default: false},

            bought: {type: Boolean, default: false},
            csrf: {type: String, required: false},

            className: '',
        },
        data() {
            return {
                user: this.$root.user,
                date: new moment(this.ticket.train.departure_date, 'YYYY-MM-DD') || null,
                editing: false,
                priceOffer: this.ticket.price,
                state: 'default',
                errorMessage: ''
            }
        },
        mounted() {
            if (this.offerDone) {
                this.state == 'offered';
            }
            if (!this.ticket.currency) {
                this.ticket.currency = this.ticket.bought_currency;
            }
            if (!this.ticket.currency_symbol) {
                this.ticket.currency_symbol = this.ticket.bought_currency_symbol;
            }
        },
        computed: {
            arrival_time: function () {
                return moment(this.ticket.train.arrival_time, 'HH:mm:ss').format('HH:mm')
            },
            departure_time: function () {
                return moment(this.ticket.train.departure_time, 'HH:mm:ss').format('HH:mm')
            },
            pastTicket: function () {
                var now = moment();
                var departure = moment(this.ticket.train.departure_date + ' ' + this.departure_time, 'YYYY-MM-DD HH:mm');
                return now.isAfter(departure.subtract(2, 'h'))
            },
            offerDone: function () {
                if (this.buying && this.user) {
                    return this.user.offers_sent && Array.isArray(this.user.offers_sent) && this.user.offers_sent.length > 0 && this.user.offers_sent.map(a => a.ticket_id).includes(this.ticket.id);
                }
                return false;
            },
            publishedBy: function () {
                let trans = this.trans('tickets.component.sold_by');

                if (this.ticket.created_at) {
                    return trans.replace('{{days}}', moment(this.ticket.created_at.date).fromNow(true));
                } else {
                    return trans.replace('{{days}}', moment().fromNow(true));
                }
            }
        },
        methods: {
            sell() {
                if (!this.selecting) return;
                this.$emit('sell', this.ticket.id);
            },
            share() {
                var url = this.route('ticket.unique.page', [this.ticket.hashid]);
                this.$emit('share', url);

                this.$refs.sharelink.select();
                this.$refs.sharelink.setSelectionRange(0, this.$refs.sharelink.value.length);

                document.execCommand("Copy");

            },
            makeOffer() {


                if (this.user == undefined || this.user == null) {
                    this.state = 'register';
                    return;
                }

                this.$validator.validateAll().then((result) => {
                    this.state = 'offering';
                    this.errorMessage = '';
                    this.$http.post(this.route('api.tickets.offer'), {
                        price: this.priceOffer,
                        ticket_id: this.ticket.id
                    }).then(response => {
                        // Success in offer
                        if (response.ok) {
                            this.state = 'offered';
                            this.ticket.offerStatus = 0;
                            if (this.$lodash.has(this.ticket, 'discussionId')) {
                                this.editing = false;
                            }
                            this.$emit('make-offer', {
                                price: this.priceOffer,
                                ticket_id: this.ticket.id
                            });

                            return;
                        } else {
                            this.state = 'default';
                            this.errorMessage = response.body.message;
                        }
                    }, response => {
                        if (!response.ok) {
                            this.state = 'default';
                            this.errorMessage = response.body.message;
                        }
                    });
                });
            }
        }
    }
</script>