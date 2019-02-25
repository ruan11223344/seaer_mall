export default {
    sleep(time) {
        return new Promise(resolve => {
            setTimeout(resolve, time)
        })
    }
}
