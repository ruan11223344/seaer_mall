<template>
    <div class="examine">
        <v-head :imgSrc="require('@/assets/img/login/bg3.png')"></v-head>

        <section class="examine-main">
            <div>
                <v-img width="104" height="118" :imgSrc="require('@/assets/img/product.png')"></v-img>
            </div>
            <div class="examine-main-text">You have submitted the product successfully ！</div>
            <div>
                <button type="button" class="examine-main-btn" style="marginRight: 35px;">Add a new product</button>
                <button type="button" class="examine-main-btn">Manage all products</button>
            </div>
        </section>
    </div>
</template>

<script>
    import Img from "@/components/Img"
    import Head from "../components/Head"

    export default {
        components: {
            "v-img": Img,
            "v-head": Head,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .examine {
        width: 944px;
        height: 772px;
        background-color: #ffffff;
        padding: 21px 30px;

        &-main {
            .flex(center, center);
            height: 772px - 86px - 42px;
            flex-direction: column;

            &-text {
                font-size: 20px;
                color: #666666;
                margin: 40px 0px;
            }

            &-btn {
                padding: 14px 15px;
                background-color: #f0883a;
                font-size: 16px;
                color: #ffffff;
                border: none;
            }
        }
    }
</style>
