<template>
    <div class="col-12">

        <h1 class="card-title text-left mb-0">{{trans('tickets.owned.title')}}</h1>

        <loader class="mx-auto" v-if="loading"></loader>
        <div class="row" v-else>
            <div v-for="ticket in tickets" :key="ticket.id" class="col-12">
                <ticket-sold :ticket="ticket"></ticket-sold>
            </div>
            <div v-if="!tickets.length">
                <h3>{{ trans('tickets.no_ticket') }}</h3>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        tickets: [],
        loading: true,
      }
    },
    methods: {
      loadData() {
        if (this.tickets.length === 0) {
          this.$http.get(this.route('api.tickets.owned', ['selling']))
            .then(response => {
              this.tickets = response.data.data;
              this.loading=false;
            });
        } else {
          this.loading=false;
        }
      }
    },
    computed: {
    },
    mounted() {
      this.loadData();
    }
  }
</script>