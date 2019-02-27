<template>
    <div class="companyinfo">
        <v-title title="Company Info"></v-title>

        <!-- 基本信息 -->
        <section class="companyinfo-block">
            <div class="companyinfo-block-title">Basic Info</div>
            <article class="companyinfo-block-article">
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Business Type:</label>
                    <span class="companyinfo-block-article-list-text">Trading Company</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Company Name:</label>
                    <span class="companyinfo-block-article-list-text">Wuhan Sier International Co.,LTD.</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Company Name In China:</label>
                    <span class="companyinfo-block-article-list-text">武汉思迩电子商务有限公司</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Country:</label>
                    <span class="companyinfo-block-article-list-text">China</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Province/City:</label>
                    <span class="companyinfo-block-article-list-text">HuBei WuHan</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Address:</label>
                    <span class="companyinfo-block-article-list-text"> Room 605,Building A,No.777,Optical Valley three Road,East Lake High-tech Development Zone</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Telephone:</label>
                    <span class="companyinfo-block-article-list-text">+86 027-65520870</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Website:</label>
                    <span class="companyinfo-block-article-list-text">https://www.seaer.com.cn</span>
                </div>
            </article>
        </section>
        
        <!-- 业务信息 -->
        <section class="companyinfo-block">
            <div class="companyinfo-block-title">Business Info</div>
            <article class="companyinfo-block-article">
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Business Range:</label>
                    <span class="companyinfo-block-article-list-text"> Agriculture & Food</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Main Products:</label>
                    <span class="companyinfo-block-article-list-text">Garlic、Apple</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Company Profile: </label>
                    <span class="companyinfo-block-article-list-text">We have ten years of local sales experience in Africa.It engages in cross-border e-commerce business activities such as S2B, B2B, B2C, and O2O. Its business products cover building materials, furniture, household products, automobile and motorcycle accessories, clothing, shoes and bags, 3C, IT digital, home appliances, computers, electronic products, beauty wigs, cosmetics, mother and baby, handicrafts, daily necessities, toys, stationery, sporting goods, sports outdoor products, jewelry, electric vehicles and their accessories, to achieve "buy the world, sell the world" to provide buyers and sellers in different countries with a one-stop butler service.</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Business License:</label>
                    <span class="companyinfo-block-article-list-text">91420100MA4KXE9Q0A</span>
                </div>
                <div class="companyinfo-block-article-list">
                    <label for="" class="companyinfo-block-article-list-label">Attachment:</label>
                    <!-- <span class="companyinfo-block-article-list-text">https://www.seaer.com.cn</span> -->
                    <v-img width="197" height="197" imgSrc=""></v-img>
                </div>
            </article>
        </section>

        <button type="button" class="companyinfo-btn">Edit</button>
    </div>
</template>

<script>
    import Title from "../../components/Title"
    import Img from "@/components/Img"
    import getData from "@/utils/getData.js"

    export default {
        methods: {
            onGetCompanyInfo: getData.onGetCompanyInfo
        },
        mounted() {
            this.onGetCompanyInfo().then(res => {
                console.log(res);
                
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
