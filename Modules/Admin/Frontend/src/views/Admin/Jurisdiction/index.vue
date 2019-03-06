<template>
    <div id="jurisdiction">
        <el-form :model="formLabelAlign">
            <el-form-item>
                <span slot="label">权限组</span>
                <el-input v-model="formLabelAlign.name" style="width: 100%; max-width: 560px;"></el-input>
            </el-form-item>
            <el-form-item>
                <span slot="label">权限组</span>
                <el-checkbox v-model="checked">所有权限</el-checkbox>
                <span>(勾选后选中全部操作功能，可根据需要从设置详情中进行分组设置)</span>
            </el-form-item>
        </el-form>

        <div class="hr"></div>

        <div class="title">权限操作设置详情</div>

        <div class="block">
            <el-checkbox v-model="checked">平台模块功能</el-checkbox>
        </div>
        <section class="group">
            <template>
                <el-checkbox-group 
                    v-model="checkedCities1"
                    >
                    <el-checkbox
                        v-for="city in cities"
                        :label="city"
                        :key="city" 
                        class="group-checkbox"
                        >{{city}}
                    </el-checkbox>
                </el-checkbox-group>
            </template>
        </section>

        <div class="block" style="margin-top: 35px;">
            <el-checkbox v-model="checked">商城模块功能</el-checkbox>
        </div>
        <section class="group">
            <template>
                <el-checkbox-group 
                    v-model="checkedCities1"
                    >
                    <el-checkbox
                        v-for="city in cities"
                        :label="city"
                        :key="city" 
                        class="group-checkbox"
                        >{{city}}
                    </el-checkbox>
                </el-checkbox-group>
            </template>
        </section>

        <el-button type="primary" class="sub">保存</el-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formLabelAlign: {
                    name: '',
                    region: '',
                    type: ''
                },
                checked: false,
                checkedCities1: [],
                cities: ['设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作', '设置操作']
            }
        },
    }
</script>

<style lang="scss" scoped>
    #jurisdiction {
        margin-top: 50px;

        .hr {
            width: 100%;
            height: 1px;
            margin: 40px auto;
            background-color: #eeeeee;
        }

        .title {
            font-size: 18px;
            @include mixin-color(grey);
        }

        .block {
            width: 100%;
            height: 47px;
            margin-top: 16px;
            padding-left: 23px;
            box-sizing: border-box;
            @include mixin-flex(flex-start, center);
            @include mixin-bg-color(lead);
        }

        .group {
            padding-left: 23px;

            &-checkbox {
                margin-top: 35px;
            }
        }

        .sub {
            width: 107px;
            margin: 0px auto;
            margin-top: 50px;
            display: block;
        }
    }
</style>