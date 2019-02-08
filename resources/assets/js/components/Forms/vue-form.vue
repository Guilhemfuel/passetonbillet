<template>
    <form ref="form" :method="method=='GET'?'GET':'POST'" :action="action" @submit.prevent="beforeSubmit">
        <input type="hidden" name="_token" :value="csrf" v-if="method != 'GET'">
        <input type="hidden" name="_method" :value="method" v-if="method!='GET'&&method!='POST'">
        <slot :pulse="pulse"></slot>
    </form>
</template>

<script>
    export default {
        props: {
            method: {required: false, type: String, default: 'POST'},
            action: {required: false, type: String},
            callback: {required: false, type: Function, default: null},
            submitAfterCallback: {required: false, type: Boolean, default: false},
        },
        data() {
            return {
                csrf: window.csrf,
                pulse: false
            }
        },
        mounted() {

        },
        methods: {
            beforeSubmit() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        if (this.callback != null) {
                            this.callback();

                            if (this.submitAfterCallback) {
                                this.$refs.form.submit();
                            }
                        } else {
                            this.$refs.form.submit();
                        }
                        return;
                    } else {
                        this.pulse = true;
                        setTimeout(() => {
                            this.pulse = false;
                        }, 1000);
                    }
                });
            }
        }
    }
</script>
