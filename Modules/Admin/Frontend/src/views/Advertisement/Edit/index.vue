<template>
    <div id="bannerEdit" v-loading="FormData == null">
        <el-form ref="form" :model="FormData" label-width="120px">
            <el-form-item label="广告位名称">
                <el-input v-model="FormData.ad_name" style="width: 100%;maxWidth: 658px;"></el-input>
            </el-form-item>
            <el-form-item label="宽度">
                {{ FormData.width }}
            </el-form-item>
            <el-form-item label="高度">
                {{ FormData.height }}
            </el-form-item>
            <el-form-item label="广告位图片预览" v-loading="loadding">
                <img style="width: 660px; height: 82px;backgroundColor: #eeeeee;display: block;" :src="FormData.image_url" alt="">
            </el-form-item>
            <el-form-item label="图片上传">
                <el-upload
                    action=""
                    multiple
                    :limit="3"
                    :before-upload="onBeforeUpload"
                    >
                    <el-button size="" type="primary">点击上传</el-button>
                </el-upload>
            </el-form-item>
            <el-form-item label="URL 跳转">
                <el-input v-model="FormData.jump_url" style="width: 100%;maxWidth: 658px;"></el-input>
            </el-form-item>
            <el-form-item label="广告状态">
                <template>
                    <el-radio v-model="radio" :label="true">开启</el-radio>
                    <el-radio v-model="radio" :label="false">关闭</el-radio>
                </template>
                <div>可将广告关闭,将不会显示广告,开启则显示</div>
            </el-form-item>
        </el-form>

        <el-button type="primary" @click="onSubmit">确认提交</el-button>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                radio: true,
                FormData: null,
                loadding: false
            }
        },
        methods: {
            onBeforeUpload(file) {
                this.loadding = true
                this.$PutRequest.putUploadImg(file)
                    .then(({ path, url }) => {
                        this.$set(this.FormData, 'image_path', path)
                        this.$set(this.FormData, 'image_url', url)
                        this.loadding = false
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                        this.loadding = false
                    })

                return false
            },
            onSubmit() {
                this.$PutRequest.putEditAd({
                    "ad_id": this.FormData.ad_id,  //广告 id 必填
                    "ad_name": this.FormData.ad_name,  //广告名称 必填
                    "jump_url": this.FormData.jump_url,  //跳转地址 非必填
                    "image_path": this.FormData.image_path,  //图片oss路径 必填
                    "enabled": this.radio  //是否启用   必填
                })
                    .then(res => {
                        this.$router.go(-1)
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            }
        },
        created() {
            const obj = JSON.parse(this.$route.query.obj)
            this.FormData = obj
        },
    }
</script>

<style lang="scss" scoped>
    #bannerEdit {
        margin-top: 60px;
        @include mixin-flex(center, center, column);

        .tips {
            font-size: 14px;
            color: #999999;
        }
    }
</style>
