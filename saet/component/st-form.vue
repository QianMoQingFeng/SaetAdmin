<template id="st-form">
    <el-form class="st-form" :model="data" ref="form" :rules="rules" label-width="120px" :label-position="position"
        :inline="false" size="normal">

        <template v-for="row in fields">
            <el-form-item :prop="row.name" v-if="typeof (row.visible) == 'undefined' ? row.visible = true : row.visible"
                :label="row.title" v-bind="row">
                <template v-if="row.case == 'text'">
                    <el-input v-model="data[row.name]" placeholder=""></el-input>
                </template>
                <template v-if="row.case == 'long-text'">
                    <el-input v-model="data[row.name]" placeholder="" :rows="2" type="textarea"></el-input>
                </template>
                <template v-if="row.case == 'json'">
                    <st-json v-model="data[row.name]"></st-json>
                </template>
                <template v-if="row.case == 'array'">
                    <st-array v-model="data[row.name]"></st-array>
                </template>
                <template v-if="row.case == 'image'">
                    <st-image-upload v-model="data[row.name]" v-bind="row"></st-image-upload>
                </template>
                <template v-if="row.case == 'remote-select'">
                    <st-select v-model="data[row.name]" :init="Boolean(row)" v-bind="row"></st-select>
                </template>
                <template v-if="row.case == 'select'">
                    <el-select v-model="row.value" placeholder="please select your zone">
                        <el-option
                            v-for="(label, value) in  typeof (row.option) == 'string' ? JSON.parse(row.option) : row.option"
                            :key="value" :label="label" :value="value">
                        </el-option>
                    </el-select>
                </template>
                <template v-if="row.case == 'radio'">
                    <el-radio-group v-model="data[row.name]" class="ml-4">
                        <el-radio :label="value"
                            v-for="(title, value) in  typeof (row.option) == 'string' ? JSON.parse(row.option) : row.option">
                            {{ title }}</el-radio>
                    </el-radio-group>
                </template>
            </el-form-item>
        </template>
        <el-form-item class="operation">
            <el-button type="primary" @click="sure" :loading="loadType == 'button' ? butLoading : false">确定</el-button>
            <el-button type="info" @click="reset" plain>重置</el-button>
            <el-button type="info" @click="back" plain v-if="isBack">撤回</el-button>
        </el-form-item>
    </el-form>
</template>
    {component is="st-array,st-json,st-upload-image,st-select"/}
<script>
SaetComponent({
    name: 'st-form',
    template: '#st-form',
    props: {
        fields: Array, data: Object,
        url: { type: String, default: window.location.href },
        isBack: { type: Boolean, default: true },
        isOperation: { type: Boolean, default: false },
        loadType: { type: [Boolean, String], default: 'full' }
    },
    setup(props, context) {

        const sure = () => {
            startLoading()
            St.axios.post(props.url, getData(), { successToast: true }).then((res) => {
                closeLoading()
                // context.emit('success', null)
            }).catch((err) => {
                // closeLoading()
            })
        }

        const butLoading = ref(false)
        const fullLoadRef = ref(null)
        const startLoading = () => {
            if (props.loadType == 'button') butLoading.value = true;
            if (props.loadType == 'full') {
                fullLoadRef.value = St.loading.service({
                    target: '.st-form',
                    lock: true,
                    text: '正在保存...',
                })
            }
        }
        const closeLoading = () => {
            butLoading.value = false; fullLoadRef.value.close();
        }

        const initData = St.copy(props.data);

        const getData = () => {
            let row = {}
            for (const key in props.data) {
                if (Object.hasOwnProperty.call(props.data, key)) {
                    if (props.fields.findIndex((i) => i.name == key) > -1) {
                        row[key] = props.data[key];
                    }
                }
            }
            return row
        }

        const reset = () => {
            props.fields = initData.value
            initData.value = reactive(JSON.parse(JSON.stringify(props.fields)))
        }
        // 作用数据库
        const back = () => {
            props.filed = initData.value
            initData.value = reactive(JSON.parse(JSON.stringify(props.fileds)))
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
        if (window.innerWidth < 500) position.value = 'top'
        return { sure, back, butLoading, reset, edit, del, position }
    }
})
</script>

<style>
.st-form .el-form-item {
    border-radius: 3px;
    padding: 10px;
    margin-bottom: 0px;
}

.st-form .el-form-item .operation-btn {
    display: none;
}

.st-form .el-form-item:hover .operation-btn {
    display: block;
}

.st-form .el-form-item:nth-of-type(even):not(.operation) {
    background-color: var(--el-fill-color-light);
}
</style>