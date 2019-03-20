<template>
    <div>
        <div style="marginBottom: 20px;">广告位列表</div>
        <template>
            <el-table
                v-loading="banner == null"
                ref="singleTable"
                :data="banner"
                style="width: 100%"
                size="mini"
                >

                <el-table-column
                    align="center"
                    label="序号"
                    type="index"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="ad_name"
                    label="广告位名称"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="width"
                    label="宽度"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="height"
                    label="高度"
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    label="操作"
                    width="180px"
                    >
                    <template slot-scope="scope">
                        <button
                            class="edit"
                            @click="onEdit(scope.row)"
                            >
                            编辑
                        </button>
                    </template>
                </el-table-column>
            </el-table>
        </template>

        <div style="marginTop: 40px;marginBottom: 20px;">幻灯片广告</div>
        <template>
            <el-table
                v-loading="slide == null"
                ref="singleTable"
                :data="slide"
                style="width: 100%"
                size="mini"
                >

                <el-table-column
                    align="center"
                    label="序号"
                    type="index"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="ad_name"
                    label="广告位名称"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="width"
                    label="宽度"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="height"
                    label="高度"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    label="操作"
                    width="180px"
                    >
                    <template slot-scope="scope">
                        <button
                            class="edit"
                            @click="onEdit(scope.row)"
                            >
                            编辑
                        </button>
                    </template>
                </el-table-column>
            </el-table>
        </template>

        <div style="marginTop: 40px;marginBottom: 20px;">热卖推荐</div>
        <template>
            <el-table
                v-loading="product == null"
                ref="singleTable"
                :data="product"
                style="width: 100%"
                size="mini"
                >

                <el-table-column
                    align="center"
                    label="序号"
                    type="index"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="product_name"
                    label="商品名称"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="shop_name"
                    label="所属店铺"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    property="upload_time"
                    label="上传时间"
                    show-overflow-tooltip
                    >
                </el-table-column>

                <el-table-column
                    align="center"
                    label="操作"
                    width="180px"
                    >
                    <template slot-scope="scope">
                        <button
                            class="edit"
                            @click="onProductEdit(scope.row.index_product_recommend_id, scope.row.product_id, scope)"
                            >
                            编辑
                        </button>
                    </template>
                </el-table-column>
            </el-table>
        </template>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                banner: null,
                slide: null,
                product: null,
                allProductId: null
            }
        },
        methods: {
            onEdit(data) {
                const obj = JSON.stringify(data)
                this.$router.push('/advertisement/edit?obj=' + obj)
            },
            onProductEdit(index_product_recommend_id, product_id, scope) {
                const arr = JSON.stringify(this.allProductId)
                this.$router.push('/advertisement/productedit?index_product_recommend_id=' + index_product_recommend_id + '&product_id=' + product_id + '&allProductId=' + arr)
            },
            GetAdList() {
                this.$GetRequest.getAdList()
                    .then(({ banner, slide }) => {
                        this.banner = banner
                        this.slide = slide
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })

                this.$GetRequest.getProductRecommend()
                    .then(res => {
                        this.product = res
                        this.allProductId = []
                        for(let item of res) {
                            this.allProductId.push(item.product_id)
                        }
                    })
                    .catch(err => {
                        this.$message.error(err.message)
                    })
            }
        },
        mounted() {
            this.GetAdList()
        }
    }
</script>

<style lang="scss" scoped>
    .edit {
        width: 60px;
        height: 21px;
        font-size: 14px;
        border: none;
        @include mixin-color(white);
        @include mixin-bg-color(yellow);
    }
</style>
