<template>
    <div class="col-12 mt-3">
        <div class="row">
            <loader class="mx-auto" v-if="loading"></loader>
            <div class="col-12" v-else>
                <div class="row">
                    <div class="col-12 d-flex justify-content-lg-end">
                        <div class="col-lg-6 col-md-6 col-8">
                            <button class="btn btn-ptb btn-upper text-uppercase w-100 text-wrap"
                                    @click.prevent="updateBankAccount">
                                {{ trans('tickets.update_bank_account') }}
                            </button>
                        </div>
                    </div>

                    <div v-if="ticketsWithClaims.length" class="col-12">
                        <div class="row">
                            <h3 class="card-title text-left mb-0">Mes conflits</h3>
                            <div v-for="ticket in ticketsWithClaims" :key="'post' + ticket.id" class="col-12">
                                <ticket-payment :ticket="ticket" @claimTicket="claim"></ticket-payment>
                            </div>
                        </div>
                    </div>

                    <h3 class="card-title text-left mb-0">Mes paiements en attente</h3>
                    <div v-for="ticket in ticketsInWait" :key="'post' + ticket.id" class="col-12">
                        <ticket-payment :ticket="ticket" @claimTicket="claim"></ticket-payment>
                    </div>

                    <div v-if="!ticketsInWait.length" class="col-12">
                        <div class="bloc-white">
                            <h4>{{ trans('tickets.no_ticket') }}</h4>
                        </div>
                    </div>

                    <h3 class="card-title text-left mb-0">Mes paiements passés</h3>
                    <div v-for="ticket in ticketsFinish" :key="'post' + ticket.id" class="col-12">
                        <ticket-payment :ticket="ticket" @claimTicket="claim"></ticket-payment>
                    </div>

                    <div v-if="!ticketsFinish.length" class="col-12">
                        <div class="bloc-white">
                            <h4>{{ trans('tickets.no_ticket') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <claim-modal-seller :openModal="openClaimModal" :ticket="ticketClaim" @close-modal="openClaimModal = false;"></claim-modal-seller>

        <bank-account-modal :openModal="openBankAccountModal" @close-modal="openBankAccountModal = false;"></bank-account-modal>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        tickets: [],
        ticketsWithClaims: [],
        ticketsInWait: [],
        ticketsFinish: [],
        loading: true,
        dateNow: Date.parse(new moment().format("YYYY[-]MM[-]DD")),
        openClaimModal: false,
        openBankAccountModal: false,
        ticketClaim: null,
      }
    },
    methods: {
      loadData() {
        if (this.tickets.length === 0) {
          this.$http.get(this.route('api.tickets.owned', ['payment']))
            .then(response => {
              this.tickets = response.data;

              console.log(this.tickets);

              this.ticketsWithClaims = response.data.ticketsWithClaims;
              this.ticketsInWait = response.data.ticketsInWait;
              this.ticketsFinish = response.data.ticketsFinish;

              this.loading = false;
            });
        } else {
          this.loading = false;
        }
      },
      claim(ticket) {
        this.openClaimModal = true;
        this.ticketClaim = ticket;
      },
      updateBankAccount() {
        this.openBankAccountModal = true;
      },
    },
    computed: {},
    mounted() {
      this.loadData();
    }
  }
</script>

<style scoped>
    .bloc-white {
        border-radius: 20px;
        background-color: white;
        margin: 10px 0;
        padding: 20px;
        text-align: center;
    }

    .text-wrap {
        white-space: normal;
    }
</style>