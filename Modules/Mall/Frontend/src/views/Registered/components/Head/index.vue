<template>
    <div class="Registered-one-steps">
        <v-img width="801" height="56" :imgSrc="img"></v-img>
    </div>
</template>

<script>
    import Img from "@/components/Img"

    export default {
        props: {
            img: ''
        },
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index');

    .Registered-one-steps {
        width: 100%;
        height: 90px;
        .flex(center, center);
    }
</style>
