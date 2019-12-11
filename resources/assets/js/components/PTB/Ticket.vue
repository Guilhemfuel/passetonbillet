<template>
    <div class="ticket-container">
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


                        <!-- Share button-->
                        <button class="btn-share" v-if="(user != null && ticket.user && ticket.user.id == user.id)
                    && !pastTicket && !display && ticket.buyer == null" @click="shareModalOpen=true">
                            {{trans('tickets.component.share_btn')}}
                        </button>


                        <!-- Ticket number-->
                        <p class="ticket-number"
                           v-if="((user != null && ticket.user && ticket.user.id == user.id) || selecting) && ticket.ticket_number">
                            N°{{ticket.ticket_number}}
                        </p>

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
                        <!--
                        | ---------------------------------------
                        |       Buttons for ticket actions       |
                        | ---------------------------------------
                        -->

                        <!-- Discuss -->
                        <template v-if="!pastTicket && !display
                        && $lodash.has(ticket, 'discussionId')
                        && $lodash.has(ticket, 'offerStatus')
                        && ticket.offerStatus == 1">
                            <a v-if="ticket.id"
                               :href="route('public.message.discussion.page',[ticket.id, ticket.discussionId])"
                               class="btn btn-ptb btn-buy btn-sm">{{trans('tickets.component.discuss')}}</a>
                        </template>
                        <!-- Edit (in case of buying page, is a link)-->
                        <template
                                v-else-if="!pastTicket && (user != null && ticket.user && ticket.user.id == user.id) && !display">

                            <button class="btn btn-ptb btn-buy btn-sm" @click="editing=true" v-if="!buying">
                                {{trans('tickets.component.edit')}}
                            </button>

                            <a class="btn btn-ptb btn-buy btn-sm" v-else
                               :href="route('public.ticket.owned.page')">{{trans('tickets.component.edit')}}</a>
                        </template>
                        <!-- Make Offer -->
                        <template v-else-if="!pastTicket && !display
                        && $lodash.has(ticket, 'discussionId')
                        && $lodash.has(ticket, 'offerStatus')
                        && ticket.offerStatus == -1">
                            <div class="btn-buy row btn-buy-group" v-if="!selecting && buying">
                                <div class="col text-center p-0">
                                    <button class="btn btn-ptb btn-sm btn-call" @click.prevent="modalCallOpen = true">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        {{trans('tickets.component.call')}}
                                    </button>
                                </div>
                                <div class="col text-center p-0" v-if="!offerDone">
                                    <button class="btn btn-ptb-white btn-sm text-center btn-contact"
                                            @click="contactSeller()">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        {{trans('tickets.component.contact')}}
                                    </button>
                                </div>
                            </div>
                        </template>
                        <!-- Buy/Sell/Download -->
                        <template v-else-if="!pastTicket && !display">
                            <div class="btn-buy row btn-buy-group" v-if="!selecting && buying">
                                <div class="col text-center p-0">

                                    <button v-if="this.ticket.hasPdf" class="btn btn-ptb btn-sm btn-call" @click.prevent="ifUserLogged()">
                                        {{trans('tickets.component.buy')}}
                                    </button>

                                    <button v-else class="btn btn-ptb btn-sm btn-call" @click.prevent="modalCallOpen = true">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        {{trans('tickets.component.call')}}
                                    </button>
                                </div>
                                <div class="col text-center p-0" v-if="!offerDone">
                                    <button class="btn btn-ptb-white btn-sm text-center btn-contact"
                                            @click="contactSeller()">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        {{trans('tickets.component.contact')}}
                                    </button>
                                </div>
                            </div>
                            <button class="btn btn-ptb btn-buy btn-sm" v-if="selecting" @click.prevent="sell">
                                {{trans('tickets.component.sell')}}
                            </button>
                            <button class="btn btn-ptb btn-buy btn-sm" v-if="bought" @click="editing=true">
                                {{trans('tickets.component.infos')}}
                            </button>
                        </template>

                        <div class="price" v-if="!selecting">
                        <span>
                            <template v-if="ticket.offerPrice && ticket.offerPrice!=ticket.price">
                                <span class="old-price">{{ticket.currency_symbol}}{{ticket.price}}</span>
                                <span class="offer-price text-center">{{ticket.currency_symbol}}{{ Math.round(ticket.offerPrice * 1.1) }}</span>
                            </template>
                            <template v-else>
                            <span class="text-center"></span> {{ticket.currency_symbol}}{{ Math.round(ticket.price * 1.1) }}
                            </template>
                        </span>
                        </div>
                        <div class="price" v-if="selecting">
                            <span>{{ticket.bought_currency_symbol}}{{ticket.bought_price}}</span>
                        </div>
                        <div class="seller" v-if="!selecting">
                            <template>
                                <a target="_blank"
                                   :href="'/profile/user/'+ticket.user.hashid">

                                    <p class="mb-0 d-inline">
                                        {{publishedBy}} <b>{{ticket.user.full_name}}</b>
                                    </p>
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
                                           class="fa fa-clock-o text-gold verif-status"></i>

                                    </el-tooltip>
                                    <el-tooltip v-else class="item" effect="dark"
                                                :content="trans('tickets.component.user_not_verified')"
                                                placement="bottom-end">
                                        <i class="fa fa-exclamation-triangle text-danger verif-status"
                                           aria-hidden="true"></i>
                                    </el-tooltip>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- =============
                    Back of ticket
                    =============== -->

                <div :class="{'card':true, 'card-ticket':true, 'back':true, className:className, 'past-ticket':pastTicket}"
                     v-if="!display"
                >
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
                                <p class="float-center text-center mb-0 edit-title">
                                    {{trans('tickets.component.infos')}}</p>
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
                                <p class="float-center text-center mb-0 edit-title">
                                    {{trans('tickets.component.edit_ticket')}}</p>
                            </div>
                            <div class="card-seller-info card-buying"
                                 v-if="userIsOwner">
                                <p class="text-center">{{trans('tickets.component.edit_price_modal.text')}}</p>

                                <vue-form method="post" :action="route('public.ticket.edit',[ticket.id])"
                                          ref="sell_form">

                                    <div class="row">
                                        <div class="col-6 pr-1">
                                            <div class="form-group">
                                                <label>{{trans('tickets.sell.inputs.price')}}</label>
                                                <div class="input-group">
                                                    <!-- Todo: ajouter l'option de la currency-->
                                                    <span class="input-group-addon">{{ticket.bought_currency_symbol}}</span>
                                                    <input type="text"
                                                           :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                                           :aria-label="trans('tickets.lang.sell.inputs.price')"
                                                           :placeholder="trans('tickets.lang.sell.inputs.price')"
                                                           v-model="ticket.price"
                                                           name="price"
                                                           v-validate="'required|numeric|min_value:1'">
                                                </div>
                                                <span v-if="errors.has('price')"
                                                      class="invalid-feedback">{{ errors.first('price')
                                                    }}</span>
                                            </div>
                                        </div>

                                        <div class="col-6 pl-1">
                                            <button type="submit" class="btn btn-ptb btn-block mt-4"
                                                    :disabled="ticket.price==null || ticket.price == 0"
                                            >
                                                {{trans('tickets.component.edit_price_modal.submit')}}
                                            </button>
                                        </div>
                                    </div>
                                </vue-form>

                                <button class="btn btn-outline-danger mx-auto d-block mt-3 btn-delete-ticket"
                                        @click="modalDeleteOpen=true">
                                    {{trans('tickets.component.delete_cta')}}
                                </button>
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
                        <div class="card-seller-info card-buying pt-1">
                            <p class="text-center date"><b>{{ucFirst(date.format('dddd Do MMMM YYYY'))}}</b></p>
                            <p class="text-center departure"><span class="train-time">{{departure_time}}</span>
                                {{ticket.train.departure_city.name}}</p>
                            <p class="text-center arrival"><span class="train-time">{{arrival_time}}</span>
                                {{ticket.train.arrival_city.name}}</p>

                            <template v-if="user">
                                <!-- Authentificated user buying ticket -->
                                <p class="text-center">{{publishedBy}}
                                    <a target="_blank" :href="'/profile/user/'+ticket.user.hashid">
                                        <b>{{ticket.user.full_name}}</b>
                                    </a>
                                </p>
                            </template>
                            <template v-else>
                                <!-- Unauthificated user -->
                                <p class="text-center">{{publishedBy}} <b
                                        class="text-primary">{{ticket.user.full_name}}</b>
                                </p>
                            </template>

                            <!-- 3 Security information -->
                            <div class="security-information row flex-nowrap text-center mt-3">
                                <div class="identity col">

                                    <i v-if="ticket.user.verified" aria-hidden="true"
                                       class="fa fa-check-circle text-success"></i>
                                    <i aria-hidden="true" v-else-if="ticket.user.verification_pending"
                                       class="fa fa-clock-o text-warning verif-status"></i>
                                    <i v-else class="fa fa-exclamation-triangle text-danger verif-status"
                                       aria-hidden="true"></i>

                                    <p class="label" v-if="ticket.user.verified">
                                        {{trans('tickets.component.security.identity.verified')}}</p>
                                    <p class="label" v-else-if="ticket.user.verification_pending">
                                        {{trans('tickets.component.security.identity.pending')}}</p>
                                    <p class="label" v-else>{{trans('tickets.component.security.identity.not_verified')}}</p>


                                </div>
                                <div class="tickets-sold col text-center">

                                    <p class="tickets-sold-count">{{ticket.user.ticket_sold}}</p>
                                    <p class="label">{{trans('tickets.component.security.tickets_sold')}}</p>

                                </div>
                                <div class="register-date col">
                                    <p class="date">{{ticket.user.register_date}}</p>
                                    <p class="label">{{trans('tickets.component.security.register_date')}}</p>
                                </div>
                            </div>

                            <div v-if="buyingState == 'offer'">
                                <template v-if="state=='default'">

                                    <form class="row mt-2" v-if="state=='default'">
                                        <div class="col-12">
                                            <div class="row mt-3 mb-2">
                                                <div class="col-6 input-group">
                                                    <span class="input-group-addon">{{ticket.currency_symbol}}</span>
                                                    <input type="text"
                                                           :class="'form-control' + (errors.has('price')?' is-invalid':'')"
                                                           :aria-label="trans('tickets.component.price')"
                                                           :placeholder="trans('tickets.component.price')"
                                                           v-model="priceOffer"
                                                           name="price"
                                                           v-validate="'required|numeric|min_value:0|max_value:'+ticket.price">
                                                </div>
                                                <div class="col-6 pl-0">
                                                    <button class="btn btn-ptb btn-block px-1"
                                                            @click.prevent="makeOffer">
                                                        {{trans('tickets.component.send_offer')}}
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-center if-interested">
                                                 <span v-if="errors.has('price')||errorMessage!=''"
                                                       class="invalid-feedback d-inline">
                                                    {{errors.has('price') ? errors.first('price') : errorMessage}}
                                                </span>
                                                <span v-else>
                                                    {{trans('tickets.component.if_interested')}}
                                                </span>
                                            </p>
                                            <button class="btn btn-block btn-outline-orange"
                                                    @click.prevent="modalCallOpen = true">
                                                {{trans('tickets.component.buying_actions.call.btn')}}
                                            </button>
                                        </div>
                                    </form>
                                </template>
                                <div v-else-if="state=='offering'">
                                    <loader class-name="mx-auto mt-4"></loader>
                                </div>
                                <template v-else-if="state=='offered'">
                                    <p class="text-center mt-2">{{trans('tickets.component.offer_sent')}}</p>
                                    <p class="text-center">
                                        <a href="#"
                                           @click.prevent="modalCallOpen = true">{{trans('tickets.component.buying_actions.offer.back_to_call')}}</a>
                                    </p>
                                </template>
                                <template v-else-if="state=='register'">
                                    <p class="text-center must-register">{{trans('tickets.component.register')}}</p>
                                    <a class="btn btn-ptb btn-block text-white"
                                       :href="route('register.page')+'?source=guest-offer'">
                                        {{trans('tickets.component.register_cta')}}
                                    </a>

                                    <button class="btn btn-block btn-outline-orange"
                                            @click.prevent="modalCallOpen = true">
                                        {{trans('tickets.component.buying_actions.call.btn')}}
                                    </button>
                                </template>

                            </div>


                        </div>

                    </template>

                </div>


            </div>
        </div>


        <!-- Share modal -->
        <modal class="ticket-modal-share"
               :is-open="shareModalOpen"
               @close-modal="shareModalOpen=false"
               :title="trans('tickets.component.share_modal.title')"
               v-if="userIsOwner"
        >

            <template v-if="(user != null && ticket.user && ticket.user.id == user.id)
                    && !pastTicket && !display && ticket.buyer == null">

                <h5 class="mb-0">{{trans('tickets.component.share_modal.step_1')}}</h5>

                <div class="fb-share-btn">
                    <div class="fb-share-button text-center"
                         :data-href="route('ticket.unique.page',[ticket.hashid])"
                         data-layout="button" data-size="large" data-mobile-iframe="true">
                        <a target="_blank" :href="'https://www.facebook.com/sharer/sharer.php?u=' +
                        encodeURI(route('ticket.unique.page',[ticket.hashid]))
                        +'&amp;src=sdkpreparse'"
                           class="fb-xfbml-parse-ignore btn btn-facebook my-4">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                            {{trans('tickets.component.share_modal.share_on_fb')}}
                        </a>
                    </div>
                </div>

                <h5>{{trans('tickets.component.share_modal.step_2')}}</h5>

                <div class="container">
                    <div class="row justify-content-center">


                        <div class="col-12 col-sm-10 col-md-8">
                            <p class="text-center">{{trans('tickets.component.share_modal.text_link')}} :</p>

                            <input ref="sharelink" readonly type="text" class="form-control"
                                   :value="route('ticket.unique.page',[ticket.hashid])"
                                   aria-describedby="basic-addon2">
                            <el-popover
                                    placement="bottom"
                                    trigger="click"
                                    :content="trans('tickets.component.copied')">
                                <div class="btn btn-block btn-ptb-blue mt-2" @click.prevent="share()" slot="reference">
                                    <i class="fa fa-clipboard" aria-hidden="true"></i>
                                    {{trans('tickets.component.share_modal.copy_link')}}
                                </div>
                            </el-popover>

                            <p class="text-center mt-4">{{trans('tickets.component.share_modal.our_fb_group')}}</p>

                            <div class="fb-group" data-href="https://www.facebook.com/groups/4856026601/"
                                 data-width="300" data-show-social-context="true" data-show-metadata="false"
                                 v-if="ticket.provider=='eurostar'"></div>

                            <div class="fb-group" data-href="https://www.facebook.com/groups/5042721942/"
                                 data-width="300" data-show-social-context="true" data-show-metadata="false"
                                 v-else-if="ticket.provider=='thalys' || ticket.provider=='izy'"></div>

                            <div class="fb-group" data-href="https://www.facebook.com/groups/38391320652/"
                                 data-width="300" data-show-social-context="true" data-show-metadata="false"
                                 v-else></div>

                        </div>
                    </div>
                </div>
            </template>
        </modal>

        <buy-modal  v-if="user"
                    :ticket="ticket"
                    :is-open="modalBuyOpen"
                    @close-modal="modalBuyOpen=false;"
        ></buy-modal>

        <call-modal :ticket="ticket"
                    :is-open="modalCallOpen"
                    @close-modal="modalCallOpen=false;"
        ></call-modal>

        <!-- Edit modal -->
        <edit-ticket :ticket="ticket"
                     :modal-delete-open="modalDeleteOpen"
                     @close-modal="modalDeleteOpen=false;"
                     v-if="userIsOwner"
        ></edit-ticket>

        <modal class="warning-eurostar-modal"
               :close-on-outside-click="false"
               :button-close="false"
               @close-modal="modalEurostarWarning=false"
               :is-open="modalEurostarWarning"
               :title="trans('tickets.sell.eurostar_warning_fb_group.title')"
               v-if="userIsOwner && ticket.provider == 'eurostar'"
               title-class="text-center"
        >
            <p class="text-justify" v-html="trans('tickets.sell.eurostar_warning_fb_group.message')"></p>

            <button class="btn btn-block btn-danger" @click="modalEurostarWarning=false">
                {{trans('tickets.sell.eurostar_warning_fb_group.button')}}
            </button>
        </modal>
    </div>

