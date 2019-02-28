<template>
    <div class="container">
        <nav class="nav">
            <router-link v-if="true" tag="div" to="/login">Sign In</router-link>
            <div v-else>{{ '登录用户名' }}</div>
            <router-link tag="div" to="/registered/one">Join Free</router-link>
            <div class="Customer">
                <!-- 下拉 -->
                <div>
                    <span>Customer Service</span>
                    <Icon type="ios-arrow-down" style="marginLeft:2px;"/>
                </div>
                <ul>
                    <li>Help Center</li>
                    <li>Service</li>
                </ul>
            </div>
            <router-link tag="div" to="/inquiryList/inbox">Inquiry</router-link>
        </nav>
    </div>
</template>

<script>
    import getData from "@/utils/getData"

    export default {
        methods: {
            onGetUser: getData.onGetUser
        },
        mounted() {
            // this.onGetUser().then(res => {
            //     console.log(res);
                
            // }).catch(err => {
            //     console.log(err);
            // })
        },
    }
</script>

<style lang="less" scoped>
    @import url("../../assets/css/index.less");
    
    .nav {
        .flex(flex-end, center);
        .lineHeight(40px);
        .color(white);
        
        & > div {
            height: 40px;
            margin-left: 25px;
            cursor: pointer;
        }

        & > .Customer {
            position: relative;

            & > ul:last-child {
                .bg-color(white);
                .width(143px, 0px);
                position: absolute;
                top: 35px;
                z-index: 10000;
                overflow: hidden;
                transition: all .2s;
                
                & > li {
                    .color(blackLight);
                    height: 30px;
                    padding-left: 15px;
                    font-size: 14px;
                    line-height: 30px;
                }

                & > li:hover {
                    .color(white);
                    .bg-color(Orange);
                }
            }

            & > div:first-child:hover + ul:last-child {
                height: 80px;
                border: solid 1px #dddddd;
                padding: 10px 0px;
            }

            ul:last-child:hover {
                height: 80px;
                border: solid 1px #dddddd;
                padding: 10px 0px;
            }
        }
    }
</style>
