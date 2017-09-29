<template>
    <transition name="fade">
        <div class="alert show alert-dismissible" v-if="visible" :class="classAlert">
            <button type="button" class="close" @click="closeAlert">
                <span aria-hidden="true">&times;</span>
            </button>
            <span v-html="content"></span>
        </div>
    </transition>
</template>

<script>

    import _ from 'lodash';

    export default {
        mounted: function () {
            if (!this.important) {
                setTimeout(this.closeAlert, 5000);
            }
        },
        data() {
            return {
                visible: true
            }
        },
        props: {
            type: {type: String, required: true},
            content: {type: String, required: true},
            important: {type: Boolean, default: false},
        },
        methods: {
            closeAlert: function () {
                this.visible = false;
            }
        },
        computed: {
            classAlert: function () {
                var classToAdd = ' alert-' + this.type;
                return classToAdd;
            }
        }
    }

</script>