<template>
    <div>
        <v-modality-template title="Tips" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <div>
                    <img :src="require('@/assets/img/tips.png')" alt="" style="width: 78px;height: 78px;">
                </div>
                <div class="deleteAlbum-main-text">Are you sure you want to delete this category?</div>
                <div class="deleteAlbum-main-btn">
                    <button type="button" @click="onShow">Cancel</button>
                    <button type="button" @click="onClick">OK</button>
                </div>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    // 模态框模板
    // import ModalityTemplateVue from '../components/Modality-template.vue'
    import ModalityTemplateVue from '../../Album/components/Modality-template.vue'

    export default {
        methods: {
            onShow() {
                this.$emit('on-show')
            },
            onClick() {
                this.$emit('on-delete')
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

        &-text {
            margin-top: 16px;
            font-size: 16px;
            color: #666666;
        }

        &-btn {
            margin-top: 45px;

            & > button:first-child {
                background-color: #bfbfbf;
                margin-right: 35px;
            }

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
