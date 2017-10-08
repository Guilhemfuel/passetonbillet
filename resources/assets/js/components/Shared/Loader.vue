<template>
    <div :class="(className!='')?'spinner '+className:'spinner'">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</template>

<script>
    export default {
        props: {
            className: ''
        }
    }
</script>