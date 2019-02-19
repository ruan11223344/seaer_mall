<template>
    <!-- 联系方式 -->
    <div class="contact">
        <div class="container">
            <v-Breadcrumb title="Supplier Homepage" :Breadcrumbs="[ 'Coutact us' ]"></v-Breadcrumb>
        </div>
        
        <div class="contact-main">
            <div class="container">
                <div class="contact-main-title">Contact Details</div>
                <!-- 名片 -->
                <section class="contact-main-card">
                    <Row :gutter="20" class-name="contact-main-card-block">
                        <Col span="5" class-name="contact-main-card-left">
                            Company Name In China:
                        </Col>
                        <Col span="19" class-name="contact-main-card-right">
                            武汉思迩电子商务有限公司
                        </Col>
                    </Row>
                    <Row :gutter="20" class-name="contact-main-card-block">
                        <Col span="5" class-name="contact-main-card-left">
                            Country:
                        </Col>
                        <Col span="19" class-name="contact-main-card-right">
                            China
                        </Col>
                    </Row>
                    <Row :gutter="20" class-name="contact-main-card-block">
                        <Col span="5" class-name="contact-main-card-left">
                            Province/City:
                        </Col>
                        <Col span="19" class-name="contact-main-card-right">
                            HuBei WuHan
                        </Col>
                    </Row>
                    <Row :gutter="20" class-name="contact-main-card-block">
                        <Col span="5" class-name="contact-main-card-left">
                            Address:
                        </Col>
                        <Col span="19" class-name="contact-main-card-right">
                            Room 605,Building A,No.777,Optical Valley three Road,East Lake High-tech Development Zone
                        </Col>
                    </Row>
                    <Row :gutter="20" class-name="contact-main-card-block">
                        <Col span="5" class-name="contact-main-card-left">
                            Telephone:
                        </Col>
                        <Col span="19" class-name="contact-main-card-right">
                            +86 027-65520870
                        </Col>
                    </Row>
                    <Row :gutter="20" class-name="contact-main-card-block">
                        <Col span="5" class-name="contact-main-card-left">
                            Website:
                        </Col>
                        <Col span="19" class-name="contact-main-card-right">
                            https://www.seaer.com.cn
                        </Col>
                    </Row>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
    import Aside from '../components/Aside/index.vue'
    import Card from "@/components/Card"
    import Breadcrumb  from '@/components/Breadcrumb'

    export default {
        data() {
            return {
                // 商品列表
                goodsLists: [
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                    {
                        title: 'Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation Beidou GPS dual mode vehicle navigation',
                        price: "1.00",
                        imgSrc: require('@/assets/img/home/mr.png')
                    },
                ],
            }
        },
        components: {
            "v-aside": Aside,
            'v-card': Card,
            "v-Breadcrumb": Breadcrumb 
        }
    }
</script>

<style lang="less" scoped>
    @import url("../../../assets/css/index");

    .contact {
        padding-top: 18px;
        background-color: #f5f5f9;

        &-main {
            width: 100%;
            margin-top: 14px;
            padding-top: 26px;
            padding-bottom: 38px;
            .bg-color(white);

            &-title {
                font-size: 20px;
                color: #666666;
                line-height: 1;
                margin-bottom: 22px;
            }

            &-card {
                width: 100%;
                height: 261px;
                background-color: #f5f5f9;
                padding: 33px 0px;
                
                &-block {
                    margin-bottom: 20px;
                }

                &-left {
                    font-size: 16px;
                    font-weight: normal;
                    font-stretch: normal;
                    line-height: 1;
                    letter-spacing: 0px;
                    color: #333333;
                    text-align: right;
                }

                &-right {
                    font-size: 16px;
                    font-weight: normal;
                    line-height: 1;
                    letter-spacing: 0px;
                    color: #666666;
                }
            }
        }
    }
</style>
