<template>
    <div class="accountInfo">
        <v-title title="Account Info"></v-title>

        <!-- 基本信息 -->
        <section class="accountInfo-block">
            <article class="accountInfo-block-article">
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Member ID:</label>
                    <span class="accountInfo-block-article-list-text">wjcharles</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Emali Address:</label>
                    <span class="accountInfo-block-article-list-text">wjcharles@163.com</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Contact Full Name:</label>
                    <span class="accountInfo-block-article-list-text">Mr. Charles Wang</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Mobilephone:</label>
                    <span class="accountInfo-block-article-list-text">+86 13476159398</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Country:</label>
                    <span class="accountInfo-block-article-list-text">China</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Province/City:</label>
                    <span class="accountInfo-block-article-list-text">HuBei WuHan</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Address:</label>
                    <span class="accountInfo-block-article-list-text">Room 605,Building A,No.777,Optical Valley three Road,East Lake High-tech Development Zone</span>
                </div>
            </article>
        </section>

        <button type="button" class="accountInfo-btn">Edit</button>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"

    export default {
        components: {
            "v-title": Title,
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .accountInfo {
        align-self: flex-start;
        width: 944px;
        height: 772px;
        background-color: #ffffff;
        padding: 21px 30px;

        &-block {

            &-article {
                width: 100%;
                height: auto;
                background-color: #f5f5f9;
                padding: 15px 23px;
                margin-top: 20px;

                &-list {
                    .flex();
                    line-height: 1.5;
                    font-size: 16px;
                    margin: 10px 0px;

                    &-label {
                        width: 22%;
                        color: #333333;
                        margin-right: 1%;
                        text-align: right;
                    }

                    &-text {
                        display: inline-block;
                        width: 77%;
                        color: #666666;
                    }
                }
            }
        }

        &-btn {
            display: block;
            margin: 35px auto 10px auto;
            border: none;
            width: 87px;
            height: 36px;
            font-size: 20px;
            color: #ffffff;
            background-color: #f0883a;
        }
    }
</style>
