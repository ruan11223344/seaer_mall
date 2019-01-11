<template>
    <router-link to="/goods/details/123">
    <!-- <div> -->
        <v-img width="228" height="228" :img-src="imgSrc"></v-img>
        <article class="content">
            <div :title="title" class="title">{{ title }}</div>
            <div class="price">KSh {{ price }}</div>
        </article>
    <!-- </div> -->
    </router-link>
</template>

<script>
    import imgTemplateVue from '../Img/index';

    export default {
        props: {
            title: {
                type: String
            },
            price: {
                required: true
            },
            imgSrc: {
                type: String
            }
        },
        components: {
            'v-img': imgTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');
    .content {
        .flex(space-around, center, column);
        .bg-color(white);
        .width(228px, 91px);
    }

    .title  {
        .color(black);
        .textHiddens(2);
        width: 228px - 20px - 20px;
        // height: 32.8px;
        padding: 0px 20px;
        text-align: center;
    }

    .price {
        .color(red2)
    }
</style>
