<template>
    <el-switch v-model="value1"></el-switch>
    <el-switch v-model="value1"></el-switch>
    <el-form :model="ST.form" label-width="80px">
        <el-form-item label="名称">
            <el-input v-model="row.title"></el-input>
        </el-form-item>

        <el-form-item label="规则/url">
            <el-input v-model="row.url" type="textarea"></el-input>
        </el-form-item>

        <el-form-item>
            <el-button type="primary" @click="onSubmit">Create</el-button>
            <el-button>Cancel</el-button>
        </el-form-item>
    </el-form>
</template>

<script>

new SaetApp({
    setup() {
        const _ = reactive({})
        _.row = reactive(ST.row)
        return _
    }
})
</script>