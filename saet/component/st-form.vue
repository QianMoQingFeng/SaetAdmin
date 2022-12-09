<template id="st-form">
    <el-form class="st-form" ref="formRef" :model="data" :rules="rules" label-width="120px" :label-position="position"
        :inline="false" size="normal">
        <template v-for="v in fields">
            <el-form-item :prop="v.name" v-if="v.visible" :label="v.title" v-bind="v">
                <template v-if="v.case == 'slot'">
                    <slot :name="v.name"></slot>
                </template>
                <template v-if="v.case == 'text'">
                    <el-input v-model="data[v.name]" placeholder=""></el-input>
                </template>
                <template v-if="v.case == 'long-text'">
                    <el-input v-model="data[v.name]" placeholder="" :rows="2" type="textarea"></el-input>
                </template>
                <template v-if="v.case == 'json'">
                    <st-json v-model="data[v.name]"></st-json>
                </template>
                <template v-if="v.case == 'array'">
                    <st-array v-model="data[v.name]"></st-array>
                </template>
                <template v-if="v.case == 'image'">
                    <st-image-upload v-model="data[v.name]" v-bind="v"></st-image-upload>
                </template>

                <template v-if="v.case == 'remote-select'">
                    <st-select v-model="data[v.name]" :init="Boolean(data[v.name])" v-bind="v"></st-select>
                </template>

                <template v-if="v.case == 'select'">
                    <el-select v-model="data[v.name]" placeholder="please select your zone">
                        <el-option v-for="value in v.option" :key="value" :label="value" :value="value"
                            v-if="typeof (v.option) == 'array'">
                        </el-option>
                        <template v-else>
                            <el-option
                                v-for="(label, value) in  typeof (v.option) == 'string' ? JSON.parse(v.option) : v.option"
                                :key="value" :label="label" :value="value">
                            </el-option>
                        </template>
                    </el-select>
                </template>
                <template v-if="v.case == 'radio'">
                    <el-radio-group v-model="data[v.name]" class="ml-4">
                        <el-radio :label="value"
                            v-for="(title, value) in  typeof (v.option) == 'string' ? JSON.parse(v.option) : v.option">
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
        const formRef = ref(null)
        const sure = async () => {
            await formRef.value.validate((valid, fields) => {
                if (valid) {
                    St.axios.post(props.url, getData(), {
                        successToast: true, loadToast: {
                            case: 'full', target: '.st-form',
                            lock: true,
                            text: '正在保存...',
                        }
                    })
                }
            })
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

        const fieldDefault = { visible: true, case: 'text' }
        const initFields = () => {
            for (let index = 0; index < props.fields.length; index++) {
                props.fields[index] = St.deepAssign(fieldDefault, props.fields[index])
            }
        }

        initFields()
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
        // 手机自适应
        const position = ref('left')
        if (window.innerWidth < 500) position.value = 'top'
        return { formRef, sure, back, reset, edit, del, position }
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

.st-form .el-form-item__content div {
    /* flex: 1; */
}
</style>