<template>
    <div class="card">
        <figure>
            <!-- <img src="" alt=""> -->
            <v-img width="211" height="167" imgSrc=""></v-img>
            <figcaption class="card-footer">
                <div class="card-footer-title">Default Album</div>
                <div class="card-footer-subheading">Total {{ '1754' }} photos</div>
            </figcaption>
        </figure>
        <button type="button" class="card-edit">Edit</button>
    </div>
</template>

<script>
    import Img from "@/components/Img"

    export default {
        components: {
            "v-img": Img,
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .card {
        width: 211px;
        border:1px solid #ccc;
        display: inline-block;
        
        &-footer {
            .flex(center, center);
            flex-direction: column;
            width: 211px;
            height: 54px;
            border: solid 1px #eeeeee;
            // border-top: 0px;

            &-title {
                font-size: 16px;
                color: #666666;
            }

            &-subheading {
                font-size: 12px;
                color: #999999;
            }
        }

        &-edit {
            display: block;
            width: 50px;
            height: 19px;
            background-color: #f0883a;
            border: none;
            font-size: 14px;
            color: #ffffff;
            margin: 0px auto;
            margin-top: 13px;
        }
    }
</style>
