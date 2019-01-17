// 更改vuex状态的方法
const mutations = {
    // 地区
    SET_COUNTRIES(state) {
        state.Countries = !state.Countries
    },
    // 注册邮箱
    SET_REGEMAIL(state, email) {
        state.RegEmail = email
    }

}

export default mutations