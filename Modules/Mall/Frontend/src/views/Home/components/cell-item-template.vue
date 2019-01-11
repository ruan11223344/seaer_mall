<template>
    <div>
        <!-- 商品列表 -->
        <ul class="home-cell-item" @mouseleave="activeBool1=false">
            <li :class="arr[0] == index ? 'home-cell-item-list home-cell-item-list-hover' : 'home-cell-item-list'" v-for="(item, index) in dataContent" :key="index" :style="{'color': color}" @mouseenter="activeChildren = item.children,activeBool1=true,onOver(index)">
                <span>{{ item.title }}</span>
                <Icon type="ios-arrow-forward" size="18" class="home-cell-item-list-icon" />
            </li>
        </ul>
        <!-- 二级列表 -->
        <div class="home-cascaded" v-show="activeBool1 || activeBool2" @mouseleave="activeBool1=false,activeBool2=false" @mouseenter="activeBool1=true">
            <ul class="home-cell-item">
                <li :class="arr[1] == index ? 'home-cell-item-lists home-cell-item-lists-hover' : 'home-cell-item-lists'"  v-for="(item, index) in activeChildren" :key="index" @mouseenter="activeBool2=true,activeChildren1= item.children,onOver2(index)">
                    <span>{{ item.title }}</span>
                    <Icon type="ios-arrow-forward" size="18" class="home-cell-item-list-icon" />
                </li>
            </ul>
        </div>
        <!-- 三级列表 -->
        <div class="home-cascaded-router" v-show="activeBool2" @mouseleave="activeBool1=false,activeBool2=false" @mouseenter="activeBool2=true">
            <ul class="home-cascaded-router-item">
                <li :class="arr[2] == index ? 'home-cascaded-router-item-list home-cascaded-router-item-list-hover' : 'home-cascaded-router-item-list'"  v-for="(item, index) in activeChildren1" :key="index" @mouseenter="onOver3(index)">
                    {{ item }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activeBool: true,
                activeChildren: '',
                activeBool1: false,
                activeChildren1: '',
                activeBool2: false,
                arr: []
            }
        },
        props: {
            dataContent: {
                type: Array,
                required: true
            },
            color: {
                default: '#ffffff'
            }
        },
        methods: {
            onOver(index) {
                if(this.arr.length > 1) {
                    this.arr = []
                }
                this.$set(this.arr, 0, index)
            },
            onOver2(index) {
                this.$set(this.arr, 1, index)
            },
            onOver3(index) {
                this.$set(this.arr, 2, index)
            }
        },
        watch: {
            activeBool1(index) {
                if(this.activeBool1 == false && this.activeBool2 == false) {
                    this.arr = []
                }
            },
            activeBool2(index) {
                if(this.activeBool1 == false && this.activeBool2 == false) {
                    this.arr = []
                }
            },
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .home-cell-item {

        &-list, &-lists {
            width: 251px;
            height: 32px;
            padding-left: 47px;
            .flex(space-between, center);
            cursor: pointer;
            transition: all .5s;

            & > span:first-child {
                display: block;
                overflow: hidden;
                text-overflow:ellipsis;
                white-space: nowrap;
            }
            &-icon {
                margin-right: 19px;
                position: relative;
                top: 1px;
            }
        }

        &-list-hover {
            .bg-color(Orange);
        }
        // &-list:hover {
        //     background-color: #f0883a;
        // }
        &-lists {
            .color(blackLight);
            padding-left: 29px;
        }
        &-lists-hover {
            .color(Orange);
        }
    }

    .home-cascaded {
        .bg-color(white);
        position: absolute;
        top: 0px;
        z-index: 1000;
        width: 251px;
        height: 440px;
        left: 251px;
        border: solid 1px #dddddd;
        border-left: 0px solid #dddddd;
    }

    .home-cascaded-router::-webkit-scrollbar {
        width: 5px;
        border-radius: 5px;
    }
    .home-cascaded-router::-moz-scrollbar {
        width: 5px;
        border-radius: 5px;
    }
    .home-cascaded-router {
        .bg-color(white);
        position: absolute;
        top: 0px;
        z-index: 1000;
        left: 251px * 2;
        width: 505.5px + 20px;
        height: 440px;
        border: solid 1px #dddddd;
        border-left: 0px solid #dddddd;
        overflow-y: scroll;

        &-item {
            padding: 10px 0px 10px 20px;
            width: 505.5px;
            height: 420px;

            &-list {
                .lineHeight(40px);
                width: (505.5px - 20px) / 3;
                text-align: left;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                float: left;
                cursor: pointer;
            }

            &-list-hover {
                .color(Orange);
            }
        }
    }
</style>
