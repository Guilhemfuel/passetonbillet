<template>
    <div class="col-12">

        <h1 class="card-title text-left mb-0">{{trans('tickets.owned.title')}}</h1>

        <loader class="mx-auto" v-if="loading"></loader>
        <div class="row mt-3" v-else>

            <h3 class="card-title text-left mb-0">Mes prochains voyage</h3>
            <div v-for="ticket in tickets" :key="'post' + ticket.id" class="col-12">
                <div v-if="Date.parse(ticket.train.departure_date) > dateNow">
                    <ticket-bought :ticket="ticket" @claimTicket="claim"></ticket-bought>
                </div>
            </div>

            <h3 class="card-title text-left mb-0">Mes voyages passés</h3>
            <div v-for="ticket in tickets" :key="'past' + ticket.id" class="col-12">
                <div v-if="Date.parse(ticket.train.departure_date) <= dateNow">
                    <ticket-bought :ticket="ticket" @claimTicket="claim"></ticket-bought>
                </div>
            </div>
        </div>

        <claim-modal :openModal="openClaimModal" :ticket="ticketIdClaim" @close-modal="openClaimModal = false; ticketIdClaim = null"></claim-modal>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        tickets: [],
        loading: true,
        dateNow: Date.parse(new moment().format("YYYY[-]MM[-]DD")),
        openClaimModal: false,
        ticketIdClaim: null,
    }
    },
    methods: {
      loadData() {
        if (this.tickets.length === 0) {
          this.$http.get(this.route('api.tickets.owned', ['bought']))
            .then(response => {
              this.tickets = response.data.data;
              this.loading=false;
            });
        } else {
          this.loading=false;
        }
      },
      claim(ticketId) {
        this.openClaimModal = true;
        this.ticketIdClaim = ticketId;
      }
    },
    computed: {
    },
    mounted() {
      this.loadData();
    }
  }
</script>