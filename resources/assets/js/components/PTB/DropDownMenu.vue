<template>

    <div class="sandwich-menu">
        <el-dropdown trigger="click" @command="handleCommand">
            <i class="fa fa-bars" aria-hidden="true"></i>
            <el-dropdown-menu slot="dropdown" class="sandwich-menu-dropdown">
                <el-dropdown-item command="public.ticket.owned.page">
                    <i class="fa fa-ticket" aria-hidden="true"></i>
                    {{trans('nav.my_tickets')}}
                </el-dropdown-item>
                <el-dropdown-item command="public.message.home.page">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    {{trans('nav.messages')}}
                </el-dropdown-item>
                <el-dropdown-item command="public.profile.home">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    {{trans('nav.my_profile')}}
                </el-dropdown-item>
                <el-dropdown-item >
                    <i class="fa fa-cog" aria-hidden="true"></i>
                    {{trans('nav.settings')}}
                </el-dropdown-item>
                <el-dropdown-item command="logout">
                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                    {{trans('nav.logout')}}
                </el-dropdown-item>
            </el-dropdown-menu>
        </el-dropdown>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                opened: false
            }
        },
        methods: {
            handleCommand(command) {
                window.location.href = this.route(command);
            }
        }
    }
</script>