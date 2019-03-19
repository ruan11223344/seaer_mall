<template>
    <div :style="{width: width + 'px', height: height + 'px'}" class="imgBox">
        <img :src="imgSrc" class="img" />
    </div>
</template>

<script>
    export default {
        props: {
            width: '',
            height: '',
            imgSrc: {
                type: String,
            }
        },
        data() {
            return {
                imgObj: {
                    src: '',
                    loading: require('@/assets/img/loading.gif')
                },
            }
        },
        computed: {
            filterImgs() { // 过滤
                this.$set(this.imgObj, 'src', this.imgSrc)
                return this.imgObj
            }
        }
    }
</script>

<style lang="less" scoped>

    .imgBox {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .img {
        display: block;
        width: 100%;
        height: 100%;
    }
</style>
