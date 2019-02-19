<template>
    <div class="BannerSetting">
        <div class="BannerSetting-title">Shop Banner:</div>
        <div class="BannerSetting-banner">
            <img src="" alt="">
        </div>
        <div class="BannerSetting-btns">
            <button type="button" class="BannerSetting-btns-up">Upload</button>
            <button type="button" class="BannerSetting-btns-del">Delete</button>
        </div>
        <div class="BannerSetting-text">- The banner should be 1920px width and 150px height in gif or png format.</div>
        <div class="BannerSetting-save">
            <button type="button">Save</button>
        </div>
    </div>
</template>

<script>
    export default {
        
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
