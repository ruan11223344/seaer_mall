<template>
    <div class="banner" v-if="active == null">
        <a
            target="_blank"
            :href="data_obj.jump_url"
            :style="`display: block;background: url(${data_obj.image_url}) center center;height: 80px; cursor: pointer;`"
            >
        </a>
        <div class="container">
            <div @click="onClick">X</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                active: null
            }
        },
        props: {
            data_obj: Object
        },
        methods: {
            onClick() {
                sessionStorage.setItem('banner', true)
                this.active = sessionStorage.getItem('banner')
            }
        },
        created() {
            this.active = sessionStorage.getItem('banner')
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .banner {
        .layout(80px);

        // .img {
        //     .layout(80px);
        //     display: block;
        // }

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

