<template>
    <!-- 联系方式 -->
    <div class="profile">
        <div class="container">
            <v-Breadcrumb title="Supplier Homepage" :Breadcrumbs="[ 'Coutact us' ]"></v-Breadcrumb>
        </div>
        
        <div class="profile-main">
            <div class="container">
                <div class="profile-main-title">Company Profile</div>
                <!-- 名片 -->
                <article class="profile-main-article">
                    <img src="" alt="">
                    <p>Advanced production equipment &professional QC to esure 0% defective rate of the goods.  Every batch of goods are inspected strictly to make sure the goods our customer received are qualified.Company ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany Profile</p>
                    <p>Advanced production equipment &professional QC to esure 0% defective rate of the goods.  Every batch of goods are inspected strictly to make sure the goods our customer received are qualified.Company ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany Profile</p>
                    <img src="" alt="">
                    <p>Advanced production equipment &professional QC to esure 0% defective rate of the goods.  Every batch of goods are inspected strictly to make sure the goods our customer received are qualified.Company ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany Profile</p>
                    <p>Advanced production equipment &professional QC to esure 0% defective rate of the goods.  Every batch of goods are inspected strictly to make sure the goods our customer received are qualified.Company ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany ProfileCompany Profile</p>
                </article>
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

    .profile {
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
            
            &-article {
                
                & img {
                    width: auto;
                    max-width: 1220px;
                    max-height: 533px;
                    background-color: #f5f5f9;
                    margin: 0px auto;
                }

                & p {
                    text-indent: 2em;
                    font-size: 16px;
                    line-height: 1.2;
                    color: #666666;
                }
            }
        }
    }
</style>
