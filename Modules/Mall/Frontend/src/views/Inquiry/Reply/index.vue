<template>
    <div class="reply">
        <section class="reply-btn">
            <button type="button">Send</button>
            <button type="button">Close</button>
        </section>

        <section class="reply-card">
            <div class="reply-card-title">
                <label for="">To:</label>
                <span>Charles Wang</span>
            </div>
            <div class="reply-card-subject">
                <label for="">Subject:</label>
                <span>Inquiry about “High Quality New Crop/Fresh Garlic - Chinese Shandong Garlic”</span>
            </div>
            <div class="reply-card-info">
                <v-img width="64" height="64" imgSrc=""></v-img>
                <div class="reply-card-info-text">
                    <span>Purchase Quantity:10 Bays</span>
                    <span>Extra Request:Price,Company Profile</span>
                </div>
            </div>
        </section>

        <section class="reply-input">
            <!-- 询问内容 -->
            <textarea>

            </textarea>
        </section>
        
        <template>
            <Collapse simple class="reply-history">
                <Panel name="1" :hide-arrow="true">
                    <div class="reply-history-title">
                        <span>Quote</span>
                        <Icon type="ios-arrow-forward" class="reply-history-title-icon"/>
                    </div>
                    <!-- 历史信息 -->
                    <section slot="content" class="reply-history-content">
                        <dl class="reply-history-content-item">
                            <dd class="reply-history-content-item-list">
                                <label for="">From: </label>
                                <span>Charles Wang</span>
                            </dd>
                            <dd class="reply-history-content-item-list">
                                <label for="">To: </label>
                                <span>Nancy</span>
                            </dd>
                            <dd class="reply-history-content-item-list">
                                <label for="">Sent: </label>
                                <span>Dec,28 2018 13:21</span>
                            </dd>
                            <dd class="reply-history-content-item-list">
                                <label for="">Subject: </label>
                                <span>Inquiry about “High Quality New Crop/Fresh Garlic - Chinese Shandong Garlic”</span>
                            </dd>
                            <dd class="reply-history-content-item-list reply-history-content-item-title">
                                <label for="">Hello, do you have any bags of cat litter?</label>
                            </dd>
                        </dl>
                    </section>
                </Panel>
            </Collapse>
        </template>
    </div>
</template>

<script>
    import Img from '@/components/Img'

    export default {
        components: {
            'v-img': Img
        }
    }
</script>

<style lang="less" scoped>
    @import url('../../../assets/css/index.less');

    .reply {
        width: 945px;
        align-self: flex-start;

        &-btn {
            .flex(flex-start, center);
            height: 54px;
            background-color: #ffffff;
            // margin-bottom: 2px;
            border-bottom: 2px solid #f5f5f9;

            & > button {
                border: none;
                width: 66px;
                height: 25px;
                background-color: #f0883a;
                font-size: 14px;
                color: #ffffff;
                margin-left: 16px;
            }
            
            & > button:last-of-type {
                margin-left: 12px;
                color: #f0883a;
                background-color: #fff8f3;
	            border: solid 1px #f0883a;
            }
        }

        &-card {
            padding-top: 23px;
            padding-left: 16px;
            padding-bottom: 15px;
            background-color: #e9e9ed;

            &-title, &-subject {

                & > label {
                    font-size: 14px;
                    line-height: 1;
                    color: #333333;
                }

                & > span {
                    font-size: 14px;
                    line-height: 1;
                    color: #666666;
                    margin-left: 11px;
                }
            }

            &-subject {
                margin-top: 23px;
            }

            &-info {
                .flex();
                margin-top: 15px;

                &-text {
                    .flex(center, flex-start, column);
                    margin-left: 18px;

                    & > span {
                        font-size: 14px;
                        line-height: 1;
                        color: #666666;
                    }

                    & > span:first-child {
                        margin-bottom: 11px;
                    }
                }
            }


        }

        &-input {
            height: 173px;
            background-color: #ffffff;
            border-bottom: 2px solid #f5f5f9;
            
            & > textarea {
                width: 100%;
                height: 100%;
                resize: none;
                border: none;
                padding: 10px;
            }
        }
        
        &-history {
            height: 35px;
            background-color: #e9e9ed;
            border: none;
            
            &-title {
                .flex(flex-start, center);
                height: 35px;
                line-height: 35px;
                font-size: 14px;
                color: #333333;
                cursor: pointer;
                
            }

            &-content {
                height: 160px;
                padding: 15px 20px;

                &-item {
                    width: 100%;
                    height: 100%;
                    padding-left: 12px;
                    border-left: 1px solid #dddddd;

                    &-list {
                        font-size: 14px;
                        line-height: 1;
                        color: #333333;
                        margin-bottom: 12px;

                        & > span {
                            font-size: 14px;
                            color: #666666;
                        }
                    }

                    &-title {
                        margin-top: 19px;
                    }

                }
            }
        }
        
    }
</style>
