<template>

    <div class="delete-account mt-2">
        <button class="btn btn-block btn-outline-danger"
                @click.prevent="modalOpened=true">{{trans('profile.delete_account')}}
        </button>

        <modal :is-open="modalOpened"
               :title="trans('profile.delete_account')"
               @close-modal="modalOpened=false"
        >
            <p class="text-justify mb-3">{{trans('profile.modal.delete_account.text')}}</p>

            <button class="btn btn-block btn-ptb-blue" @click.prevent="modalOpened=false">{{trans('profile.modal.delete_account.cancel')}}</button>
            <vue-form method="DELETE" :action="route('public.profile.delete-account')">
                <input type="hidden" name="user_id" :value="user.id">
                <button class="mt-2 btn btn-block btn-outline-danger" type="submit">{{trans('profile.modal.delete_account.cta')}}</button>
            </vue-form>
        </modal>
    </div>
</template>

<script>

    export default {
        props: {
        },
        data() {
            return {
                modalOpened: false,
                user: this.$root.user
            }
        },
        computed: {}
    }
</script>
