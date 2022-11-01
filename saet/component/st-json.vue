<template id="st-json">
    <div class="json-box" style="display: flex;flex-wrap: wrap;">
        <draggable v-model="jsonArr" tag="transition-group" handle=".order-handle" @sort="dragSort">
            <template #item="{ element, index }">
                <div class="item st-m-b-10">
                    <el-space>
                        <el-input v-model="element.key" @input="inputKey(element.key, index)" placeholder="键名">
                        </el-input>
                        <el-popover :width="240"
                            :disabled="(element.value === 'true' || element.value === 'false' || element.value === true || element.value === false) ? false : true">
                            <template #reference>
                                <el-input v-model="element.value" @input="inputValue(element.key, index)"
                                    placeholder="键值"> </el-input>
                            </template>
                            <template #default>
                                <el-alert title="你输入的类型可能是布尔型(Boolean)，请确认～" type="warning" :closable="false">
                                    <template #default>
                                        <el-radio-group class="ml-4" :model-value="typeof (element.value)">
                                            <el-radio label="boolean"
                                                @click="element.value = St.string(element.value).toBoolean(), update()">
                                                布尔型(Boolean)
                                            </el-radio>
                                            <el-radio label="string"
                                                @click="element.value = element.value.toString(), update()">
                                                字符串型(String)</el-radio>
                                        </el-radio-group>
                                    </template>
                                </el-alert>
                            </template>
                        </el-popover>
                        <template
                            v-if="element.value === 'true' || element.value === 'false' || element.value === true || element.value === false">
                            类型{{ typeof (element.value) }}
                        </template>
                        <el-button type="danger" circle @click="close(index)" v-if="jsonArr.length > 1"><i
                                class="ri-close-line"></i></el-button>
                        <el-button type="info" circle class="order-handle" v-if="jsonArr.length > 1"><i
                                class="ri-drag-move-2-fill"></i></el-button>
                    </el-space>
                </div>
            </template>
        </draggable>
    </div>
    <div class="st-flex" style="width: 100%;">
        <el-button @click="add">添加</el-button>
    </div>
</template>

<script>
new SaetComponent({
    name: 'st-json',
    template: `#st-json`,
    props: { modelValue: [Object, String] },
    setup(props, context) {
        Vue.defineEmits(['update:modelValue'])

        const jsonArr = ref([{ key: '', value: '' }])


        Vue.watch(
            () => props.modelValue,
            (defaultValue, o) => {
                if (props.modelValue && typeof (defaultValue) == 'string') {
                    let temp = []
                    for (const key in JSON.parse(defaultValue)) {
                        temp.push({ key: key, value: JSON.parse(defaultValue)[key] })
                    }
                    jsonArr.value = temp
                }
                if (props.modelValue && typeof (defaultValue) == 'object') {
                    let temp = []
                    for (const key in defaultValue) {
                        temp.push({ key: key, value: defaultValue[key] })
                    }
                    jsonArr.value = temp
                }
            }, { deep: true, immediate: true }
        )



        function getValue() {
            let value = {}
            for (let index = 0; index < jsonArr.value.length; index++) {
                const e = jsonArr.value[index];
                value[e.key] = e.value
            }
            return JSON.stringify(value)
        }

        const inputKey = (v, i) => {
            let jsonArr1 = jsonArr.value.concat()
            jsonArr1.splice(i, 1)
            if (jsonArr1.findIndex((item) => item.key == v) > -1) return St.message.error('键名不能重复！');
            // 不使用JSON转序列
            let value = {}
            for (let index = 0; index < jsonArr.value.length; index++) {
                const e = jsonArr.value[index];
                value[e.key] = e.value
            }
            context.emit('update:modelValue', getValue());
        }

        const inputValue = (v, i) => {
            let jsonArrTemp = jsonArr.value.concat()
            jsonArrTemp.splice(i, 1)
            if (jsonArr.value[i].key == '') return St.message.error('键名不能是空！');
            context.emit('update:modelValue', getValue());
        }

        const add = () => {
            if (jsonArr.value.find((item) => item.key == '')) return St.message.error('键名不能是空！');
            jsonArr.value.push({ key: '', value: '' })
        }

        const close = (i) => {
            jsonArr.value.splice(i, 1)
            context.emit('update:modelValue', getValue());
        }

        const dragSort = () => {
            context.emit('update:modelValue', getValue());
            console.log('dad ');
        }
        const update = dragSort
        return { dragSort, update, jsonArr, inputKey, inputValue, add, close }
    }
})
</script>