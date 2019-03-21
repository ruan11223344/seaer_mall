<template>
    <div class="footer">
        <div class="container">
            <nav class="footer-nav">
                <dl style="marginRight:81px">
                    <dt>About us</dt>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=About Afriby.com'">About  Afriby.com</a>
                    </dd>
                </dl>
                <dl style="marginRight:96px">
                    <dt>Help Center</dt>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=Finding And Contacting'">{{'Finding & Contacting'}}</a>
                    </dd>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=Novice Guide'">Novice Guide</a>
                    </dd>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/reset/find'">Forget the Password</a>
                    </dd>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=Register As a Merchant'">Register As a Merchant</a>
                    </dd>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=Online Contact Us'">Online Contact Us</a>
                    </dd>
                </dl>
                <dl style="marginRight:87px">
                    <dt>Terms And Conditions</dt>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=All Categories'">All Categories</a>
                    </dd>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=merchants'">Merchants Register Agreement</a>
                    </dd>
                    <dd>
                        <a  class="hover" target="_blank" :href="origin + '/notice?key=buyers'">Buyers Register Agreement</a>
                    </dd>
                </dl>
                <dl style="marginRight:97px">
                    <dt>Follow Us</dt>
                    <dd class="box">
                        <div class="facebook">
                            <a href="https://www.facebook.com/" target="_blank">
                                <img :src="require('@/assets/img/home/facebook.png')" alt="">
                            </a>
                        </div>
                        <div class="tx">
                            <a href="https://twitter.com/login?lang=en" target="_blank">
                                <img :src="require('@/assets/img/home/tx.png')" alt="">
                            </a>
                        </div>
                    </dd>
                    <dd>
                        <div class="yt">
                            <a href="https://www.youtube.com/" target="_blank">
                                <img :src="require('@/assets/img/home/yt.png')" alt="">
                            </a>
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
        data() {
            return {
                origin: null
            }
        },
        created() {
            this.origin = window.location.origin
        },
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
                    padding-top: 11px;

                    & > a {
                        .color(blackDark);
                        font-size: 16px;
                        letter-spacing: 0px;
                    }
                }

                dd > a.hover:hover {
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
                    top: -3px;
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
