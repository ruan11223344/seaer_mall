<template>
    <div class="banner" v-if="active">
        <img :src="imgSrc" alt="" class="img">
        <div class="container">
            <div @click="active = false">X</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                active: true
            }
        },
        props: {
            imgSrc: {
                type: String,
                required: true
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .banner {
        .layout(80px);

        .img {
            .layout(80px);
            display: block;
        }

        .container {
            & > div {
                .width(20px;20px);
                .color(white);
                line-height: 20px;
                text-align: center;
                background-color: rgba(0, 0, 0, 0.3);
                border-radius: 1.2px;
                position: absolute;
                top: -80px;
                right: 0px;
                cursor: pointer;
            }
        }
    }
</style>

