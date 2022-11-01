<template>
    <el-button type="primary" size="default" @click="">ww</el-button>
</template>
<script>
    const App = {
    data() {
        return {
            isCollapse: false,
            loadEnd: false
        };
    },
    created() {
        setTimeout(() => {
            this.loadEnd = true;
        }, 500);
        setTimeout(() => {
            loading.close()
        }, 1000);
    },
    methods: {
        changeMenuCollapse() {
            // this.$refs.saetmenu.change()
        }
    }
};
</script>