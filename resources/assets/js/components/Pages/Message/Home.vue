<template>
    <div class="col-12">


        <loader class="mx-auto my-5" v-if="isLoading"></loader>
        <div class="card" v-else-if="this.hasDiscussions === false && offersAwaiting.length === 0">
            <p class="card-body text-ptb-sm text-center">
                {{ trans('message.empty')}}
            </p>
        </div>

        <!-- Awaiting offers -->

        <template v-if="offersAwaiting.length > 0">

            <!-- Modal to deny an offer -->
            <DenyOfferModal :offer="offerBeingDenied"
                            :is-open="denyOfferModal"
                            @close-modal="denyOfferModal=false;offerBeingDenied=null"
            ></DenyOfferModal>

            <!--Table list of currenct offers-->

            <h4 class="card-title mb-0">{{lang.awaiting_offers.title}}</h4>

            <div class="card card-awaiting-offers mb-3">
                <div class="card-body card-messages">
                    <div class="awaiting_offers">
                        <div class="table-responsive">
                            <table class="table table-hover table-offers">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center d-none d-md-table-cell">{{trans('message.awaiting_offers.table.ticket')}}</th>
                                    <th scope="col" class="d-none d-md-table-cell">{{trans('message.awaiting_offers.table.buyer')}}</th>
                                    <th scope="col" class="text-center d-none d-md-table-cell">{{trans('message.awaiting_offers.table.price')}}</th>
                                    <th scope="col" class="text-center d-none d-md-table-cell">{{trans('message.awaiting_offers.table.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="offer in offersAwaiting">
                                    <th scope="col" class="text-center text-info">
                                        <ticket-mini :discussion="offer"
                                                     :ticket="offer.ticket"></ticket-mini>
                                        <div class="d-sm-block d-md-none">
                                            <p class="text-center mt-3 text-primary">
                                                {{offer.buyer.full_name}} - {{offer.price}}{{offer.currency === 'GBP' ? '£' : '€'}}
                                            </p>
                                            <div class="btn-rack">
                                                <button class="btn btn-success" @click.prevent="acceptOffer(offer.id)">
                                                    {{lang.awaiting_offers.accept}}
                                                </button>
                                                <button class="btn btn-danger" @click.prevent="denyOffer(offer.id)">
                                                    {{lang.awaiting_offers.deny}}
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                    <th scope="col" class="d-none d-sm-none d-md-table-cell align-middle">
                                        {{offer.buyer.full_name}}
                                    </th>
                                    <th scope="col" class="text-center align-middle d-none d-md-table-cell">
                                        {{offer.price}}{{offer.currency === 'GBP' ? '£' : '€'}}
                                    </th>
                                    <th scope="col" class="text-center actions align-middle d-none d-md-table-cell">
                                        <button class="btn btn-success" @click.prevent="acceptOffer(offer.id)">
                                            {{lang.awaiting_offers.accept}}
                                        </button>
                                        <button class="btn btn-danger" @click.prevent="denyOffer(offer)">
                                            {{lang.awaiting_offers.deny}}
                                        </button>
                                        <!--<i class="fa fa-check" aria-hidden="true" @click.prevent="acceptOffer(offer.id)"></i>-->
                                        <!--<i class="fa fa-times" aria-hidden="true" @click.prevent="denyOffer(offer.id)"></i>-->
                                    </th>
                                    <form method="post" :id="'accept-'+offer.id" :action="routes.accept_offer">
                                        <input type="hidden" name="_token" :value="csrf">
                                        <input type="hidden" name="discussion_id" :value="offer.id"/>
                                    </form>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Current Discussions -->

        <template v-if="this.hasDiscussions" >
            <h4 class="card-title mb-0">{{lang.discussions.title}}


                <!-- Filtering and sorting options -->
                <div class="row">

                    <!-- Checkboxes for buying or selling discussions -->
                    <div class="col-sm-6">
                        <el-checkbox label="true" v-model="showBuy">{{trans('message.discussions.showBuying')}}</el-checkbox>
                    </div>
                    <div class="col-sm-6">
                        <el-checkbox label="true" v-model="showSell">{{trans('message.discussions.showSelling')}}</el-checkbox>
                    </div>


                    <!-- Radio buttons for sorting -->
                    <div class="col-md-6">
                        <el-radio v-model="radio" label="ticketCompare">{{trans('message.discussions.sortByTicketDate')}}</el-radio>
                    </div>
                    <div class="col-md-6">
                        <el-radio v-model="radio" label="discussionCompare">{{trans('message.discussions.sortByDiscussionDate')}}</el-radio>
                    </div>

                </div>
            </h4>

            <div class="card">
                <div class="card-body card-messages">
                    <div class="current-discussions">
                        <div class="table-responsive">
                            <table class="table table-hover table-discussion">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">{{trans('message.discussions.table.ticket')}}</th>
                                    <th scope="col" class="text-center">{{trans('message.discussions.table.name')}}</th>
                                    <th scope="col">{{trans('message.discussions.table.last_message')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                <!-- If there are total discussions, but no current discussions -->
                                <tr v-if="currentDiscussions.length === 0"
                                    class="mt-3 text-center text-ptb-sm">
                                    <th colspan="3">
                                        <loader class="mx-auto my-5" v-if="isLoading"></loader>
                                        <div class="card" v-else-if="this.hasDiscussions === false && offersAwaiting.length === 0">
                                            <p class="card-body text-ptb-sm text-center">
                                                {{ trans('message.empty')}}
                                            </p>
                                        </div>
                                    </th>
                                </tr>

                                <template v-for="offer in currentDiscussions">


                                    <tr :key="offer.id" @click="openDiscussion(offer.id)">
                                        <th scope="col" class="col-ticket">
                                            <ticket-mini :discussion="offer"
                                                         :ticket="offer.ticket"></ticket-mini>
                                        </th>
                                        <th :class="{'unread':unreadDiscussion(offer),'align-middle':true,'text-center':true, 'last-message-sender':true}"
                                            scope="col" @click="openDiscussion(offer.id)">
                                            <a class="d-none" :href="discussionPageUrl(offer.ticket.id,offer.id)"
                                               :id="'discussion-link-'+offer.id"></a>
                                            {{offer.buyer.id === user.id ? offer.seller.full_name : offer.buyer.full_name}}
                                        </th>
                                        <th :class="{'unread':unreadDiscussion(offer),'align-middle':true,'last-message':true}">
                                            {{offer.last_message ? (offer.last_message.message.substring(0, 30) + (offer.last_message.message.length > 30 ? '...' : '')) : '-'}}
                                            <p class="text-sm-left font-weight-bold">
                                                ({{ formattedDate(offer.updated_at.date) }})
                                            </p>
                                        </th>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Switch to show past discussions. Only renders if there is at least 1 total discussion  -->
            <div class="pt-2 pt-2 text-center past-switch">
                <el-switch v-model="showPast"
                        active-color="#13ce66"
                        inactive-color="#ff4949">
                </el-switch>
                <span class="ml-2 text-center">
                    {{ trans('message.discussions.showPast')}}
                </span>
            </div>


            <!-- Past discussions -->
            <div v-if="showPast === true" class="card mt-4">
                <div class="card-body card-messages">
                    <div class="past-discussions">
                        <div class="table-responsive">
                            <table class="table table-hover table-discussion">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-center">{{trans('message.discussions.table.ticket')}}</th>
                                    <th scope="col" class="text-center">{{trans('message.discussions.table.name')}}</th>
                                    <th scope="col">{{trans('message.discussions.table.last_message')}}</th>
                                </tr>
                                </thead>
                                <tbody>

                                <!-- If there are total discussions, but no past discussions -->
                                <tr v-if="pastDiscussions.length === 0"
                                    class="mt-3 text-center text-ptb-sm">
                                    <th colspan="3">
                                        <p v-if="pastDiscussions.length === 0">
                                            {{trans('message.discussions.noPastDiscussions')}}
                                        </p>
                                    </th>
                                </tr>


                                <template v-for="offer in pastDiscussions">
                                    <tr :key="offer.id" @click="openDiscussion(offer.id)">
                                        <th scope="col" class="col-ticket">
                                            <ticket-mini :discussion="offer"
                                                         :ticket="offer.ticket">
                                            </ticket-mini>
                                        </th>
                                        <th :class="{'unread':unreadDiscussion(offer),'align-middle':true,'text-center':true, 'last-message-sender':true}"
                                            scope="col" @click="openDiscussion(offer.id)">
                                            <a class="d-none" :href="discussionPageUrl(offer.ticket.id,offer.id)"
                                               :id="'discussion-link-'+offer.id"></a>
                                            {{offer.buyer.id === user.id ? offer.seller.full_name : offer.buyer.full_name}}
                                        </th>
                                        <th :class="{'unread':unreadDiscussion(offer),'align-middle':true,'last-message':true}">
                                            {{offer.last_message ? (offer.last_message.message.substring(0, 30) + (offer.last_message.message.length > 30 ? '...' : '')) : '-'}}
                                            <p class="text-sm-left font-weight-bold">
                                                ({{ formattedDate(offer.updated_at.date) }})
                                            </p>
                                        </th>
                                    </tr>
                                </template>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </template>
        <p v-else class="text-ptb-sm text-center">
            {{ trans('messages.discussions.noDiscussions') }}
        </p>
    </div>
</template>

<script>
    import DenyOfferModal from './components/DenyOffer.vue'

    export default {
        props: {
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
        },
        data() {
            return {
                loading: {
                    buying: true,
                    offers_accepted: true,
                    offers_received: true
                },
                user: this.$root.user,
                state: 'default',
                csrf: window.csrf,
                offerBeingDenied: null,
                denyOfferModal: false,
                showBuy: true,
                showSell: true,
                showPast: false,
                radio: 'discussionCompare',

                offersAwaiting: [],
                buyingDiscussions: [],
                sellingDiscussions: []
            }
        },
        computed: {
            isLoading() {
                return this.loading.buying || this.loading.offers_accepted || this.loading.offers_received;
            },
            currentDiscussions() {

                /* The list for the discussions to display */
                var discussions = [];

                /* Split buying discussions into two lists */
                var allBuying = this.splitDiscussions(this.buyingDiscussions);
                var allSelling = this.splitDiscussions(this.sellingDiscussions);

                /* Concatenate the lists depending on the state of the component */

                if (this.showBuy) {
                    discussions = discussions.concat(allBuying[0]);
                }

                if (this.showSell) {
                    discussions = discussions.concat(allSelling[0]);
                }

                /* Sort the final list and return it */
                if (this.radio === 'ticketCompare') {
                    return discussions.sort(this.ticketCompare)
                }
                else {
                    return discussions.sort(this.discussionCompare);
                }
            },
            pastDiscussions() {

                /* The list for the discussions to display */
                var discussions = [];

                /* Split buying discussions into two lists */
                var allBuying = this.splitDiscussions(this.buyingDiscussions);
                var allSelling = this.splitDiscussions(this.sellingDiscussions);

                /* Concatenate the lists depending on the state of the component */

                if (this.showBuy) {
                    discussions = discussions.concat(allBuying[1]);
                }

                if (this.showSell) {
                    discussions = discussions.concat(allSelling[1]);
                }

                /* Sort the final list and return it */
                if (this.radio === 'ticketCompare') {
                    return discussions.sort(this.ticketCompare)
                }
                else {
                    return discussions.sort(this.discussionCompare);
                }
            },
            hasDiscussions() {
                return this.buyingDiscussions.length > 0 || this.sellingDiscussions.length > 0;
            },
        },
        methods: {
            unreadDiscussion(discussion) {
                if (discussion.last_message && discussion.last_message.sender_id !== this.user.id && discussion.last_message.read_at == null) {
                    return true;
                }
                return false;
            },
            denyOffer(offer) {
                this.offerBeingDenied = offer;
                this.denyOfferModal = true;
            },

            /* Split discussions by current date and time */
            splitDiscussions(discussions) {

                var currentDate = moment();

                var current = [];

                var past = [];

                for (var offer of discussions) {
                    var ticketDate = this.getTicketDateOfOffer(offer);
                    if (ticketDate.isSameOrAfter(currentDate))
                        current.push(offer);
                    else
                        past.push(offer);
                }
                return [current, past];
            },
            /* Get the date of the ticket associated with an offer as a moment object */
            getTicketDateOfOffer(offer) {
                return moment(offer.ticket.train.departure_date + " " + offer.ticket.train.departure_time, "YYYY-MM-DD HH:mm:ss");
            },
            getDiscussionDateOfOffer(offer) {
              return moment(offer.updated_at.date)
            },
            acceptOffer(id) {
                document.getElementById("accept-" + id).submit();
            },
            formattedDate: function (mydate) {
                return moment(mydate).format('MMM Do')
            },
            discussionPageUrl(ticket_id, discussion_id) {
                return this.routes.discussion.replace('ticket_id', ticket_id).replace('discussion_id', discussion_id);
            },
            openDiscussion: function (discussion_id) {
                document.getElementById('discussion-link-' + discussion_id).click();
            },
            discussionCompare(a, b) {
                var dateA = this.getDiscussionDateOfOffer(a);
                var dateB = this.getDiscussionDateOfOffer(b);
                if (dateA.isBefore(dateB))
                    return 1;
                else if (dateA.isAfter(dateB))
                    return -1;
                return 0;
            },
            ticketCompare(a, b) {
                var dateA = this.getTicketDateOfOffer(a);
                var dateB = this.getTicketDateOfOffer(b);
                if (dateA.isBefore(dateB))
                    return 1;
                else if (dateA.isAfter(dateB))
                    return -1;
                return 0;
            }
        },
        mounted() {

            this.$http.get(this.route('api.discussion.messages', ['buying']))
                .then(response => {
                    this.buyingDiscussions = response.data.data;
                    this.loading.buying=false;
                }, response => {
                    this.$message(response.body.data.message,);
                });
            this.$http.get(this.route('api.discussion.messages', ['offers_accepted']))
                .then(response => {
                    this.sellingDiscussions = response.data.data;
                    this.loading.offers_accepted=false;
                }, response => {
                    this.$message(response.body.data.message,);
                })
            this.$http.get(this.route('api.discussion.messages', ['offers_received']))
                .then(response => {
                    this.offersAwaiting = response.data.data;
                    this.loading.offers_received=false;
                }, response => {
                    this.$message(response.body.data.message,);
                })
        },
        components: {
            DenyOfferModal
        }
    }
</script>