</template>

<script>
    import EditTicket from './components/EditTicket.vue'

    export default {
        components: {
            'edit-ticket': EditTicket
        },
        props: {
            ticket: {type: Object, required: true},
            // Selecting when user is selling a ticket (no in db yet, no user)
            selecting: {type: Boolean, default: false},
            // If the ticket is dislayed on the buying page
            buying: {type: Boolean, default: false},
            // Display only Mode
            display: {type: Boolean, default: false},

            bought: {type: Boolean, default: false},
            className: '',

            ticketJustPublished: {type: Boolean, default: false},
        },
        data() {
            return {
                user: this.$root.user,
                date: new moment(this.ticket.train.departure_date, 'YYYY-MM-DD') || null,
                editing: false,
                priceOffer: this.ticket.price,
                state: 'default',
                buyingState: 'offer',
                contactNumber: null,
                errorMessage: '',
                shareModalOpen: false,
                modalDeleteOpen: false,
                modalCallOpen: false,
                modalBuyOpen: false,
                modalEurostarWarning: this.ticketJustPublished && this.ticket.provider == 'eurostar',
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
                let trans = this.trans('tickets.component.sold_by');

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
          ifUserLogged() {
            if (!this.$root.user) {
              window.location.href = this.route('login');
            } else {
              this.modalBuyOpen = true
            }
          },
            ucFirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            },
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
            contactSeller() {
                this.buyingState = 'offer';
                this.editing = true;

                // Log Offer
                this.$root.logEvent('show_ticket_contact', {
                    ticket_id: this.ticket.id
                });
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
                    }).then((response) => {
                        // Success in offer
                        if (response.ok) {
                            this.state = 'offered';
                            this.ticket.offerStatus = 0;
                            if (this.$lodash.has(this.ticket, 'discussionId')) {
                                this.editing = false;
                            }

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