<template>
    <!-- 联系方式 -->
    <div class="profile">
        <div class="container">
            <!-- <v-Breadcrumb
                title="Supplier Homepage"
                :Breadcrumbs="[ 'About us' ]"
                :url="`/company/home?&company_id=${$route.query.company_id}`"
                >
            </v-Breadcrumb> -->
            <!-- <Breadcrumb separator=">">
                <BreadcrumbItem to="/">Home</BreadcrumbItem>
                <BreadcrumbItem>About us</BreadcrumbItem>
            </Breadcrumb> -->
        </div>
        
        <div class="profile-main">
            <div class="container">
                <div class="profile-main-title">Company Profile</div>
                <!-- 名片 -->
                <article class="profile-main-article">
                    <img src="" alt="">
                    <p v-html="Company_Detail.business_info.company_profile"></p>
                </article>
            </div>
        </div>
    </div>
</template>

<script>
    import Aside from '../components/Aside/index.vue'
    import Card from "@/components/Card"
    import Breadcrumb  from '@/components/Breadcrumb'
    import { mapState, mapMutations } from "vuex"

    export default {
        data() {
            return {
                
            }
        },
        computed: {
            ...mapState([ 'User_Info', 'Company_Detail' ])
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
