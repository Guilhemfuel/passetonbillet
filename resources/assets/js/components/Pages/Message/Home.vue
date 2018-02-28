<template>
    <div class="col-12">

        <div class="card" v-if="offersAwaiting.length > 0">
            <div class="card-header reverse">
                <h4 class="card-title mb-0">{{lang.awaiting_offers.title}}</h4>
            </div>
            <div class="card-body card-messages">
                <div class="awaiting_offers">
                    <div class="table-responsive">
                        <modal :is-open="modalTicketOpened" @close-modal="modalTicketOpened=false">
                            <ticket class-name="fixed-width mx-auto" :user="user" :ticket="modalTicket"
                                    :lang="ticketLang"
                                    v-if="modalTicket" :display="true"></ticket>
                        </modal>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Ticket</th>
                                <th scope="col">Buyer Name</th>
                                <th scope="col" class="text-center">Price</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="offer in offersAwaiting">
                                <th scope="col" class="text-center text-info" @click.prevent="openTicketModal(offer.ticket)">
                                    {{offer.ticket.train.departure_city.short_name.substr(2, 5)}}-{{offer.ticket.train.arrival_city.short_name.substr(2, 5)}}
                                    <!--<i class="fa fa-ticket"></i>-->
                                    <br>{{formattedDate(offer.ticket.train.departure_date)}}
                                </th>
                                <th scope="col">{{offer.buyer.full_name}}</th>
                                <th scope="col" class="text-center">{{offer.price}}{{offer.currency == 'GBP' ? '£' : '€'}}</th>
                                <th scope="col" class="text-center actions">
                                    <button class="btn btn-lastar-blue" @click.prevent="acceptOffer(offer.id)">
                                        Accept
                                    </button>
                                    <button class="btn btn-lastar-blue" @click.prevent="denyOffer(offer.id)">
                                        Deny
                                    </button>
                                    <!--<i class="fa fa-check" aria-hidden="true" @click.prevent="acceptOffer(offer.id)"></i>-->
                                    <!--<i class="fa fa-times" aria-hidden="true" @click.prevent="denyOffer(offer.id)"></i>-->
                                </th>
                                <form method="post" :id="'deny-'+offer.id" :action="routes.deny_offer">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input type="hidden" name="discussion_id" :value="offer.id"/>
                                </form>
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
        <div class="card mt-4" v-if="discussions.length > 0">
            <div class="card-header reverse">
                <h4 class="card-title mb-0">{{lang.discussions.title}}</h4>
            </div>
            <div class="card-body card-messages">
                <div class="awaiting_offers">
                    <div class="table-responsive">
                        <table class="table table-hover table-discussion">
                            <thead>
                            <tr>
                                <th scope="col" class="text-center">Ticket</th>
                                <th scope="col">Name</th>
                                <th scope="col">Last message</th>
                            </tr>
                            </thead>
                            <tbody>
                            <modal :is-open="modalTicketOpened" @close-modal="modalTicketOpened=false">
                                <ticket class-name="fixed-width mx-auto" :user="user" :ticket="modalTicket"
                                        :lang="ticketLang"
                                        v-if="modalTicket" :display="true"></ticket>
                            </modal>
                            <tr v-for="offer in discussions">
                                <th scope="col" class="text-center text-info"  @click.prevent="openTicketModal(offer.ticket)">
                                    {{offer.ticket.train.departure_city.short_name.substr(2, 5)}}-{{offer.ticket.train.arrival_city.short_name.substr(2, 5)}}
                                    <!--<i class="fa fa-ticket"></i>-->
                                    <br>{{formattedDate(offer.ticket.train.departure_date)}}
                                </th>
                                <th scope="col" @click="openDiscussion(offer.id)">
                                    <a style="d-none" :href="discussionPageUrl(offer.ticket.id,offer.id)" :id="'discussion-link-'+offer.id"></a>
                                    {{offer.buyer.id == user.id ? offer.seller.full_name : offer.buyer.full_name}}
                                </th>
                                <th @click="openDiscussion(offer.id)">{{offer.last_message?offer.last_message.message:'-'}}</th>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
            ticketLang: {type: Object, required: true},
            user: {type: Object, required: true},
            csrf: {type: String, required: true},
            offersAwaiting: {type: Array, required: true},
            buyingDiscussions: {type: Array, required: true},
            sellingDiscussions: {type: Array, required: true},
        },
        data() {
            return {
                state: 'default',
                modalTicketOpened: false,
                modalTicket: null
            }
        },
        computed: {
            discussions() {
                var discussions = this.buyingDiscussions.concat(this.sellingDiscussions);

                function compare(a, b) {
                    if (a.updated_at < b.updated_at)
                        return -1;
                    if (a.updated_at > b.updated_at)
                        return 1;
                    return 0;
                }

                return discussions.sort(compare);
            }
        },
        methods: {
            openTicketModal(ticket) {
                this.modalTicket = ticket;
                this.modalTicketOpened = true;
            },
            denyOffer(id) {
                document.getElementById("deny-" + id).submit();
            },
            acceptOffer(id) {
                document.getElementById("accept-" + id).submit();
            },
            formattedDate: function (mydate) {
                return moment(mydate, 'HH:mm:ss').format('MMM Do')
            },
            discussionPageUrl(ticket_id,discussion_id){
                return this.routes.discussion.replace('ticket_id',ticket_id).replace('discussion_id',discussion_id);
            },
            openDiscussion: function (discussion_id) {
                document.getElementById('discussion-link-'+discussion_id).click();
            }
        }
    }
</script>