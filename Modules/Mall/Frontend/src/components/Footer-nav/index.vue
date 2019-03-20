<template>
    <div class="footer">
        <div class="container">
            <nav class="footer-nav">
                <dl style="marginRight:81px">
                    <dt>About us</dt>
                    <dd>About  Afriby.com</dd>
                </dl>
                <dl style="marginRight:96px">
                    <dt>Help Center</dt>
                    <dd>{{'Finding & Contacting'}}</dd>
                    <dd>Novice Guide</dd>
                    <router-link class="hover" tag="dd" to="/reset/find">Forget the Password</router-link>
                    <!-- <dd>Register As a Merchant</dd> -->
                    <dd>Online Contact Us</dd>
                </dl>
                <dl style="marginRight:87px">
                    <dt>Terms And Conditions</dt>
                    <dd>All Categories</dd>
                    <router-link class="hover" tag="dd" to="/notice?key=merchants">Merchants Register Agreement</router-link>
                    <dd>Buyers Register Agreement</dd>
                </dl>
                <dl style="marginRight:97px">
                    <dt>Follow Us</dt>
                    <dd class="box">
                        <div class="facebook">
                            <img :src="require('@/assets/img/home/facebook.png')" alt="">
                        </div>
                        <div class="tx">
                            <img :src="require('@/assets/img/home/tx.png')" alt="">
                        </div>
                    </dd>
                    <dd>
                        <div class="yt">
                            <img :src="require('@/assets/img/home/yt.png')" alt="">
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dt>Contact Us</dt>
                    <dd>
                        <div class="phone">
                            <div>
                                <img :src="require('@/assets/img/home/dianh.png')" alt="">
                            </div>
                            <p style="color: #333333">00254（0）707872454</p>
                            <p style="fontSize:12px;color:#666666">08:00-19:00(Monday to Saturday)</p>
                        </div>
                    </dd>
                    <dd>
                        <div class="email">
                            <div>
                                <img :src="require('@/assets/img/home/youx.png')" alt="">
                            </div>
                            <p style="color: #333333">customerservice@afriby.com</p>
                            <p style="fontSize:12px;color:#666666">online service</p>
                        </div>
                    </dd>
                </dl>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="less" scoped>
    @import url("../../assets/css/index.less");

    .footer {
        .bg-color(white);
        min-width: 1220px;
        height: 246px;
        padding-top: 30px;
        border-top: 1px solid #dddddd;
        .footer-nav {
            .flex();

            & > dl {
                width: auto;

                & > dt {
                    .color(blackDark);
                    font-size: 20px;
                    font-weight: bold;
                    padding-bottom: 5px;
                }

                & > dd {
                    .color(blackDark);
                    font-size: 16px;
                    padding-top: 11px;
                    letter-spacing: 0px;
                }

                dd.hover:hover {
                    .color(Orange);
                    cursor: pointer;
                }
            }
            .box {
                .flex();

                .facebook, .tx {
                    position: relative;
                    cursor: pointer;
                }

                .facebook {
                    top: -18px;
                    left: -6px;
                }

                .tx {
                    top: 3px;
                }
            }

            .yt {
                position: relative;
                top: -25px;
                left: -6px;
                cursor: pointer;
            }
            .phone {
                position: relative;

                & > div:first-of-type {
                    position: absolute;
                    top: 5px;
                    left: -46px;
                }
            }
            .email {
                position: relative;

                & > div:first-of-type {
                    position: absolute;
                    top: 11px;
                    left: -46px;
                }
            }

        }
    }
    
</style>
