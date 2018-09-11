<template>
    <div>
        <img class="profile-picture rounded-circle mx-auto" :src="user.avatar">
        <h2 class="text-center txt-primary mt-2">Hello {{user.user.first_name}}!</h2>
        <p class="mt-3">{{langAuth.social.last_step_pwd}}</p>
        <form role="form"
              method="POST"
              id="pwd-form"
              :action="routeFbConfirm"
              @submit.prevent="validateBeforeSubmit"
              ref="form"
        >
            <input type="hidden" name="_token" :value="csrf"/>

            <input-text type="email"
                        :default-value="user.user.email"
                        validation="required|email"
                        name="email"
                        label="Email Address"
                        placeholder="Email Address">

            </input-text>

            <div class="col-xs-12 form-group">
                <label for="password"
                       class="control-label">{{langProfile.modal.change_password.component.password}}
                    <small class="text-muted">(8 char. min)</small>
                </label>
                <input id="password" type="password"
                       class="form-control"
                       name="password"
                       v-validate="'required|min:8'"
                       required :placeholder="langProfile.modal.change_password.component.password">
                <span v-cloak v-if="errors.has('password')"
                      class="invalid-feedback d-inline">{{ errors.first('password') }}</span>

            </div>

            <div class="col-xs-12 form-group">
                <label for="password-confirm"
                       class="control-label">{{langProfile.modal.change_password.component.password_confirm}}</label>

                <input id="password-confirm" type="password"
                       class="form-control"
                       name="password_confirmation"
                       v-validate="'required|confirmed:password|min:8'"
                       required
                       :placeholder="langProfile.modal.change_password.component.password_confirm">
                <span v-cloak
                      :class="{'invalid-feedback':true,'d-inline':errors.has('password_confirmation')}">{{ errors.first('password_confirmation')
                    }}</span>
            </div>

            <input-text name="cgu"
                        type="checkbox"
                        :label="trans('auth.register.cgu')"
                        validation="required">
            </input-text>

            <div class="form-group mt-4">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-ptb-blue btn-block">
                        {{langAuth.register.title}}
                    </button>
                </div>
            </div>

        </form>
    </div>
</template>

<script>

    export default {
        props: {
            user: {type: Object, required: true},
            langAuth: {type: Object, required: true},
            langProfile: {type: Object, required: true},
            routeFbConfirm: {type: String, required: true},

        },
        data: function () {
            return {
                count: 0,
                csrf: null
            }
        },
        methods: {
            validateBeforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    this.$refs.form.submit();
                });
            }
        },
        mounted() {
            this.csrf = window.csrf;
        }
    }
</script>
