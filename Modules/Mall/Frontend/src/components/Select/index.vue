<template>
    <div>
        <div class="v-select" tabindex="0" @focus="onFocus" @blur="onBlur">
            <div class="v-select-block">
                <span class="v-select-title" :style="{ color: active != 'Select' ? '#333333' : '' }"> {{ active }}</span>
                <Icon type="ios-arrow-down" size="20" color="#999999"/>
            </div>
            <ul class="v-select-item" v-show="isBool">
                <li class="v-select-item-list" v-for="(item, index) in select" :key="index" @click="active=item.address">{{ item.address }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isBool: false,
                active: 'Select'
            }
        },
        props: {
            select: {
                default: [
                    {
                        address: ''
                    }
                ]
            }
        },
        methods: {
            onFocus() {
                this.isBool = true
            },
            onBlur() {
                this.isBool = false
            }
        },
    }
</script>

<style lang="less" scoped>
    .v-select {
        width: 271px;
        height: 52px;
        position: relative;
        z-index: 100;
        outline: none;

        &-block {
            height: 52px;
            line-height: 52px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 16px;
            border: solid 2px #eeeeee;
            cursor: pointer;
            transition: all .2s ease-in-out;
        }

        &-title {
            font-size: 16px;
            color: #999999;
        }

        &-item {
            width: 271px;
            height: auto;
            position: absolute;
            left: 0px;
            top: 62px;
            background-color: #ffffff;
            box-shadow: 0 1px 6px rgba(0,0,0,.2);
            text-align: center;
            padding: 5px 0px;

            &-list {
                cursor: pointer;
                line-height: 2;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                transition: all .2s ease-in-out;
            }
            &-list:hover {
                background-color: #f3f3f3;
            }
        }
    }

    .v-select:focus {
        .v-select-block {
            border-color: #57a3f3 !important;
        }
    }
</style>
