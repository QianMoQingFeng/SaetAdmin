<template>
    <el-form :model="row" label-width="80px">
        <el-form-item label="名称">
            <el-input v-model="row.title"></el-input>
        </el-form-item>
        <el-form-item label="别名">
            <el-input v-model="row.diyname"></el-input>
        </el-form-item>
        <el-form-item label="权重">
            <el-input v-model="row.weight"></el-input>
        </el-form-item>
        <el-form-item label="内容">
            <el-input v-model="row.content" type="textarea"></el-input>
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
        const row = reactive(ST.row)
        console.log(row);
        const onSubmit = () => {
            // console.log(row.content);
            console.log(row.content.replace(/\n/g, "\\n").replace(/\r/g, "\\r"));
            // St.deepAssign(row, {
            //     content: row.content.replace(/\n/g, "\\n").replace(/\r/g, "\\r")
            // }
            // // return;
            St.axios.post('', row, { successToast: 1 }).then((e) => {
                // console.log('dada');
            })
        }
        return { row, onSubmit }
    }
})
</script>