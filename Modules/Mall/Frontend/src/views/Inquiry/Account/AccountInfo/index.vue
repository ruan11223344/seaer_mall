<template>
    <div class="accountInfo">
        <v-title title="Account Info"></v-title>

        <!-- 基本信息 -->
        <section class="accountInfo-block">
            <article class="accountInfo-block-article">
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Member ID:</label>
                    <span class="accountInfo-block-article-list-text">{{ formData.member_id || '——'  }}</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Emali Address:</label>
                    <span class="accountInfo-block-article-list-text">{{ formData.email_address || '——'  }}</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Contact Full Name:</label>
                    <span class="accountInfo-block-article-list-text">{{ formData.contact_full_name || '——'  }}</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Mobilephone:</label>
                    <span class="accountInfo-block-article-list-text">
                        {{ formData.country != 'Kenya' ? '+86' : '+254' + '  ' + formData.mobile_phone || '——'  }}
                    </span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Country:</label>
                    <span class="accountInfo-block-article-list-text">{{ formData.country || '——'  }}</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Province/City:</label>
                    <span class="accountInfo-block-article-list-text">{{ formData["province/city"] || '——'  }}</span>
                </div>
                <div class="accountInfo-block-article-list">
                    <label for="" class="accountInfo-block-article-list-label">Address:</label>
                    <span class="accountInfo-block-article-list-text">{{ formData.address || '——'  }}</span>
                </div>
            </article>
        </section>

        <button type="button" class="accountInfo-btn" @click="onRouter">Edit</button>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import getData from "@/utils/getData.js"

    export default {
        data() {
            return {
                formData: {}
            }
        },
        methods: {
            onGetAccountInfo: getData.onGetAccountInfo,
            onRouter() {
                this.$router.push(`/inquiryList/account/accountedit?formData=${JSON.stringify(this.formData)}`)
            }
        },
        mounted() {
            this.onGetAccountInfo().then(res => {
                this.formData = res
            })
        },
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
                    line-height: 1.5;
                    font-size: 16px;
                    margin: 10px 0px;

                    &-label {
                        width: 22%;
                        color: #333333;
                        margin-right: 1%;
                        text-align: right;
                        display: inline-block;
                        vertical-align: top;
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
