
<template>
    <div style="display-block">
        <transition enter-class="pre-animated"
                    enter-active-class="animated fadeInUpBig"
                    leave-active-class="animated fadeOutDownBig">
            <div v-if="type=='login'"  class="content">
                <h1 class="text-primary mb-4">{{lang.auth.title}}</h1>
                <form role="form"
                      method="POST"
                      :action="routes.login"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{lang.auth.email}}</label>

                        <input id="email" type="email" :class="'form-control' + (errors.has('email')?' is-invalid':'')" name="email"
                               required autofocus v-validate="'required|email'">
                        <span v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</span>
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{lang.auth.password}}</label>

                        <input id="password" type="password" class="form-control" name="password"
                               required>
                    </div>
                    <a href="#" @click.prevent="openRegister()">{{lang.auth.not_registered_yet}}</a>

                    <!-- TODO: add remind me feature -->
                    <!--<div class="form-group">-->
                        <!--<div class="col-xs-12">-->
                            <!--<div class="checkbox">-->
                                <!--<label>-->
                                    <!--<input type="checkbox"-->
                                           <!--name="remember" {{ old('remember') ? 'checked' : '' }}>-->
                                    <!--@lang('auth.auth.remember_me')-->
                                <!--</label>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->

                    <div class="form-group mt-4">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-lastar btn-block">
                                {{lang.auth.title}}
                            </button>
                            <!--{{&#45;&#45;TODO: Password reset&#45;&#45;}}-->
                            <!--{{&#45;&#45;<a class="btn btn-link" href="{{ route('password.page') }}">&#45;&#45;}}-->
                            <!--{{&#45;&#45;Forgot Your Password?&#45;&#45;}}-->
                            <!--{{&#45;&#45;</a>&#45;&#45;}}-->
                        </div>
                    </div>
                </form>
                <div class="actions btn-rack mt-4">
                    <button class="btn btn-facebook">
                        <i class="fa fa-facebook"></i> Facebook Connect
                    </button>
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
                <form role="form"
                      method="POST"
                      :action="routes.register"
                      data-toggle="validator">

                    <input type="hidden" name="_token" :value="csrf">

                    <div class="col-xs-12 form-group">
                        <label for="first_name"
                               class="control-label">{{lang.register.first_name}}</label>

                        <input id="first_name" type="text" :class="{'form-control': true, 'is-invalid': errors.has('first_name') }"
                               name="first_name" required autofocus v-validate="'required'"
                               :placeholder="lang.register.first_name">
                        <span v-if="errors.has('first_name')" class="invalid-feedback">{{ errors.first('first_name') }}</span>

                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="last_name"
                               class="control-label">{{lang.register.last_name}}</label>

                        <input id="last_name" type="text" class="form-control" name="last_name"
                               required autofocus
                               :placeholder="lang.register.last_name">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="email" class="control-label">{{lang.register.email}}</label>

                        <input id="email" type="email" class="form-control" name="email"
                               required :placeholder="lang.register.email">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password" class="control-label">{{lang.register.password}}
                            <small class="text-muted">(8 char. min)</small></label>

                        <input id="password" type="password" class="form-control" name="password"
                               required :placeholder="lang.register.password">
                    </div>

                    <div class="col-xs-12 form-group">
                        <label for="password-confirm"
                               class="control-label">{{lang.register.password_confirm}}</label>

                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required :placeholder="lang.register.password">
                    </div>

                    <!--TODO: Accept rules checkbox + Captcha -->

                    <button type="submit" class="btn btn-lastar btn-block mt-4">
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
    </div>
</template>

<script>
    export default {
        props: {
            authType: {type:String,required:true},
            csrf: {type:String,required:true},
            lang: {type:Object,required:true},
            routes: {type:Object,required:true}
        },
        data() {
            return {
                type: this.authType,
            }
        },
        created() {

        },
        methods: {
            openRegister(){
                this.type = 'register';
            },
            openLogin(){
                this.type = 'login';
            }
        }
    }
</script>
