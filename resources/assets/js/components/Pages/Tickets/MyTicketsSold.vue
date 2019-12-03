<template>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12">
                <h1 class="card-title text-left mb-0">{{trans('tickets.owned.title')}}</h1>
            </div>

            <loader class="mx-auto" v-if="loading"></loader>
            <div class="col-12" v-else>
                <div class="row">
                    <div v-for="ticket in tickets" :key="ticket.id" class="col-12">
                        <ticket-sold :ticket="ticket"></ticket-sold>
                    </div>
                    <div v-if="!tickets.length" class="col-12">
                        <div class="bloc-white">
                            <h4>{{ trans('tickets.no_ticket') }}</h4>
                        </div>
                    </div>
                </div>
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