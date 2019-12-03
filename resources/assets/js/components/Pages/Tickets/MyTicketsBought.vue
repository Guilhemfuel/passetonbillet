<template>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12">
                <h1 class="card-title text-left mb-0">{{trans('tickets.owned.title')}}</h1>
            </div>

            <loader class="mx-auto" v-if="loading"></loader>
            <div class="col-12" v-else>
                <div class="row">
                    <div class="col-12">
                        <h3 class="card-title text-left mb-0">Mes prochains voyage</h3>
                    </div>

                    <div v-for="ticket in futureTickets" :key="'post' + ticket.id" class="col-12">
                        <div v-if="Date.parse(ticket.train.departure_date) > dateNow">
                            <ticket-bought :ticket="ticket" @claimTicket="claim"></ticket-bought>
                        </div>
                    </div>
                    <div v-if="!futureTickets.length" class="col-12">
                        <div class="bloc-white">
                            <h4>{{ trans('tickets.no_ticket') }}</h4>
                        </div>
                    </div>

                    <div class="col-12">
                        <h3 class="card-title text-left mb-0">Mes voyages passés</h3>
                    </div>

                    <div v-for="ticket in pastTickets" :key="'past' + ticket.id" class="col-12">
                        <div v-if="Date.parse(ticket.train.departure_date) <= dateNow">
                            <ticket-bought :ticket="ticket" @claimTicket="claim"></ticket-bought>
                        </div>
                    </div>
                    <div v-if="!pastTickets.length" class="col-12">
                        <div class="bloc-white">
                            <h4>{{ trans('tickets.no_ticket') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <claim-modal-purchaser :openModal="openClaimModal" :ticket="ticketClaim" @close-modal="openClaimModal = false;"></claim-modal-purchaser>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        tickets: [],
        pastTickets: [],
        futureTickets: [],
        loading: true,
        dateNow: Date.parse(new moment().format("YYYY[-]MM[-]DD")),
        openClaimModal: false,
        ticketClaim: null,
      }
    },
    methods: {
      loadData() {
        if (this.tickets.length === 0) {
          this.$http.get(this.route('api.tickets.owned', ['future-tickets']))
            .then(response => {
              this.tickets = response.data.data;

              this.futureTickets = response.data.data;
              this.loading=false;
            });

          this.$http.get(this.route('api.tickets.owned', ['past-tickets']))
            .then(response => {
              this.pastTickets = response.data.data;
              this.loading=false;
            });
        } else {
          this.loading=false;
        }
      },
      claim(ticket) {
        this.openClaimModal = true;
        this.ticketClaim = ticket;
      }
    },
    computed: {
    },
    mounted() {
      this.loadData();
    }
  }
</script>