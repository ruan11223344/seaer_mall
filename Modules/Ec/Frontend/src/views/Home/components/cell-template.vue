<template>
    <div>
        <div class="home-cell">
            <div class="home-cell-head">
                <Icon type="ios-list" size="38" />
                <span>All Categories</span>
            </div>
            <v-cell-item :data-content="table"></v-cell-item>
        </div>
    </div>
</template>
<script>
    import cellItemTemplateVue from './cell-item-template.vue';

    export default {
        data () {
            return {
                table: [
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Building material',
                        children: [
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            },
                            {
                                title: 'ppliances3123213213213213213',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    },
                    {
                        title: 'Home Furnishing',
                        children: [
                            {
                                title: '1',
                                children: [
                                    '1-1',
                                    '1-2',
                                    '1-3',
                                    '1-4',
                                    '1-5',
                                ]
                            },
                            {
                                title: '2',
                                children: [
                                    '2-1',
                                    '2-2',
                                    '2-3',
                                    '2-4',
                                    '2-5',
                                ]
                            },
                            {
                                title: '3',
                                children: [
                                    '3-1',
                                    '3-2',
                                    '3-3',
                                    '3-4',
                                    '3-5',
                                ]
                            }
                        ]
                    }
                ]
            }
        },
        components: {
            'v-cell-item': cellItemTemplateVue
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index');

    .home-cell {
        position: absolute;
        top: 0px;
        z-index: 1000;
        width: 251px;
        height: 440px;
    }
    .home-cell {
        left: 0px;
        background-color: rgba(0, 0, 0, 0.6);

        &-head {
            font-size: 18px;
            .color(white);
            .flex(flex-start, center);
            margin-top: 28px;
            margin-bottom: 9px;
            padding-left: 10px;
        }
    }
</style>
