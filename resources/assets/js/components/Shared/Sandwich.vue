<template>
    <div :class="{'sandwich-menu':true,'opened':value}" @click="toggledSandwich()" >
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</template>

<script>
    export default {
        props: {
            value: {required:true}
        },
        methods: {
            toggledSandwich() {
                this.$emit('toggle');
            }
        }
    }
</script>