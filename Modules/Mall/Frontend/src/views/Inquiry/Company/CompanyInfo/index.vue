<template>
    <div class="companyinfo">
        <v-title title="Company Info"></v-title>

        <template v-if="formData != null">
            <!-- 基本信息 -->
            <section class="companyinfo-block">
                <div class="companyinfo-block-title">Basic Info</div>
                <article class="companyinfo-block-article">
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Business Type:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.business_type || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Company Name:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.company_name || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Company Name In China:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.company_name_in_china || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Country:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.country_name || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Province/City:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info["province/city"] || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Address:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.address || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Telephone:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.telephone || '——' }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Website:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.basic_info.website || '——' }}</span>
                    </div>
                </article>
            </section>
            
            <!-- 业务信息 -->
            <section class="companyinfo-block">
                <div class="companyinfo-block-title">Business Info</div>
                <article class="companyinfo-block-article">
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Business Range:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.business_info.business_range }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Main Products:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.business_info.main_products }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Company Profile: </label>
                        <span class="companyinfo-block-article-list-text">{{ formData.business_info.company_profile }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Business License:</label>
                        <span class="companyinfo-block-article-list-text">{{ formData.business_info.business_license }}</span>
                    </div>
                    <div class="companyinfo-block-article-list">
                        <label for="" class="companyinfo-block-article-list-label">Attachment:</label>
                        <img style="width: 197px; height: 197px; display: inline-block;" :src="formData.business_info.business_license_url" />
                    </div>
                </article>
            </section>

            <button type="button" class="companyinfo-btn" @click="onEdit" v-if="!status">Edit</button>
        </template>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import getData from "@/utils/getData.js"
    import auth from "@/utils/auth"

    export default {
        data() {
            return {
                formData: null
            }
        },
        methods: {
            getSessionStorage: auth.getSessionStorage,
            onGetCompanyInfo: getData.onGetCompanyInfo,
            onEdit() {
                // const formData = JSON.stringify(this.formData)
                // this.$router.push('/inquiryList/company/companyedit?formData=' + formData)
                this.$router.push('/inquiryList/company/companyedit')
            }
        },
        created() {
            this.onGetCompanyInfo().then(res => {
                this.formData = res
            })
        },
        mounted() {
            const user = this.getSessionStorage()
            this.status = user.publish_product.status
        },
        components: {
            "v-title": Title,
            "v-img": Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .companyinfo {
        align-self: flex-start;
        width: 944px;
        height: auto;
        background-color: #ffffff;
        padding: 21px 30px;

        &-block {

            &-title {
                margin-top: 19px;
                margin-bottom: 15px;
                font-size: 18px;
                line-height: 1;
                color: #333333;
            }

            &-article {
                width: 100%;
                height: auto;
                background-color: #f5f5f9;
                padding: 15px 23px;

                &-list {
                    // .flex();
                    line-height: 1.5;
                    font-size: 16px;
                    margin: 10px 0px;

                    &-label {
                        width: 22%;
                        color: #333333;
                        margin-right: 1%;
                        text-align: right;
                        vertical-align: top;
                        display: inline-block;
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
