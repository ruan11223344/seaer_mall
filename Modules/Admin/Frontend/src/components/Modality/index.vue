<template>
    <div class="modality">
        <section class="modality-block">
            <div class="modality-block-title">
                <div class="modality-block-title-text">{{ title }}</div>
                <div class="modality-block-title-close" @click="onHide">
                    <i class="el-icon-close" style="fontSize: 30px;"></i>
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
            onHide() {
                this.$emit('on-hide')
            }
        },
    }
</script>

<style lang="scss" scoped>
    .modality {
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.15);
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 10001;

        &-block {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 722px;
            height: auto;
            border-radius: 4px;
            @include  mixin-bg-color(white);

            &-title {
                height: 70px;
                padding: 0px 20px 0px 40px;
                box-sizing: border-box;
                @include  mixin-bg-color(lead);
                @include mixin-flex(space-between, center);

                &-text {
                    font-size: 22px;
                    @include  mixin-color(grey);
                }

                &-close {
                    cursor: pointer;
                }
            }
        }
    }
</style>