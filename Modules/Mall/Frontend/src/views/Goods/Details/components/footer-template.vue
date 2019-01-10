<template>
    <div class="main-footer">
        <h1 class="main-footer-title">Product Description</h1>
        <div>
            <img src="" alt="">
        </div>
        <article class="main-footer-article">
            <h1>Seller’s Information</h1>
            <ol type="1" start="1">
                <li v-for="(item, index) in dataArticle" :key="index">
                    {{ (index + 1) + ('.' + item) }}
                </li>
            </ol>
        </article>
        <div>
            <img src="" alt="">
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                dataArticle: [
                    'Since 1998,with over 17 years exporting electronics &consumer electronic experience.',
                    'Expert in OEM&ODM order. Professional R&D department,provide one-stop service for customers from original design/idea to finished products.',
                    'Since 2002,we participate in Canton fair & HK global sources fair. ',
                    'Own design team,can help you custom your packaging.',
                    'Advanced production equipment &professional QC to esure 0% defective rate of the goods.  Every batch of goods are inspected strictly to make sure the goods our customer received are qualified.'
                ]
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .main-footer {
        width: 100%;

        &-title {
            .lineHeight(37px);
            .color(blackDark);
            font-size: 18px;
            font-weight: normal;
            font-stretch: normal;
            letter-spacing: 0px;
            font-weight: bold;
        }

        &-title + div {
            .bg-color(whiteDark);
            width: 100%;
            height: 1186px;

            & > img {
                width: 100%;
                display: block;
            }
        }

        &-article {

            & > h1 {
                .color(blackDark);
                font-size: 18px;
                line-height: 37px;
                letter-spacing: 0px;
                margin-top: 10px;
                margin-bottom: 10px;
                font-weight: bold;
            }

            & > ol {
                & > li {
                    .color(blackLight);
                    width: 920px;
                    font-size: 14px;
                    line-height: 16px;
                    letter-spacing: 0px;
                    margin-bottom: 12px;
                    word-wrap:break-word;
                }
            }
        }

        &-article + div {
            .bg-color(whiteDark);
            width: 100%;
            height: 607px;
        }
    }
</style>
