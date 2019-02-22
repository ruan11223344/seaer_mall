<template>
    <div>
        <v-modality-template title="Tips" @on-show="onShow">
            <section slot="main" class="deleteAlbum-main">
                <div>
                    <img :src="require('@/assets/img/tips.png')" alt="" style="width: 78px;height: 78px;">
                </div>
                <div class="deleteAlbum-main-text">Are you sure you are going to do this? note: the picture in use will also be deleted.</div>
                <div class="deleteAlbum-main-btn">
                    <button type="button" @click="onShow(false)">Cancel</button>
                    <button type="button" @click="onDelete">OK</button>
                </div>
            </section>
        </v-modality-template>
    </div>
</template>

<script>
    // 模态框模板
    import ModalityTemplateVue from '../components/Modality-template.vue'

    export default {
        props: {
            dataId: ''
        },
        methods: {
            onShow(bool) {
                this.$emit('on-show', bool)
            },
            onDelete() {
                if(this.dataId != false) {
                    this.$request({
                        url: '/album/modify_photos',
                        method: 'post',
                        data: {
                            'photo_id_list': this.dataId,
                            action: 'delete'
                        }
                    }).then(res => {

                        if(res.code == 200) {
                            this.onShow(true)

                            this.$Message.info({
                                content: res.message,
                                duration: 3
                            })
                        }else {
                            this.onShow(false)

                            this.$Message.error({
                                content: res.message,
                                duration: 3
                            })
                        }
                    }).catch(err => {
                        return false
                    })
                }else {
                    this.onShow(false)
                }
                
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
            width: 310px;
            text-indent: 1em;
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
