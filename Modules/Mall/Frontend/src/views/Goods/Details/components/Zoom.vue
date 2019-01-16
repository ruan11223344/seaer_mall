<template>
    <div class="box">
        <!-- <ProductZoomer
            :base-images="images"
            :base-zoomer-options="zoomerOptions"
        /> -->
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
                images: {
                    'normal_size': [
                        {
                        'id': 1,
                        'url': require('@/assets/img/details/demo1.jpg'),
                        },
                        {
                        'id': 2,
                        'url': require('@/assets/img/details/demo.jpg'),
                        }
                    ]
                },
                zoomerOptions: {
                    'zoomFactor': 2,
                    'pane': 'pane',
                    'hoverDelay': 100,
                    'namespace': 'container-zoomer',
                    'move_by_click':true,
                    'scroll_items': 2,
                    'choosed_thumb_border_color': "#ff3d00"
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
