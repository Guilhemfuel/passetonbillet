<template>

    <!--<div class="sandwich-menu">-->
    <el-dropdown class="nav-item nav-logged-part" trigger="click" @command="handleCommand">
        <slot>

        </slot>
        <el-dropdown-menu slot="dropdown" class="sandwich-menu-dropdown">

            <!-- Menu For Connected user-->
            <template v-if="user">

                <el-dropdown-item command="public.ticket.bought.page">
                    <i class="fa fa-ticket" aria-hidden="true"></i>
                    {{trans('nav.my_tickets_bought')}}
                </el-dropdown-item>
                <el-dropdown-item command="public.ticket.sold.page">
                    <i class="fa fa-ticket" aria-hidden="true"></i>
                    {{trans('nav.my_tickets_sold')}}
                </el-dropdown-item>

                <el-dropdown-item command="public.alerts.page">
                    <i class="fa fa-bell" aria-hidden="true"></i>
                    {{trans('nav.my_alerts')}}
                </el-dropdown-item>

                <el-dropdown-item command="public.profile.home">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    {{trans('nav.my_profile')}}
                </el-dropdown-item>
                <el-dropdown-item command="help">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    {{trans('nav.help')}}
                </el-dropdown-item>
                <el-dropdown-item command="admin" v-if="user.admin">
                    <i class="fa fa-lock" aria-hidden="true"></i>
                    Admin
                </el-dropdown-item>

                <template v-if="locale=='fr'">
                    <el-dropdown-item command="en">
                        <span class="flag-icon flag-icon-gb"></span>
                        English
                    </el-dropdown-item>
                </template>
                <template v-else>
                    <el-dropdown-item command="fr">
                        <span class="flag-icon flag-icon-fr"></span>
                        Français
                    </el-dropdown-item>
                </template>


                <el-dropdown-item command="logout">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    {{trans('nav.logout')}}
                </el-dropdown-item>

            </template>

            <!-- Menu for guest user -->
            <template v-else>
                <el-dropdown-item command="register.page">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                    {{trans('nav.register')}}
                </el-dropdown-item>
                <el-dropdown-item command="login.page">
                    <i class="fa fa-sign-in" aria-hidden="true"></i>
                    {{trans('nav.login')}}
                </el-dropdown-item>
                <el-dropdown-item command="help">
                    <i class="fa fa-question-circle" aria-hidden="true"></i>
                    {{trans('nav.help')}}
                </el-dropdown-item>
                <template v-if="locale=='fr'">
                    <el-dropdown-item command="en">
                        <span class="flag-icon flag-icon-gb"></span>
                        English
                    </el-dropdown-item>
                </template>
                <template v-else>
                    <el-dropdown-item command="fr">
                        <span class="flag-icon flag-icon-fr"></span>
                        Français
                    </el-dropdown-item>
                </template>
            </template>
        </el-dropdown-menu>
    </el-dropdown>
    <!--</div>-->

</template>

<script>
    export default {
        data() {
            return {
                user: this.$root.user,
                opened: false,
                locale: window.locale
            }
        },
        methods: {
            handleCommand(command) {
                if (command == 'admin') {
                    window.location.href = this.route('home') +
                        String.fromCharCode(112, 29 * 4, 98, 97, 100, 109, 100 + 5, 110);
                    return;
                } else if (command == 'help') {
                    window.location.href = this.route('help.page');
                    return;
                } else if (command == 'fr') {
                    window.location.href = this.route('lang',['fr']);
                    return;
                } else if (command == 'en') {
                    window.location.href = this.route('lang',['en']);
                    return;
                }

                window.location.href = this.route(command);
            }
        }
    }
</script>