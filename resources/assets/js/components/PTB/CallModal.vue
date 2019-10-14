<template>
    <div class="call-component">

        <div class="open-call-modal" @click.prevent="openModal()">
            <slot></slot>
        </div>

        <modal :is-open="trulyOpened"
               @close-modal="closeModal()"
               :title="trans('tickets.component.call_seller_modal.title')"
               class="review-modal">

            <p class="text-justify">
                {{trans('tickets.component.call_seller_modal.text')}}
            </p>

            <div class="col justify-content-center d-flex">

                <div>
                    <template v-if="frNumber!=null">
                        <a :href="'tel:'+frNumber"
                           class="btn btn-ptb mt-3 btn-upper">
                            <i class="fa fa-phone" aria-hidden="true"></i> {{frNumber}} <span
                                class="flag-icon flag-icon-fr"></span>
                        </a>
                    </template>
                    <template v-else-if="frLoading">
                        <button class="btn btn-ptb mt-3 btn-upper">
                            <loader class="mx-auto loader-btn"></loader>
                        </button>
                    </template>
                    <template v-else>
                        <button class="btn btn-ptb mt-3 btn-upper" @click="callSeller('fr')">
                            <span class="flag-icon flag-icon-fr"></span>
                            {{trans('tickets.component.call_seller_modal.btn_cta')}}
                        </button>
                    </template>
                    <p class="pricing mb-0 text-center">{{trans('tickets.component.call_seller_modal.pricing_fr')}}</p>
                </div>

            </div>
            <div class="col justify-content-center d-flex">

                <div>
                    <template v-if="ukNumber!=null">
                        <a :href="'tel:'+ukNumber"
                           class="btn btn-ptb mt-3 btn-upper">
                            <i class="fa fa-phone" aria-hidden="true"></i> {{ukNumber}} <span
                                class="flag-icon flag-icon-gb"></span>
                        </a>
                    </template>
                    <template v-else-if="ukLoading">
                        <button class="btn btn-ptb mt-3 btn-upper">
                            <loader class="mx-auto loader-btn"></loader>
                        </button>
                    </template>
                    <template v-else>
                        <button class="btn btn-ptb mt-3 btn-upper" @click="callSeller('uk')">
                            <span class="flag-icon flag-icon-gb"></span>
                            {{trans('tickets.component.call_seller_modal.btn_cta')}}
                        </button>
                    </template>
                    <p class="pricing mb-0 text-center">{{trans('tickets.component.call_seller_modal.pricing_uk')}}</p>
                </div>
            </div>
        </modal>
    </div>
</template>

<script>
    export default {
        props: {
            ticket: {required: true},
            isOpen: {required: false, default: null}
        },
        data() {
            return {
                user: this.$root.user,
                modalCallOpened: this.isOpen == null ? false : null,

                ukNumber: null,
                frNumber: null,

                ukLoading: false,
                frLoading: false,
            }
        },
        mounted() {
        },
        computed: {
            trulyOpened() {
                if (this.isOpen == true || this.modalCallOpened == true) {
                    return true;
                }
                return false;
            }
        },
        methods: {
            openModal() {
                // Only update that if modal not controlled externally
                if (this.isOpen == null) {
                    this.modalCallOpened = true;
                }

                // Log Offer
                this.$root.logEvent('open_modal_call', {
                    ticket_id: this.ticket.id,
                });
            },
            closeModal() {
                // Only update that if modal not controlled externally
                if (this.isOpen == null) {
                    this.modalCallOpened = false;
                }
                this.$emit('close-modal');
            },
            callSeller(country) {
                if (!['fr', 'uk'].includes(country)) {
                    console.error('Country ' + country + ' not defined.');
                    return;
                }

                if (country == 'fr') {
                    this.frLoading = true;
                } else if (country == 'uk') {
                    this.ukLoading = true;
                }

                // Query contact number if null
                if ((this.ukNumber == null && country == 'uk') ||
                    (this.frNumber == null && country == 'fr')) {

                    this.$http.get(this.route('api.tickets.phone_number', {
                        ticket: this.ticket.id,
                        country: country
                    })).then((response) => {

                        // Success in getting number
                        if (response.ok) {

                            if (country == 'fr') {
                                this.frNumber = response.body.phone;
                                // Expire number after 3 minutes
                                setTimeout(() => {
                                    this.frNumber = null;
                                }, 30 * 1000);
                            } else if (country == 'uk') {
                                this.ukNumber = response.body.phone;
                                // Expire number after 3 minutes
                                setTimeout(() => {
                                    this.ukNumber = null;
                                }, 30 * 1000);
                            }

                            this.frLoading = false;
                            this.ukLoading = false;

                            // Log Offer
                            this.$root.logEvent('show_number', {
                                ticket_id: this.ticket.id,
                                country: country
                            });

                            return;
                        } else {
                            this.$message({
                                dangerouslyUseHTMLString: true,
                                message: response.body.message,
                                type: 'error',
                                showClose: true,
                                duration: 1000
                            });
                        }

                    }, response => {

                        if (country == 'fr') {
                            this.frLoading = false;
                        } else if (country == 'uk') {
                            this.ukLoading = false;
                        }

                        if (!response.ok) {
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
        },
        watch: {
            modalCallOpened: function(value) {
                if (value == true ) {
                    this.callSeller('uk');
                    this.callSeller('fr');
                }
            },
            isOpen: function(value) {
                if (value == true ) {
                    this.callSeller('uk');
                    this.callSeller('fr');
                }
            }
        }
    }
</script>
