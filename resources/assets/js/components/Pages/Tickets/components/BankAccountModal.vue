<template>
    <modal id="modal-claim"
           class="ticket-modal-share"
           :is-open="openModal"
           @close-modal="closeModal"
    >
        <div>
            <h4 class="card-text text-center font-weight-bold">{{ trans('profile.modal.bank_account.payment_info') }}</h4>

            <form action="" method="post" id="formRegistrationCard" class="w-100 m-auto row">
                <div class="col-12">
                    <input type="text" name="nameAccount" v-model="form.nameAccount" value="" :placeholder="trans('profile.owner_name')">
                    <div class="clear"></div>
                </div>

                <div class="col-12">
                    <input type="text" name="iban" v-model="form.iban" value="" :placeholder="trans('profile.iban')">
                    <div class="clear"></div>
                </div>

                <div class="col-12">
                    <input type="text" name="address" v-model="form.address" value="" :placeholder="trans('profile.address')">
                    <div class="clear"></div>
                </div>

                <div class="col-6">
                    <input type="text" name="city" v-model="form.city" value="" :placeholder="trans('profile.city')">
                    <div class="clear"></div>
                </div>

                <div class="col-6">
                    <input type="text" name="postal" v-model="form.postal" value="" :placeholder="trans('profile.cp')">
                    <div class="clear"></div>
                </div>

                <div class="col-sm-12 col-md-12">
                    <button class="btn btn-ptb btn-upper mt-3 w-100" @click.prevent="saveBankAccount">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </modal>
</template>

<script>
  export default {
    props: {
      openModal: {required: true},
    },
    data() {
      return {
        form: {
          nameAccount: null,
          iban: null,
          address: null,
          city: null,
          postal: null,
        }
      }
    },
    methods: {
      closeModal() {
        this.$emit("close-modal", false);
      },
      handleResponse(response) {
        if(response.body.state) { this.state = response.body.state; }
        if(response.body.message) { this.$message({message: response.body.message, type: response.body.type}) }
      },
      loadData() {
        this.$http.get(this.route('api.user.get.bank_account'))
          .then(response => {
            if(response.body.bankAccount) {
              console.log(response.body.bankAccount)
              this.form.nameAccount = response.body.bankAccount.OwnerName;
              this.form.iban = response.body.bankAccount.Details.IBAN;
              this.form.address = response.body.bankAccount.OwnerAddress.AddressLine1;
              this.form.city = response.body.bankAccount.OwnerAddress.City;
              this.form.postal = response.body.bankAccount.OwnerAddress.PostalCode;
            }
          });
      },
      saveBankAccount() {
        console.log(this.form)
        this.$http.post(this.route('api.user.update.bank_account'), this.form)
          .then(response => {
            console.log(response.data);
            this.handleResponse(response)
          });
      },
    },
    computed: {},
    mounted() {
      this.loadData();
    }
  }
</script>