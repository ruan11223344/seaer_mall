<template>
    <router-link :to="`/goods/details?product_id=${data.product_id}&company_id=${data.company_id}`">
        <v-img width="228" height="228" :img-src="data.product_main_pic_url"></v-img>
        <article class="content">
            <Tooltip :content="data.product_name">
                <div class="title">
                    {{ data.product_name }}
                </div>
            </Tooltip>
            <div class="price">{{ data.product_price }}</div>
            <div class="Pieces">{{ data.product_moq }}</div>
        </article>
    </router-link>
</template>

<script>
    import imgTemplateVue from '../Img/index'

    export default {
        props: {
            data: {
                type: Object
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
        .width(228px, 112px);
    }

    .title  {
        .color(black);
        width: 208px;
        height: 38px;
        padding: 0px 20px;
        text-align: center;
        font-size: 16px;
        line-height: 1.2;
        margin-top: 10px;
        .textHiddens(2);
        overflow: hidden;
    }

    .price {
        .color(red2);
        font-size: 16px;
    }

    .Pieces {
        .color(gray);
        font-size: 12px;
        margin-bottom: 10px;
    }
</style>
