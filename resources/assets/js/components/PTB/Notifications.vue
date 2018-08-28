<template>
    <div class="nav-notifications">
        <i class="fa fa-bell" @click="toggleDropdown()" aria-hidden="true"></i>
        <span v-if="unreadCount>0" class="badge badge-pill badge-danger">{{unreadCount}}</span>
        <transition enter-active-class="animated fadeInDown"
                    leave-active-class="animated fadeOutUp"
                    v-on:afterEnter="transitionCallback">
            <div class="dropdown" v-show="dropdownOpened" v-click-outside="clickOutside">
                <div class="dropdown-body">
                    <div v-if="state=='searching'" class="item">
                        <loader class-name="spinner-sm mx-auto"></loader>
                    </div>
                    <div v-if="state!='searching'" v-for="notification in notifications" class="item item-notification">
                        <div class="icon">
                            <span :class="'fa fa-'+notification.icon"></span>
                        </div>
                        <div class="text">
                            <a :href="notification.link">
                                <p>{{notification.text}}</p>
                            </a>
                        </div>
                    </div>
                    <div v-if="state!='searching'&&notifications.length==0" class="item item-notification">
                        <p class="text-center">{{trans('notifications.no_new')}}</p>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            user: {type:Object,required:true},
            currentPage: {type:Object,required:true},
        },
        data() {
            return {
                state: 'default',
                dropdownOpened: false,
                fullyOpened: false,
                unreadCount: this.user.unread_notifications?this.user.unread_notifications:0,
                notifications: []
            }
        },
        computed: {},
        methods: {
            toggleDropdown() {
                if (this.fullyOpened == false && this.dropdownOpened == false) {
                    this.openDropdown()
                }
                if (this.fullyOpened && this.dropdownOpened) {
                   this.closeDropdown
                }
            },
            openDropdown() {
                // Clear previous notifications
                this.state = 'searching';
                this.notifications = [];

                this.dropdownOpened = true;
                this.fullyOpened = false;
                this.unreadCount = 0;
            },
            closeDropdown() {
                if (this.fullyOpened && this.dropdownOpened) {
                    this.state='default';
                    this.dropdownOpened = false;
                    this.fullyOpened = false;
                }
            },
            clickOutside() {
                this.closeDropdown()
            },
            transitionCallback() {
                if (this.dropdownOpened) this.fullyOpened = true;
                this.getNotifications();
            },
            getNotifications(){
                this.$http.get(route('api.notifications'))
                    .then(response => {
                        this.state='default';
                        this.notifications = response.body;
                    })
            },
            notify(notification, duration = 10000){

                let color = 'neon';
                if ('color' in notification){
                    color = notification.color;
                }

                this.$notify({
                    dangerouslyUseHTMLString: true,
                    message: '<span class="text-'+color+' mr-3 notification-icon d-flex align-items-center">' +
                        '<i class="fa fa-2x fa-' + notification.icon + '" aria-hidden=\"true\"></i>' +
                    '</span>' +
                    '<span class="notification-message pr-3">' +
                        notification.text +
                    '</span>',
                    onClick: function() {
                        window.location.href = notification.link;
                    },
                    duration: duration,
                    offset: 57,
                });
            }
        },
        directives: {
            'click-outside': {
                bind: function (el, binding, vNode) {
                    // Provided expression must evaluate to a function.
                    if (typeof binding.value !== 'function') {
                        const compName = vNode.context.name
                        let warn = `[Vue-click-outside:] provided expression '${binding.expression}' is not a function, but has to be`
                        if (compName) {
                            warn += `Found in component '${compName}'`
                        }

                        console.warn(warn)
                    }
                    // Define Handler and cache it on the element
                    const bubble = binding.modifiers.bubble
                    const handler = (e) => {
                        if (bubble || (!el.contains(e.target) && el !== e.target)) {
                            binding.value(e)
                        }
                    }
                    el.__vueClickOutside__ = handler

                    // add Event Listeners
                    document.addEventListener('click', handler)
                },

                unbind: function (el, binding) {
                    // Remove Event Listeners
                    document.removeEventListener('click', el.__vueClickOutside__)
                    el.__vueClickOutside__ = null

                }
            }
        },
        mounted() {
            Echo.private('App.User.' + this.user.id)
                .notification((notification) => {
                    let shouldNotify = true;

                    // Handle no notification cases
                    switch (notification.type){
                        case "App\\Notifications\\MessageNotification":
                            if (this.currentPage.name == 'public.message.discussion.page'){
                                if (this.currentPage.data.discussion_id == notification.discussion_id){
                                    // We don't notify new message on page
                                    shouldNotify = false;
                                }
                            }
                            break;
                    }

                    if (shouldNotify){
                        this.unreadCount = this.unreadCount + 1;
                        this.notify(notification);
                    }
                });
        }
    }
</script>