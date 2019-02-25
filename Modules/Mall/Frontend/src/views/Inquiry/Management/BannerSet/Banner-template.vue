<template>
    <div class="BannerSetting">
        <div class="BannerSetting-title">Shop Banner:</div>
        <div class="BannerSetting-banner">
            <img :src="path" alt="">
        </div>
        <div class="BannerSetting-btns">
            <Upload
                action="//jsonplaceholder.typicode.com/posts/"
                style="display: inline-block;"
                :before-upload="onUpload"
                >
                <button type="button" class="BannerSetting-btns-up">Upload</button>
            </Upload>
            <button type="button" class="BannerSetting-btns-del" @click="onDel">Delete</button>
        </div>
        <div class="BannerSetting-text">- The banner should be 1920px width and 150px height in gif or png format.</div>
        <div class="BannerSetting-save">
            <button type="button" @click="onSave(path)">Save</button>
        </div>

        <v-cropper :url="url" :autoCropWidth="1920" :autoCropHeight="150" @on-cropper="onCropper" @on-show="onShow" v-show="show"></v-cropper>
    </div>
</template>

<script>
    // 裁剪
    import Cropper from "@/components/Cropper"
    import upData from "@/utils/upData.js"
    import getData from "@/utils/getData.js"

    export default {
        data() {
            return {
                url: '',
                show: false,
                path: ''
            }
        },
        methods: {
            onDelBanner: upData.onDelBanner,
            onSetBanner: upData.onSetBanner,
            getObjectURL: getData.getObjectURL,
            // 截图
            onCropper(data) {
                console.log(data);
                this.path = data
            },
            // 阻止默认上传
            async onUpload(file) {
                this.url = await this.getObjectURL(file)
                
                this.show = true
                return false
            },
            onShow(bool) {
                this.show = bool
            },
            // 删除banner
            onDel() {
                this.onDelBanner()
                this.path = ''
            },
            onSave(data) {
                if(data) {
                    this.onSetBanner(data)
                }else {
                    this.$Message.warning('Please upload the banner picture of the store')
                }
            }
        },
        components: {
            "v-cropper": Cropper
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .BannerSetting {
        width: 100%;
        height: 730px - 96px;
        // background-color: #cccccc;
        .flex(flex-start, center);
        flex-direction: column;

        & > div {
            width: 485px;
            line-height: 1;
        }

        &-title {
            font-size: 16px;
            color: #333333;
            margin-top: 92px;
        }

        &-banner {
            width: 485px;
            height: 103px;
            background-color: #f2f6f9;
            margin-top: 22px;

            & > img {
                width: 100%;
                height: 100%;
                display: block;
            }
        }

        &-btns {
            margin-top: 12px;

            &-up, &-del {
                width: 63px;
                height: 25px;
                background-color: #f0883a;
                border: none;
                font-size: 12px;
                color: #ffffff;
            }

            &-del {
                margin-left: 20px;
            }
        }

        &-text {
            margin-top: 18px;
            font-size: 14px;
            color: #999999;
        }

        &-save {
            margin-top: 75px;
            text-align: center;

            & > button {
                width: 90px;
                height: 34px;
                background-color: #f0883a;
                border: none;
                font-size: 18px;
                color: #ffffff;
            }
        }
    }
</style>
