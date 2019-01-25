<template>
    <div class="head">
        <v-img width="801" height="56" :imgSrc="imgSrc"></v-img>
    </div>
</template>

<script>
    import Img from "@/components/Img"

    export default {
        props: {
            imgSrc: ''
        },
        components: {
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .head {
        .flex(center, center);
        margin-bottom: 30px;
    }
</style>
