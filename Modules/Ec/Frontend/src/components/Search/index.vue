<template>
    <div class="box">
        <router-link to="/home" tag="div">
            <img :src="require('@/assets/img/home/logo.png')" alt="">
        </router-link>
        <div>
            <div class="inputLeft">
                <div class="">{{ selectActive }} <Icon type="md-arrow-dropdown" size="26"/></div>
                <ul class="select">
                    <li v-for="(item, index) in selectText" :key="index" v-text="item" @click="selectActive = item"></li>
                </ul>
            </div>
            <div class="input">
                <input type="text">
                <span class="title" v-for="(item, index) in title" :key="index" v-text="item"></span>
            </div>
            <div class="search">
                Search
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selectText: [
                    'Products',
                    'Suppliers'
                ],
                selectActive: 'Products',
                title: [
                    'Plate',
                    'Plate',
                    'Plate',
                    'Plate'
                ]
            }
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index');

    .box {
        height: 100px;
        .flex(flex-start, center, row);

        & > div:first-child {
            margin-left: 10px;
            cursor: pointer;
        }

        & > div:last-child {
            .width(597px, 54px);
            .bg-color(light);
            margin-left: 187px;
            position: relative;
            
            & > .inputLeft > div:first-child {
                .lineHeight(54px);
                width: 127px;
                padding-left: 25px;
                cursor: pointer;
                border-right: 1px solid #dddddd;
            }
            .select {
                width: 127px;
                // .lineHeight(54px);
                height: 0px;
                position: absolute;
                top: 54px;
                left: 0px;
                z-index: 999;
                overflow: hidden;
                transition: height 1s;

                & > li {
                    .lineHeight(54px);
                    .bg-color(light);
                    width: 127px;
                    padding-left: 25px;
                    cursor: pointer;
                }
            }
            & > .inputLeft > div:first-child:hover + .select {
                height: auto;
            }

            .select:hover {
                height: auto;
            }
            
            .input {
                position: absolute;
                top: 0px;
                right: 114px;
                width: 597px - 114px - 128px;
                .lineHeight(54px);

                & > .title {
                    width: 45px;
                    .lineHeight(19px);
                    float: left;
                    position: relative;
                    z-index: 999;
                    text-align: center;
                    margin-top: 54px / 2 - 19px / 2;
                    margin-left: 10px;
                    background-color: #f1f1f1;
                    cursor: pointer;
                    transition: height 1s;
                    overflow: hidden;
                }

                & > input {
                    .lineHeight(54px);
                    .color(blackDark);
                    .bg-color(light);
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 100%;
                    border: none;
                    text-indent: 20px;
                }

                & > input:focus ~ .title {
                    height: 0px;
                }
            }

            .search {
                .lineHeight(54px);
                .color(blackDark);
                position: absolute;
                top: 0px;
                right: 0px;
                width: 114px;
                background-color: #dcdcdc;
                text-align: center;
                cursor: pointer;
            }
        }
    }
</style>
