<template>
    <div class="box-cropper">
        <div class="box-cropper-block">
            <div class="box-cropper-block-cropper">
                <vue-cropper
                ref="cropper"
                :img="option.url"
                :outputSize="option.size"
                :outputType="option.outputType"
                :autoCrop="option.autoCrop"
                :autoCropWidth="option.autoCropWidth"
                :autoCropHeight="option.autoCropHeight"
                :info="option.info"
                :canScale="option.canScale"
                :fixedBox="option.fixedBox"
                :centerBox="option.centerBox"
                :canMoveBox="option.canMoveBox"
                :infoTrue="option.infoTrue"
                :mode="option.mode"
                @imgMoving="onImgMoving"
                @cropMoving="onCropMoving"
                ></vue-cropper>
            </div>

            <div class="box-cropper-block-btns">
                <button type="button" @click="onTailoring">Tailoring</button>
                <button type="button" @click="onClose">close</button>
                <button type="button" @click="onRotate">rotate</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { VueCropper }  from 'vue-cropper' 

    export default {
        data() {
            return {
                option: {
                    url: 'http://c.hiphotos.baidu.com/image/pic/item/34fae6cd7b899e518d7259df4fa7d933c9950d78.jpg',
                    size: 1,
                    outputType: 'png',
                    autoCrop: true,
                    autoCropWidth: 750,
                    autoCropHeight: 200,
                    info: true,
                    canScale: true,
                    fixedBox: true,
                    canMoveBox: true,
                    centerBox: true,
                    infoTrue: true,
                    mode: 'cover'
                },
            }
        },
        methods: {
            // 截图
            onTailoring() {
                this.$refs.cropper.startCrop()

                this.$refs.cropper.getCropData((data) => {
                    // do something
                    console.log(data);
                })
            },
            // 清除关闭
            onClose() {

            },
            // 旋转
            onRotate() {
                this.$refs.cropper.rotateRight()
            },
            onImgMoving(data) {
                // console.log(data);
            },
            onCropMoving(data) {
                // console.log(data);
            }
        },
        components: {
            VueCropper,
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../assets/css/index.less');

    .box-cropper {
        width: 100vw;
        height: 100vh;
        position: fixed;
        top: 0px;
        left: 0px;
        background-color: rgba(0, 0, 0, 0.1);
        .flex(center, center);

        &-block {
            background-color: #ffffff;
            padding: 20px;
            &-cropper {
                width: 1220px;
                height: 500px;
            }

            &-btns {
                text-align: center;
                margin-top: 20px;
                & > button {
                    padding: 0px 15px;
                    font-size: 18px;
                    font-weight: normal;
                    font-stretch: normal;
                    line-height: 37px;
                    letter-spacing: 0px;
                    color: #ffffff;
                    height: 40px;
                    background-color: #f0883a;
                    border: none;
                    margin-right: 10px;
                }
            }
        }
    }
</style>
