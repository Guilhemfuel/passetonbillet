<template>
    <modal :is-open="isOpen"
           @close-modal="closeModal()"
           :title="trans('message.awaiting_offers.deny_modal.title')"
    >
        <template v-if="isOpen">

            <template v-if="loading">
                <loader class="mx-auto my-4"></loader>
            </template>

            <!-- DENY CAUSE ALREADY SOLD -->
            <template v-else-if="state==states.alreadySold">

                <p v-if="acceptedOffers.length>0" v-html="trans('message.awaiting_offers.deny_modal.already_sold.text_offers')"></p>
                <p v-else v-html="trans('message.awaiting_offers.deny_modal.already_sold.text_no_offers')"></p>

                <button class="btn btn-ptb-blue btn-block my-2"
                        @click="soldToDiscussion(acceptedOffer.id)"
                        v-if="acceptedOffers.length>0"
                        v-for="acceptedOffer in acceptedOffers">{{trans('message.awaiting_offers.deny_modal.already_sold.sold_to')}} {{acceptedOffer.buyer.full_name}}</button>
                <button class="btn btn-ptb btn-block my-2" @click="soldElseWhere()">{{trans('message.awaiting_offers.deny_modal.already_sold.sold_else_where')}}</button>
                <button class="btn btn-outline-orange btn-block my-2" @click="closeModal()">
                    {{trans('message.awaiting_offers.deny_modal.cancel_button')}}
                </button>

            </template>

            <!-- SOLD ON ANOTHER SITE -->
            <template v-else-if="state==states.soldElseWhere">

                <p v-html="trans('message.awaiting_offers.deny_modal.sold_else_where.text')"></p>

                <button class="btn btn-ptb-blue btn-block my-2" @click="alreadySold()">{{trans('message.awaiting_offers.deny_modal.sold_else_where.sold_on_ptb_button')}}</button>
                <button class="btn btn-ptb btn-block my-2" @click="denyOffer()">{{trans('message.awaiting_offers.deny_modal.sold_else_where.sold_else_where')}}</button>
                <button class="btn btn-outline-orange btn-block my-2" @click="closeModal()">
                    {{trans('message.awaiting_offers.deny_modal.cancel_button')}}
                </button>

            </template>

            <!-- DENY CAUSE NOT FOR SALE ANYMORE -->
            <template v-else-if="state==states.notForSaleAnymore">
                <p v-html="trans('message.awaiting_offers.deny_modal.not_for_sale_anymore.text')"></p>

                <button class="btn btn-ptb-blue btn-block my-2" @click="alreadySold()">{{trans('message.awaiting_offers.deny_modal.not_for_sale_anymore.sold_on_ptb_button')}}</button>
                <button class="btn btn-ptb btn-block my-2" @click="denyOffer()">{{trans('message.awaiting_offers.deny_modal.not_for_sale_anymore.confirm_button')}}</button>
                <button class="btn btn-outline-orange btn-block my-2" @click="closeModal()">
                    {{trans('message.awaiting_offers.deny_modal.cancel_button')}}
                </button>
            </template>

            <!-- REASON FOR DENIAL -->
            <template v-else-if="state==states.start">
                <p v-html="trans('message.awaiting_offers.deny_modal.find_reason.text')"></p>

                <button class="btn btn-ptb-blue btn-block my-2" @click="denyOffer()">{{trans('message.awaiting_offers.deny_modal.find_reason.low_price_button')}}</button>
                <button class="btn btn-ptb-blue btn-block my-2" @click="alreadySold()">{{trans('message.awaiting_offers.deny_modal.find_reason.already_sold_button')}}</button>
                <button class="btn btn-ptb-blue btn-block my-2" @click="notForSaleAnymore()">{{trans('message.awaiting_offers.deny_modal.find_reason.not_for_sale_button')}}</button>
                <button class="btn btn-outline-orange btn-block my-2" @click="closeModal()">
                    Oups, je ne veux pas refuser l'offre
                </button>
            </template>

            <!-- Hidden forms ready to submit -->

            <vue-form :id="'deny-form-'+offer.id" method="post" :action="route('public.message.offer.deny')">
                <input type="hidden" name="discussion_id" :value="offer.id"/>
                <input type="hidden" name="delete_ticket" value="1" v-if="deleteTicketWithDeny"/>
                <input type="hidden" name="discussion_where_sold_id" :value="soldToDiscussionId" v-if="soldToDiscussionId"/>
            </vue-form>

        </template>

    </modal>
</template>

<script>
    export default {
        props: {
            offer: {type: Object, required: false},
            isOpen: {type: Boolean, required: true}
        },
        data() {
            return {
                state: 'start',
                states: {
                    start: 'start',
                    alreadySold: 'already_sold',
                    notForSaleAnymore: 'notForSaleAnymore',
                    soldElseWhere: 'sold-else-where'
                },

                user: this.$root.user,
                acceptedOffers: null,
                loading: false,

//                Form data
                deleteTicketWithDeny: false,
                soldToDiscussionId: null
            }
        },
        computed: {},
        methods: {
            /**
             * Deny offer and mark ticket as sold
             * @param id
             */
            soldToDiscussion(id) {
                this.soldToDiscussionId = id;
                this.deleteTicketWithDeny = false;
                this.denyOffer();
            },
            /**
             * Confirm deny offer and delete ticket
             */
            soldElseWhere() {
                this.deleteTicketWithDeny = true;
                this.soldToDiscussionId = null;
                this.state = this.states.soldElseWhere;
            },
            /**
             * Confirm deny offer and delete ticket if ticket not for sale
             */
            notForSaleAnymore() {
                this.deleteTicketWithDeny = true;
                this.soldToDiscussionId = null;
                this.state = this.states.notForSaleAnymore;
            },
            /**
             * Close modal and reset its values
             */
            closeModal() {
                this.loading = false;
                this.state = this.states.start;
                this.acceptedOffers = null;
                this.$emit('close-modal');
            },
            /**
             * Submit deny form
             */
            denyOffer() {
                // Wait to reflect form changes
                this.$nextTick(function () {
                    document.getElementById('deny-form-' + this.offer.id).submit();
                })
            },
            /**
             * Set state to already sold and query all offers for this ticket
             */
            alreadySold() {
                this.deleteTicketWithDeny = false;
                this.soldToDiscussionId = null;
                this.loading = true;
                this.state = this.states.alreadySold;

                // Now we query all offers for this ticket
                this.$http.get(this.route('api.tickets.offers', [this.offer.ticket.id]))
                    .then(response => {
                        this.acceptedOffers = response.data.data;
                        this.loading = false;
                    }, response => {
                        // error callback
                        this.$message.error(this.trans("common.error"));
                        this.closeModal();
                    });
            }
        }
    }
</script>