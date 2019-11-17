<template>
    <modal id="modal-claim"
            class="ticket-modal-share"
           :is-open="openModal"
           @close-modal="closeModal"
    >
        <div class="col-10 text-center">
            <h1>
                Avez-vous eu rencontré un problème avec ce billet ? {{ ticket }}
            </h1>

            <p class="mt-2">
                Si vous n’avez pas pu voyager avec ce billet, vous avez 48 heures pour nous le signaler en ouvrant un conflit avec le vendeur
            </p>

            <div class="button-my-ticket-update mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="deleteTicket()">
                    Non, j'ai une question
                </button>
            </div>

            <div class="button-my-ticket-delete mt-2 mx-auto">
                <button class="btn btn-ptb btn-upper text-uppercase w-100" @click.prevent="deleteTicket()">
                    {{ trans('tickets.component.yes') }}
                </button>
            </div>
        </div>
    </modal>
</template>

<script>
  export default {
    props: {
      openModal: {required: true},
      ticket: {required: true},
    },
    data() {
      return {

      }
    },
    methods: {
      closeModal() {
        this.$emit("close-modal", false);
      },
    },
    computed: {
    },
    mounted() {

    }
  }
</script>

<style scoped>
    #modal-claim h1 {
        font-size: 20px;
        text-align: center;
        color: black;
    }

    .button-my-ticket-update, .button-my-ticket-delete {  width: 300px;  }

    .button-my-ticket-update button {  background-color: #0b89e7;  }
    .button-my-ticket-delete button {  background-color: #f8254a;  }
</style>