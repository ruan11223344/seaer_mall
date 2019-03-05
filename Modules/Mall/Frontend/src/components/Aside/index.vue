<template>
    <div class="aside">
        <nav class="aside-item">
            <router-link
                to="/inquiryList/personalpenter"
                tag="div"
                class="aside-item-list"
                >
                <img
                    @mouseenter="imgItem1.state = imgItem1.active"
                    @mouseleave="imgItem1.state = imgItem1.default"
                    :src="imgItem1.state" alt="">
            </router-link>

            <div class="aside-item-list-hr"></div>

            <router-link
                to="/inquiryList/inbox"
                tag="div"
                class="aside-item-list"
                >
                <img
                    @mouseenter="imgItem2.state = imgItem2.active"
                    @mouseleave="imgItem2.state = imgItem2.default"
                    :src="imgItem2.state" alt="">
            </router-link>

            <div class="aside-item-list-hr"></div>

            <router-link
                tag="div"
                to="/inquiryList/collection"
                class="aside-item-list"
                >
                <img
                    @mouseenter="imgItem3.state = imgItem3.active"
                    @mouseleave="imgItem3.state = imgItem3.default"
                    :src="imgItem3.state" alt="">
            </router-link>
            <div class="aside-item-list-hr"></div>

            <div
                class="aside-item-list"
                @click="onClcik"
                >
                <img
                    @mouseleave="imgItem4.state = imgItem4.default"
                    @mouseenter="imgItem4.state = imgItem4.active"
                    :src="imgItem4.state" alt="">
            </div>
        </nav>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                imgItem1 : {
                    default: require('@/assets/img/home/grzx.png'),
                    active: require('@/assets/img/home/grzx-active.png'),
                    state: require('@/assets/img/home/grzx.png')
                },
                imgItem2 : {
                    default: require('@/assets/img/home/youj.png'),
                    active: require('@/assets/img/home/youj-active.png'),
                    state: require('@/assets/img/home/youj.png')
                },
                imgItem3 : {
                    default: require('@/assets/img/home/sc.png'),
                    active: require('@/assets/img/home/sc-active.png'),
                    state: require('@/assets/img/home/sc.png')
                },
                imgItem4 : {
                    default: require('@/assets/img/home/top.png'),
                    active: require('@/assets/img/home/top-active.png'),
                    state: require('@/assets/img/home/top.png')
                }
            }
        },
        methods: {
            onClcik() {
                let oTop = document.body.scrollTop || document.documentElement.scrollTop

                const clear = setInterval(() => {
                    oTop = oTop - 100
                    
                    oTop = oTop > 0 ? oTop : 0

                    window.scrollTo(0, oTop)
                    
                    if(oTop <= 0) {
                        clearInterval(clear)
                    } 
                }, 20)
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .aside {
        .width(50px, 100%);
        .bg-color(white);
        position: fixed;
        top: 0px;
        right: 0px;
	    border: solid 1px #eeeeee;
        display: block;
        z-index: 10000;

        &-item {
            .flex(center, center, column);
            height: 100%;

            &-list {
                .flex(center, center);
                .width(100%, 64px);
                cursor: pointer;

                img {
                    .width(33px, 33px);
                    display: block;
                }
            }

            &-list:hover {
                .bg-color(whiteLight);
            }

            &-list-hr {
                .width(12px, 1px);
                background-color: #e3e3e3;
            }
        }   
    }
</style>
