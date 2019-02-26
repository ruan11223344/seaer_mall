<template>
    <div class="Send-main">
        <v-title title="Edit My Photo"></v-title>
        
        <section class="avatar">
            <img class="avatar-img" :src="path" alt="">

            <Upload
                action="//jsonplaceholder.typicode.com/posts/"
                :show-upload-list="false"
                :before-upload="onBefore"
                >
                <button type="button" class="avatar-btn">Upload Photo</button>
            </Upload>

            <article class="avatar-article">
                <p>- Please upload a photo that matches the gender, age and status details in your personal profile.</p>
                <p>- Use a photo that is appropriate for a business setting. </p>
                <p>- Group photos are not allowed.</p>
                <p>- Photos violating the rules stated in the Terms of User will be removed without notice.</p>
            </article>

            <div class="avatar-btns">
                <button type="button" class="avatar-btns-cancel" @click="path=''">Cancel</button>
                <button type="button" class="avatar-btns-save" @click="onSave(path)">Save</button>
            </div>
        </section>

        <v-cropper :url="url" :autoCropWidth="145" :autoCropHeight="145" @on-cropper="onCropper" @on-show="onShow" v-show="show"></v-cropper>
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"
    import Cropper from "@/components/Cropper"
    import upData from "@/utils/upData.js"
    import getData from "@/utils/getData.js"

    export default {
        data() {
            return {
                url: '',
                show: false,
                path: require('@/assets/img/login/avatar.png')
            }
        },
        methods: {
            getObjectURL: getData.getObjectURL,
            onGetAvatar: getData.onGetAvatar,
            UpAvatarBase64: upData.UpAvatarBase64,
             // 截图
            onCropper(data) {
                this.path = data
            },
            onShow(bool) {
                this.show = bool
            },
            onBefore(file) {

                this.url = this.getObjectURL(file)

                this.show = true

                return false
            },
            onSave(base64) {
                this.UpAvatarBase64(base64).then(res => {
                    this.path = res.avatar_img_url
                })
            }
        },
        mounted() {
            this.onGetAvatar().then(res => {
                this.path = res.avatar_url
            }).catch(err => {

            })
        },
        components: {
            "v-title": Title,
            "v-img": Img,
            "v-cropper": Cropper
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .Send-main {
        .width(945px, 772px);
        .bg-color(white);
        padding: 21px 30px;
    }

    .avatar {
        .flex(center, center, column);
        width: 100%;
        height: 772px - 42px - 29px;

        &-img {
            width: 145px;
            height: 145px;
            border: 1px solid #f5f5f5;
            display: block;
            border-radius: 50%;
        }

        &-btn {
            margin-top: 10px;
            border: none;
            width: 88px;
            height: 25px;
            font-size: 12px;
            color: #ffffff;
            background-color: #f0883a;
        }

        &-article {
            margin-top: 48px;
            font-size: 14px;
            font-weight: normal;
            font-stretch: normal;
            line-height: 1.4;
            letter-spacing: 0px;
            color: #999999;
        }

        &-btns {
            margin-top: 103px;

            &-cancel, &-save {
                border: none;
                width: 118px;
                height: 44px;
                font-size: 18px;
                color: #ffffff;
            }

            &-cancel {
                margin-right: 96px;
                background-color: #bfbfbf;
            }

            &-save {
	            background-color: #f0883a;
            }
        }
    }
</style>
