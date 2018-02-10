<template>
    <div class="nav-notifications">
        <i class="fa fa-bell text-neon" @click="toggleDropdown()" aria-hidden="true"></i>
        <span v-if="unreadCount>0" class="badge badge-pill badge-warning">{{unreadCount}}</span>
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
                        <p class="text-center">{{lang.no_new}}</p>
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
            routes: {type:Object,required:true},
            lang: {type:Object,required:true}
        },
        data() {
            return {
                state: 'default',
                dropdownOpened: false,
                fullyOpened: false,
                unreadCount: this.user.unread_notifications,
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
                this.$http.get(this.routes.api.notifications)
                    .then(response => {
                        this.state='default';
                        this.notifications = response.body;
                    })
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
        }
    }
</script>