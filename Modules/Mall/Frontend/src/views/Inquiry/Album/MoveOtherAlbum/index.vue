<template>
    <div>
        <v-modality-template title="Move to other album" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <div>
                    <img :src="require('@/assets/img/tips.png')" alt="" style="width: 78px;height: 78px;">
                </div>
                <div class="deleteAlbum-main-text">Only one photo album, hurry up Add Album!</div>
                <div class="deleteAlbum-main-btn">
                    <button type="button">Submit</button>
                </div>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    // 模态框模板
    import ModalityTemplateVue from '../components/Modality-template.vue'

    export default {
        methods: {
            onShow() {
                this.$emit('on-show')
            }
        },
        components: {
            "v-modality-template": ModalityTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .deleteAlbum-main {
        .flex(center, center);
        flex-direction: column;
        height: 352px - 70px;
        font-size: 0px;

        &-text {
            margin-top: 23px;
            font-size: 20px;
            color: #666666;
        }

        &-btn {
            margin-top: 38px;

            & > button {
                width: 135px;
                height: 37px;
                background-color: #f0883a;
                font-size: 18px;
                color: #ffffff;
                border: none;
            }
        }
    }
</style>
