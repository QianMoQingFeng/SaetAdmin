<template>
    <div class="body">
        <center>
            <el-button type="primary" size="default" @click="ajax">
                {{ title }}
            </el-button>
        </center>
    </div>
</template>

<script>
const App = {
    data() {
        return {
            title: '这是一个商品列表页面～'
        }
    }, methods: {
        ajax() {
            St.axios.post('dd/ss', this.formDatam, { baseUrlType: 'root' }).then((res) => {
                console.log(res);
            }).catch((err) => {
                console.log('接口', err);
            });
        }
    },
}
</script>

<style>
.body {
    margin-top: 200px;
}
</style>