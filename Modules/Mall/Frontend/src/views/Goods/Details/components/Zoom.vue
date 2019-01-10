<template>
    <div class="box">
        <img-zoom :src="imgSrc.imgSrc" width="348" height="348" :bigsrc="imgSrc.imgSrcAmplification" :configs="configs"></img-zoom>
    </div>
</template>

<script>
    import imgZoom from 'vue2.0-zoom'
    
    export default {
        props: {
            imgSrc: {
                type: Object
            }
        },
        data() {

            return {
                configs: {
                    width:350,
                    height:350,
                    maskWidth:150,
                    maskHeight:150,
                    maskColor:'black',
                    maskOpacity:0.3
                }
            }
        },
        methods: {
        },
        mounted() {
        },
        components: {
            imgZoom 
        }
    }
</script>

<style lang="less" scoped>
    .box {
        position: relative;
        width: 100%;
        height: 100%;
        cursor: move;
    }
</style>
