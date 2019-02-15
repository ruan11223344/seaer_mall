<template>
    <div class="modality">
        <section class="modality-block">
            <div class="modality-block-title">
                <div class="modality-block-title-text">{{ title }}</div>
                <div class="modality-block-title-close" @click="onShow">
                    <Icon type="md-close" size="21" color="#cccccc"/>
                </div>
            </div>
            <slot name="main"></slot>
        </section>
    </div>
</template>

<script>
    export default {
        props: {
            title: ''
        },
        methods: {
            onShow() {
                this.$emit('on-show')
            }
        },
    }
</script>

<style lang="less" scoped>
    @import url('../../../../assets/css/index.less');

    .modality {
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.15);
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 10000;

        &-block {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: auto;
            background-color: #ffffff;

            &-title {
                height: 70px;
                background-color: #f5f5f8;
                .flex(space-between, center);
                padding: 0px 20px 0px 40px;

                &-text {
                    font-size: 22px;
                    color: #666666;
                }

                &-close {
                    cursor: pointer;
                }
            }
        }
    }

</style>