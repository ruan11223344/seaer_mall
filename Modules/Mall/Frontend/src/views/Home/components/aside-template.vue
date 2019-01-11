<template>
    <div class="aside">
        <nav class="aside-item">
            <div class="aside-item-list" @mouseenter="imgItem1.state = imgItem1.active" @mouseleave="imgItem1.state = imgItem1.default">
                <img :src="imgItem1.state" alt="">
            </div>
            <div class="aside-item-list-hr"></div>
            <div class="aside-item-list" @mouseenter="imgItem2.state = imgItem2.active" @mouseleave="imgItem2.state = imgItem2.default">
                <img :src="imgItem2.state" alt="">
            </div>
            <div class="aside-item-list-hr"></div>
            <div class="aside-item-list" @mouseenter="imgItem3.state = imgItem3.active" @mouseleave="imgItem3.state = imgItem3.default">
                <img :src="imgItem3.state" alt="">
            </div>
            <div class="aside-item-list-hr"></div>
            <div class="aside-item-list" @mouseenter="imgItem4.state = imgItem4.active" @mouseleave="imgItem4.state = imgItem4.default">
                <img :src="imgItem4.state" alt="">
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
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .aside {
        .bg-color(white);
        position: fixed;
        top: 0px;
        right: 0px;
        width: 50px;
        height: 100%;
	    border: solid 1px #eeeeee;
        display: block;

        &-item {
            height: 100%;
            display: flex;
            .flex(center, center, column);

            &-list {
                width: 100%;
                height: 64px;
                // margin-bottom: 31px;
                cursor: pointer;
                .flex(center, center);

                img {
                    .width(33px, 33px);
                    display: block;
                }
            }

            &-list:hover {
                .bg-color(whiteLight);
            }

            &-list-hr {
                width: 12px;
                height: 1px;
                background-color: #e3e3e3;
            }
        }
    }
</style>
