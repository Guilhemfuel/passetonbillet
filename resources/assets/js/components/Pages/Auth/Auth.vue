<template>
    <div>

        <!-- LOGIN-->

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type==states.login" class="content">
                <h1 class="text-dark">{{trans('auth.auth.title')}}</h1>
                <p>
                    <a href="#" class="mb-4 a" @click.prevent="openRegister()">{{trans('auth.auth.not_registered_yet')}}</a>
                </p>
                <a class="btn btn-facebook btn-facebook-login text-white btn-block mb-5" :href="routes.facebook" @click.prevent="$root.logEvent('login_facebook_connect_button',null,$event)">
                    <i class="fa fa-facebook pull-left"></i> Facebook Connect
                </a>
                <form role="form"
                      method="POST"
                      :action="routes.login"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{trans('auth.auth.email')}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')"
                               name="email"
                               required v-validate="'required|email'"
                        >
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{trans('auth.auth.password')}}</label>

                        <input id="password" type="password" class="form-control" name="password"
                               required>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="remember" checked>
                                    {{trans('auth.auth.remember_me')}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-ptb-orange btn-block">
                                {{trans('auth.auth.title')}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="text-center">
                    <a href="#" class="mb-3 text)" @click.prevent="openResetPssword()">
                        {{trans('auth.reset.question')}}
                    </a>
                </div>
            </div>

        </transition>

        <!-- REGISTER -->

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInDownBig"
                    leave-active-class="animated fadeOutUpBig">
            <div v-if="type==states.register" class="content">
                <h1 class="text-dark" v-if="!ticket">{{trans('auth.register.title')}}</h1>
                <h1 class="text-dark" v-else>{{trans('auth.register.title_ticket')}} {{ticket.train.arrival_city.name}}</h1>

                <p>
                    <a href="#" class="a" @click.prevent="openLogin()">{{trans('auth.register.already_registered')}}</a>
                </p>
                <div class="text-danger" v-if="customErrors.length > 0">
                    <p>Whoops!</p>
                    <p v-for="error in customErrors">{{error}}</p>
                </div>

                <!-- MANUAL REGISTER -->

                <div id="registerForm" v-if="registerType == registerStates.form">


                    <vue-form :action="routes.register">


                        <div class="row">
                            <input-text name="first_name"
                                        class-name="col-xs-12 col-sm-6"
                                        :label="trans('auth.register.first_name')"
                                        validation="required"
                                        :placeholder="trans('auth.register.first_name')"
                            ></input-text>

                            <input-text name="last_name"
                                        class-name="col-xs-12 col-sm-6"
                                        :label="trans('auth.register.last_name')"
                                        validation="required"
                                        :placeholder="trans('auth.register.last_name')"
                            ></input-text>

                        </div>

                        <div class="col-xs-12 form-group">
                            <label for="gender" class="control-label">{{trans('auth.register.gender.title')}}</label>

                            <div class="gender-input">
                                <el-radio-group v-model="form.gender">
                                    <el-radio-button :label="1">{{trans('auth.register.gender.male')}}</el-radio-button>
                                    <el-radio-button :label="0">{{trans('auth.register.gender.female')}}</el-radio-button>
                                </el-radio-group>
                                <input name="gender" type="hidden" :value="form.gender"/>
                            </div>
                        </div>

                        <input-date
                                    name="birthdate"
                                    class-name="col-xs-12"
                                    :label="trans('auth.register.birthdate')"
                                    placeholder="DD/MM/YYYY"
                                    format="dd/MM/yyyy"
                                    value-format="dd/MM/yyyy"
                                    default-value-format="DD/MM/YYYY"
                                    validation="required"
                        ></input-date>

                        <input-text name="email"
                                    type="email"
                                    class-name="col-xs-12"
                                    :label="trans('auth.register.email')"
                                    :placeholder="trans('auth.register.email')"
                                    validation="required|email"
                        ></input-text>

                        <input-text name="password"
                                    type="password"
                                    class-name="col-xs-12"
                                    :label="trans('auth.register.password')"
                                    :placeholder="trans('auth.register.password')"
                                    validation="required|min:8"
                        ></input-text>

                        <input-text name="password_confirmation"
                                    type="password"
                                    class-name="col-xs-12"
                                    :label="trans('auth.register.password_confirm')"
                                    :placeholder="trans('auth.register.password_confirm')"
                                    validation="required|min:8"
                        ></input-text>

                        <input-country name="country_residence"
                                       :label="trans('profile.modal.verify_identity.country_residence')"
                                       validation="required"
                                       :placeholder="trans('profile.modal.verify_identity.country_residence')"
                        ></input-country>

                        <input-country name="nationality"
                                       :label="trans('profile.modal.verify_identity.nationality')"
                                       validation="required"
                                       :placeholder="trans('profile.modal.verify_identity.nationality')"
                        ></input-country>

                        <input-text name="cgu"
                                    type="checkbox"
                                    :label="trans('auth.register.cgu')"
                                    validation="required">
                        </input-text>

                        <button type="submit" class="btn btn-ptb-orange btn-block mt-4">
                            {{trans('auth.register.title')}}
                        </button>

                    </vue-form>

                    <div class="btn-rack mt-4">
                        <a class="btn btn-facebook" :href="routes.facebook" @click.prevent="$root.logEvent('register_facebook_connect_button',null,$event)">
                            <i class="fa fa-facebook pull-left"></i> Facebook Connect
                        </a>
                        <button class="btn btn-outline-orange" @click.prevent="openLogin()">
                            {{trans('auth.auth.title')}}
                        </button>
                    </div>
                </div>

                <!-- REGISTER MENU -->

                <div id="defaultRegister"  v-if="registerType == registerStates.default">
                    <p class="mb-b" v-if="ticket">
                        {{trans('auth.register.ticketLinkMessage')}}
                    </p>

                    <a class="btn btn-facebook btn-block" :href="routes.facebook" @click.prevent="$root.logEvent('register_facebook_connect_button',null,$event)">
                        <i class="fa fa-facebook pull-left"></i> {{trans('auth.register.fb_register')}}
                    </a>
                    <button class="btn btn-ptb-orange btn-block" @click.prevent="registerType = registerStates.form">
                        {{trans('auth.register.manually')}}
                    </button>
                </div>


            </div>
        </transition>

        <!-- ASK FOR RESET PASSWORD -->

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type==states.password_reset" class="content">
                <h1 class="text-dark">{{trans('auth.reset.title')}}</h1>

                <form role="form"
                      method="POST"
                      :action="routes.reset_for_email"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <input type="hidden" name="token" value="token">


                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{trans('auth.auth.email')}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')"
                               name="email"
                               required v-validate="'required|email'"
                               :placeholder="trans('auth.auth.email')"
                        >
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="form-group mt-4">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-ptb-orange btn-block">
                                {{trans('auth.reset.submit')}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="btn-rack mt-4">
                    <button class="btn btn-outline-orange" @click.prevent="openRegister()">
                        {{trans('auth.register.title')}}
                    </button>
                    <button class="btn btn-outline-orange" @click.prevent="openLogin()">
                        {{trans('auth.auth.title')}}
                    </button>
                </div>
            </div>

        </transition>

        <!-- RESET PASSWORD -->

        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type==states.change_password" class="content">
                <h1 class="text-dark">{{trans('auth.new_password.title')}}</h1>

                <form role="form"
                      method="POST"
                      :action="routes.reset_password"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <input type="hidden" name="token" :value="token">

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{trans('auth.auth.email')}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')"
                               name="email"
                               required v-validate="'required|email'"
                               :placeholder="trans('auth.auth.email')"
                        >
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{trans('auth.register.password')}}
                            <small class="text-muted">(8 char. min)</small>
                        </label>
                        <input id="password" type="password"
                               :class="{'form-control': true, 'is-invalid': errors.has('password') }"
                               name="password" v-validate="'required|min:8'"
                               required :placeholder="trans('auth.register.password')">
                        <span v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password')
                            }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password-confirm"
                               class="control-label">{{trans('auth.register.password_confirm')}}</label>

                        <input id="password-confirm" type="password"
                               :class="{'form-control': true, 'is-invalid': errors.has('password_confirmation') }"
                               name="password_confirmation" v-validate="'required|confirmed:password|min:8'"
                               required :placeholder="trans('auth.register.password')">
                        <span v-if="errors.has('password_confirmation')"
                              class="invalid-feedback">{{ errors.first('password_confirmation') }}</span>

                    </div>

                    <div class="form-group mt-4">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-ptb-blue btn-block">
                                {{trans('auth.new_password.submit')}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="btn-rack mt-4">
                    <button class="btn btn-outline-orange" @click.prevent="openRegister()">
                        {{trans('auth.register.title')}}
                    </button>
                    <button class="btn btn-outline-orange" @click.prevent="openLogin()">
                        {{trans('auth.auth.title')}}
                    </button>
                </div>
            </div>

        </transition>
    </div>
</template>

<script>


    var defaultPageTitle = 'PasseTonBillet - ';
    export default {
        props: {
            token: {required: false},
            authType: {type: String, required: true},
            routes: {type: Object, required: true},
            ticket: {type: Object, required: false},
            old: {
                type: Object, required: false, default: () => {
                }
            },
            defaultEmail: {required: false, type: String},
            states: {
                type: Object, default: () => {
                    return {
                        password_reset: 'password_reset',
                        register: 'register',
                        login: 'login',
                        change_password: 'change_password'
                    }
                }
            },
            registerStates: {
                type: Object, default: () => {
                    return {
                        default: 'default',
                        form: 'form'
                    }
                }
            }
        },
        data() {
            return {
                csrf: window.csrf,
                type: this.authType,
                registerType: this.registerStates.default,
                customErrors: [],
                form: {
                    gender: 0,
                    first_name: this.old ? (this.old.first_name ? this.old.first_name : null) : null,
                    last_name: this.old ? (this.old.last_name ? this.old.last_name : null) : null,
                    location: this.old ? (this.old.location ? this.old.location : null) : null,
                }
            }
        },
        methods: {
            openResetPssword() {
                // Scroll to top for smoother animation
                this.scrollToTop(100);

                // Clear errors
                this.errors.clear();
                this.customErrors = [];

                this.type = this.states.password_reset;
                document.title = defaultPageTitle + 'Reset Password';
                window.history.pushState('Register', 'Reset Password', '/password/reset');

            },
            openRegister() {
                // Clear errors
                this.errors.clear();
                this.customErrors = [];

                this.type = this.states.register;
                this.registerType = this.registerStates.default;
                document.title = defaultPageTitle + 'Register';
                window.history.pushState('Register', 'Register', '/register');

            },
            openLogin() {
                // Scroll to top for smoother animation
                this.scrollToTop(100);

                // Clear errors
                this.errors.clear();
                this.customErrors = [];

                this.type = this.states.login;

                // Update browser info
                document.title = defaultPageTitle + 'Login';
                window.history.pushState('Login', 'Login', '/login');

            },
            scrollToTop(scrollDuration) {
                var scrollStep = -window.scrollY / (scrollDuration / 15),
                    scrollInterval = setInterval(function () {
                        if (window.scrollY != 0) {
                            window.scrollBy(0, scrollStep);
                        }
                        else clearInterval(scrollInterval);
                    }, 15);
            }

        },
    }
</script>
