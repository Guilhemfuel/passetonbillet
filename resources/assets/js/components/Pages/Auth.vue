<template>
    <div>
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type=='login'" class="content">
                <h1 class="text-primary">{{lang.auth.title}}</h1>
                <p>
                    <a href="#" class="mb-4" @click.prevent="openRegister()">{{lang.auth.not_registered_yet}}</a>
                </p>
                <form role="form"
                      method="POST"
                      :action="routes.login"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{lang.auth.email}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')"
                               name="email"
                               required  v-validate="'required|email'"
                               :placeholder="lang.auth.email"
                        >
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{lang.auth.password}}</label>

                        <input id="password" type="password" class="form-control" name="password"
                               required>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"
                                           name="remember">
                                    {{lang.auth.remember_me}}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-lastar-blue btn-block">
                                {{lang.auth.title}}
                            </button>
                        </div>
                    </div>
                </form>
                <a href="#" class="mb-4" @click.prevent="openResetPssword()">
                    {{lang.reset.question}}
                </a>
                <div class="actions btn-rack mt-4">
                    <a class="btn btn-facebook text-white" :href="routes.fb_connect">
                        <i class="fa fa-facebook"></i> Facebook Connect
                    </a>
                    <button class="btn btn-outline-purple" @click.prevent="openRegister()">
                        {{lang.register.title}}
                    </button>
                </div>
            </div>

        </transition>
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInDownBig"
                    leave-active-class="animated fadeOutUpBig">
            <div v-if="type=='register'" class="content">
                <h2 class="text-primary">{{lang.register.title}}</h2>
                <p>
                    <a href="#" @click.prevent="openLogin()">{{lang.register.already_registered}}</a>
                </p>
                <div class="text-danger" v-if="customErrors.length > 0">
                    <p>Whoops!</p>
                    <p v-for="error in customErrors">{{error}}</p>
                </div>
                <form role="form"
                      method="POST"
                      :action="routes.register"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="first_name"
                                   class="control-label">{{lang.register.first_name}}</label>

                            <input id="first_name" type="text"
                                   :class="{'form-control': true, 'is-invalid': errors.has('first_name') }"
                                   name="first_name" required v-validate="'required'"
                                   :placeholder="lang.register.first_name"  v-model="form.first_name">
                            <span v-if="errors.has('first_name')" class="invalid-feedback">{{ errors.first('first_name')
                                }}</span>

                        </div>

                        <div class="col-xs-12 col-sm-6 form-group">
                            <label for="last_name"
                                   class="control-label">{{lang.register.last_name}}</label>

                            <input id="last_name" type="text"
                                   :class="{'form-control': true, 'is-invalid': errors.has('last_name') }"
                                   name="last_name" required v-validate="'required'"
                                   :placeholder="lang.register.last_name" v-model="form.last_name">
                            <span v-if="errors.has('last_name')" class="invalid-feedback">{{ errors.first('last_name')
                                }}</span>

                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="gender" class="control-label">{{lang.register.gender.title}}</label>

                        <div class="gender-input">
                            <el-radio-group v-model="form.gender">
                                <el-radio-button :label="1">{{lang.register.gender.male}}</el-radio-button>
                                <el-radio-button :label="0">{{lang.register.gender.female}}</el-radio-button>
                            </el-radio-group>
                            <input name="gender" type="hidden" :value="form.gender"/>
                        </div>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="birthdate" class="control-label">{{lang.register.birthdate}}</label>

                        <datepicker id="birthdate" type="date"
                                    name="birthdate" :placeholder="lang.register.birthdate" v-model="form.birthdate"></datepicker>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="location" class="control-label">{{lang.register.location.title}}</label>
                        <input id="location" type="text" class="form-control" name="location"
                               :placeholder="lang.register.location.placeholder" v-model="form.location">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{lang.register.email}}</label>

                        <input id="email" type="email"
                               :class="{'form-control': true, 'is-invalid': errors.has('email') }"
                               name="email" v-validate="'required|email'"
                               required :placeholder="lang.register.email">
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>

                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{lang.register.password}}
                            <small class="text-muted">(8 char. min)</small>
                        </label>
                        <input id="password" type="password"
                               :class="{'form-control': true, 'is-invalid': errors.has('password') }"
                               name="password" v-validate="'required|min:8'"
                               required :placeholder="lang.register.password">
                        <span v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password')
                            }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password-confirm"
                               class="control-label">{{lang.register.password_confirm}}</label>

                        <input id="password-confirm" type="password"
                               :class="{'form-control': true, 'is-invalid': errors.has('password_confirmation') }"
                               name="password_confirmation" v-validate="'required|confirmed:password|min:8'"
                               required :placeholder="lang.register.password">
                        <span v-if="errors.has('password_confirmation')"
                              class="invalid-feedback">{{ errors.first('password_confirmation') }}</span>

                    </div>

                    <!--TODO: Accept rules checkbox + Captcha -->

                    <button type="submit" class="btn btn-lastar-blue btn-block mt-4">
                        {{lang.register.title}}
                    </button>

                    <div class="btn-rack mt-4">
                        <button class="btn btn-facebook">
                            <i class="fa fa-facebook"></i> Facebook Connect
                        </button>
                        <button class="btn btn-outline-purple" @click.prevent="openLogin()">
                            {{lang.auth.title}}
                        </button>
                    </div>

                </form>
            </div>
        </transition>
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type=='password_reset'" class="content">
                <h1 class="text-primary">{{lang.reset.title}}</h1>

                <form role="form"
                      method="POST"
                      :action="routes.reset_for_email"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <input type="hidden" name="token" value="token">


                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{lang.auth.email}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')"
                               name="email"
                               required v-validate="'required|email'"
                               :placeholder="lang.auth.email"
                        >
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="form-group mt-4">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-lastar-blue btn-block">
                                {{lang.reset.submit}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="btn-rack mt-4">
                    <button class="btn btn-outline-purple" @click.prevent="openRegister()">
                        {{lang.register.title}}
                    </button>
                    <button class="btn btn-outline-purple" @click.prevent="openLogin()">
                        {{lang.auth.title}}
                    </button>
                </div>
            </div>

        </transition>
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type=='change_password'" class="content">
                <h1 class="text-primary">{{lang.new_password.title}}</h1>

                <form role="form"
                      method="POST"
                      :action="routes.reset_password"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <input type="hidden" name="token" :value="token">

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{lang.auth.email}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')"
                               name="email"
                               required v-validate="'required|email'"
                               :placeholder="lang.auth.email"
                        >
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{lang.register.password}}
                            <small class="text-muted">(8 char. min)</small>
                        </label>
                        <input id="password" type="password"
                               :class="{'form-control': true, 'is-invalid': errors.has('password') }"
                               name="password" v-validate="'required|min:8'"
                               required :placeholder="lang.register.password">
                        <span v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password')
                            }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password-confirm"
                               class="control-label">{{lang.register.password_confirm}}</label>

                        <input id="password-confirm" type="password"
                               :class="{'form-control': true, 'is-invalid': errors.has('password_confirmation') }"
                               name="password_confirmation" v-validate="'required|confirmed:password|min:8'"
                               required :placeholder="lang.register.password">
                        <span v-if="errors.has('password_confirmation')"
                              class="invalid-feedback">{{ errors.first('password_confirmation') }}</span>

                    </div>

                    <div class="form-group mt-4">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-lastar-blue btn-block">
                                {{lang.new_password.submit}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="btn-rack mt-4">
                    <button class="btn btn-outline-purple" @click.prevent="openRegister()">
                        {{lang.register.title}}
                    </button>
                    <button class="btn btn-outline-purple" @click.prevent="openLogin()">
                        {{lang.auth.title}}
                    </button>
                </div>
            </div>

        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            token: {required:false},
            authType: {type: String, required: true},
            csrf: {type: String, required: true},
            lang: {type: Object, required: true},
            routes: {type: Object, required: true},
            old: {type: Object, required: false, default: () => {}},
            backErrors: {type: Array, required: false, default: () => []}
        },
        data() {
            return {
                type: this.authType,
                customErrors: this.backErrors,
                form: { gender: 1,
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

                this.type = 'password_reset';
            },
            openRegister() {
                // Clear errors
                this.errors.clear();
                this.customErrors = [];

                this.type = 'register';
            },
            openLogin() {
                // Scroll to top for smoother animation
                this.scrollToTop(100);

                // Clear errors
                this.errors.clear();
                this.customErrors = [];

                this.type = 'login';
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

        }
    }
</script>
