<template>
    <div class="Send-main">
        <v-title title="Edit My Photo"></v-title>
        
        <section class="avatar">
            <v-img class="avatar-img" width="149" height="147" :imgSrc="require('@/assets/img/home/mr1.png')"></v-img>

            <Upload action="//jsonplaceholder.typicode.com/posts/">
                <button type="button" class="avatar-btn">Upload Photo</button>
            </Upload>

            <article class="avatar-article">
                <p>- Please upload a photo that matches the gender, age and status details in your personal profile.</p>
                <p>- Use a photo that is appropriate for a business setting. </p>
                <p>- Group photos are not allowed.</p>
                <p>- Photos violating the rules stated in the Terms of User will be removed without notice.</p>
            </article>

            <div class="avatar-btns">
                <button type="button" class="avatar-btns-cancel">Cancel</button>
                <button type="button" class="avatar-btns-save">Save</button>
            </div>
        </section>
    </div>
</template>

<script>
    import Title from "../components/Title"
    import Img from "@/components/Img"

    export default {
        components: {
            "v-title": Title,
            "v-img": Img
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
            border: 1px solid #f5f5f5;
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
