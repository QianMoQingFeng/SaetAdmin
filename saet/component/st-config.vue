<template id="st-config">
    <el-form class="st-config" :model="formData" ref="form" :rules="rules" label-width="120px"
        :label-position="position" :inline="false" size="normal">
        <template v-for="row in list">
            <el-form-item prop="account" v-if="typeof (row.visible) == 'undefined' ? row.visible = true : row.visible">
                <template #label>
                    {{ row.title }}
                    <div class="operation-btn" v-if="isOperation">
                        <saet-icon name="edit" class="st-m-l-6" @click.stop="edit(row)"></saet-icon>
                        <el-popconfirm :title="'确定删除`' + row.title + '`配置项?'" @confirm="del(row)">
                            <template #reference>
                                <saet-icon name="close" class="st-m-l-6" :size="16"></saet-icon>
                            </template>
                        </el-popconfirm>
                    </div>
                </template>
                <template v-if="row.type == 'text'">
                    <el-input v-model="row.value" placeholder=""></el-input>
                </template>
                <template v-if="row.type == 'long-text'">
                    <el-input v-model="row.value" placeholder="" :rows="2" type="textarea"></el-input>
                </template>
                <template v-if="row.type == 'json'">
                    <st-json v-model="row.value"></st-json>
                </template>
                <template v-if="row.type == 'array'">
                    <st-array v-model="row.value"></st-array>
                </template>
                <template v-if="row.type == 'image'">
                    <st-image-upload v-model="row.value" :config="{ limit: 1 }"></st-image-upload>
                </template>
                <template v-if="row.type == 'select'">
                    <el-select v-model="row.value" placeholder="please select your zone">
                        <el-option
                            v-for="(label, value) in  typeof (row.option) == 'string' ? JSON.parse(row.option) : row.option"
                            :key="value" :label="label" :value="value">
                        </el-option>
                    </el-select>
                </template>
                <template v-if="row.type == 'radio'">
                    <el-radio-group v-model="row.value" class="ml-4">
                        <el-radio :label="value"
                            v-for="(title, value) in  typeof (row.option) == 'string' ? JSON.parse(row.option) : row.option">
                            {{ title }}</el-radio>
                    </el-radio-group>
                </template>
            </el-form-item>
        </template>
        <el-form-item class="operation">
            <el-button type="primary" @click="sure" :loading="loading">确定</el-button>
            <el-button type="info" @click="reset" plain>重置</el-button>
            <el-button type="info" @click="back" plain v-if="isBack">撤回</el-button>
        </el-form-item>
    </el-form>
</template>
{component is="st-array,st-json,st-upload-image"/}
<script>
SaetComponent({
    name: 'st-config',
    template: '#st-config',
    props: { list: Array, url: String, isBack: { type: Boolean, default: true }, isOperation: { type: Boolean, default: false } },
    setup(props, context) {
        const loading = ref(false)
        const sure = () => {
            loading.value = true
            St.axios.post(props.url, { data: formData.value }, { successToast: true }).then((res) => {
                loading.value = false
                context.emit('success', null)
            }).catch((err) => {
                loading.value = false
            })
        }
        const initData = ref(JSON.parse(JSON.stringify(props.list ?? [])))

        const getData = (list) => {
            if (list) {
                let res = {}
                for (let index = 0; index < list.length; index++) {
                    const e = list[index];
                    res[e.name] = e.value
                }
                return res;
            }
        }

        const formData = Vue.computed(() => {
            return getData(props.list)
        })

        const reset = () => {
            props.list = initData.value
            initData.value = reactive(JSON.parse(JSON.stringify(props.list)))
        }
        // 作用数据库
        const back = () => {
            props.list = initData.value
            initData.value = reactive(JSON.parse(JSON.stringify(props.list)))
        }


        const edit = (row) => {
            context.emit('edit', row)
        }

        const del = (row) => {
            St.axios.post(ST.apiContUrl + '/del', row, { successToast: true }).then(() => {
                context.emit('success', null)
            })
        }
        const position = ref('left')
        if (window.innerWidth < 500 ) position.value = 'top'
        return { sure, back, loading, reset, edit, del, formData, position }
    }
})
</script>

<style>
.st-config .el-form-item {
    border-radius: 3px;
    padding: 10px;
    margin-bottom: 0px;
}

.st-config .el-form-item .operation-btn {
    display: none;
}

.st-config .el-form-item:hover .operation-btn {
    display: block;
}

.st-config .el-form-item:nth-of-type(even):not(.operation) {
    background-color: var(--el-fill-color-light);
}
</style>