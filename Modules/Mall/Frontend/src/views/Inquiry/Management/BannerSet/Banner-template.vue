<template>
    <div class="BannerSetting">
        <div class="BannerSetting-title">Shop Banner:</div>
        <LightBox :images="images" ref="lightbox" :showLightBox="false" :showThumbs="false" :showCaption="false">11</LightBox>
        <div class="BannerSetting-banner" :style="`background: url(${path}) center center`" @click="onClick">
            <!-- <img :src="path" alt=""> -->
        </div>
        <div class="BannerSetting-btns">
            
            <Upload
                action=""
                style="display: inline-block;"
                :before-upload="onUpload"
                :show-upload-list="false"
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
    import LightBox from 'vue-image-lightbox'
require('vue-image-lightbox/dist/vue-image-lightbox.min.css')

    export default {
        data() {
            return {
                url: '',
                show: false,
                path: '',
                images: [
                    {

                    }
                ],
                showBox: false
            }
        },
        methods: {
            onDelBanner: upData.onDelBanner,
            onSetBanner: upData.onSetBanner,
            getObjectURL: getData.getObjectURL,
            onGetBanner: getData.onGetBanner,
            // 截图
            onCropper(data) {
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
            },
            onClick() {
                this.$set(this.images[0], 'src', this.path)
                this.$refs.lightbox.showImage(0)
            }
        },
        mounted() {
            this.onGetBanner().then(res => {
                if(res.code == 200) {
                    this.path = res.data.banner_url
                }else {
                    this.$Message.warning("You haven't set up banner yet")
                }
            })
        },
        components: {
            "v-cropper": Cropper,
            LightBox
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
            cursor: pointer;
            // display: flex;
            // justify-content: flex-start;
            // align-items: flex-start;

            & > img {
                width: 100%;
                height: 100%;
                display: block;
                // transform: scale(0.25261, 0.6866) translateX(-2840px) translateY(-35px);
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
