<template>
    <div class="col-12">


        <div class="text-center" v-if="this.allDiscussions().length == 0 && offersAwaiting.length == 0">
            {{lang.empty}}
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
                                                {{offer.buyer.full_name}} - {{offer.price}}{{offer.currency == 'GBP' ? '£' : '€'}}
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
                                        {{offer.price}}{{offer.currency == 'GBP' ? '£' : '€'}}
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

        <template v-if="this.allDiscussions().length > 0">
            <h4 class="card-title mb-0">{{lang.discussions.title}}

                <!-- Filtering and sorting options -->
                <div class="row">

                    <!-- Checkboxes for current discussions -->
                    <div class="col-sm-6">
                        <el-checkbox label="true" v-model="showCurrentBuy">{{lang.discussions.showCurrentBuying}}</el-checkbox>
                    </div>
                    <div class="col-sm-6">
                        <el-checkbox label="true" v-model="showCurrentSell">{{lang.discussions.showCurrentSelling}}</el-checkbox>
                    </div>

                    <!-- Checkboxes to show past discussions -->
                    <div class="col-md-6">
                        <el-checkbox label="true" v-model="showPastBuy">{{lang.discussions.showPastBuying}}</el-checkbox>
                    </div>
                    <div class="col-md-6">
                        <el-checkbox label="true" v-model="showPastSell">{{lang.discussions.showPastSelling}}</el-checkbox>
                    </div>

                    <!-- Radio buttons for sorting -->
                    <div class="col-md-6">
                        <el-radio v-model="radio" label="ticketCompare">{{lang.discussions.sortByTicketDate}}</el-radio>
                    </div>
                    <div class="col-md-6">
                        <el-radio v-model="radio" label="discussionCompare">{{lang.discussions.sortByDiscussionDate}}</el-radio>
                    </div>

                </div>
            </h4>

            <div class="card mt-4">
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
                                <template v-for="offer in discussions">
                                    <tr @click="openDiscussion(offer.id)">
                                        <th scope="col" class="col-ticket">
                                            <ticket-mini :discussion="offer"
                                                         :ticket="offer.ticket"></ticket-mini>
                                        </th>
                                        <th :class="{'unread':unreadDiscussion(offer),'align-middle':true,'text-center':true, 'last-message-sender':true}"
                                            scope="col" @click="openDiscussion(offer.id)">
                                            <a class="d-none" :href="discussionPageUrl(offer.ticket.id,offer.id)"
                                               :id="'discussion-link-'+offer.id"></a>
                                            {{offer.buyer.id == user.id ? offer.seller.full_name : offer.buyer.full_name}}
                                        </th>
                                        <th :class="{'unread':unreadDiscussion(offer),'align-middle':true,'last-message':true}">
                                            {{offer.last_message ? (offer.last_message.message.substring(0, 30) + (offer.last_message.message.length > 30 ? '...' : '')) : '-'}}
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
    </div>
</template>

<script>
    import DenyOfferModal from './components/DenyOffer.vue'

    export default {
        props: {
            api: {required: true},
            routes: {type: Object, required: true},
            lang: {type: Object, required: true},
            ticketLang: {type: Object, required: true},
            user: {type: Object, required: true},
            offersAwaiting: {type: Array, required: true},
            buyingDiscussions: {type: Array, required: true},
            sellingDiscussions: {type: Array, required: true},
        },
        data() {
            return {
                state: 'default',
                csrf: window.csrf,
                offerBeingDenied: null,
                denyOfferModal: false,
                showCurrentBuy: true,
                showCurrentSell: true,
                showPastBuy: false,
                showPastSell: false,
                radio: 'discussionSort'
            }
        },
        computed: {
            discussions() {

                /* The list for the discussions to display */
                var discussions = [];

                /* Split buying discussions into two lists */
                var allBuying = this.splitDiscussions(this.buyingDiscussions);
                var allSelling = this.splitDiscussions(this.sellingDiscussions);

                /* Concatenate the lists depending on the state of the component */

                if (this.showCurrentBuy) {
                    discussions = discussions.concat(allBuying[0]);
                }

                if (this.showCurrentSell) {
                    discussions = discussions.concat(allSelling[0]);
                }

                if (this.showPastBuy) {
                    discussions = discussions.concat(allBuying[1]);
                }

                if (this.showPastSell) {
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
            allDiscussions() {
                return this.buyingDiscussions.concat(this.sellingDiscussions)
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
                if (a.updated_at < b.updated_at)
                    return -1;
                if (a.updated_at > b.updated_at)
                    return 1;
                return 0;
            },
            ticketCompare(a, b) {
                var dateA = this.getTicketDateOfOffer(a);
                var dateB = this.getTicketDateOfOffer(b);
                if (dateA.isBefore(dateB))
                    return -1;
                else if (dateA.isAfter(dateA))
                    return 1;
                return 0;
            }
        },
        components: {
            DenyOfferModal
        }
    }
</script>