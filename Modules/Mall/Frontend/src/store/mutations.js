// 更改vuex状态的方法
const mutations = {
    // 地区
    SET_COUNTRIES(state) {
        state.Countries = !state.Countries
    },
    // 注册邮箱
    SET_REGEMAIL(state, email) {
        state.RegEmail = email
    },
    // 设置收件箱所有数据
    SET_INBOX_FROM(state, From) {
        state.Inbox_From = From
    }
}

export default mutations