<template id="st-array">
    <div class="array-box" style="display: flex;flex-wrap: wrap;">
        <draggable tag="transition-group" v-model="forValue" handle=".order-handle" @sort="dragSort">
            <template #item="{ element, index }">
                <div class="item st-m-b-10">
                    <el-space>
                        <el-input v-model="forValue[index]" @input="input(element, index)"></el-input>
                        <el-button type="danger" circle @click="close(index)" v-if="forValue.length > 1"><i
                                class="ri-close-line"></i></el-button>
                        <el-button type="info" circle class="order-handle" v-if="forValue.length > 1"><i
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
    name: 'st-array',
    template: '#st-array',
    props: { modelValue: [Array, String] },
    setup(props, context) {
        Vue.defineEmits(['update:modelValue'])
        let defaultValue = props.modelValue
        const forValue = ref([''])
        if (typeof (defaultValue) == 'string') forValue.value = JSON.parse(defaultValue);
        if (typeof (defaultValue) == 'array') forValue.value = defaultValue;

        const close = (i) => {
            forValue.value.splice(i, 1)
            context.emit('update:modelValue', JSON.stringify(forValue.value));
        }
        const add = () => {
            forValue.value.push('')
            context.emit('update:modelValue', JSON.stringify(forValue.value));
        }

        const input = () => {
            context.emit('update:modelValue', JSON.stringify(forValue.value));
        }
        const dragSort = () => {
            context.emit('update:modelValue', JSON.stringify(forValue.value));
        }

        return { dragSort, forValue, close, add, input }
    }
})

</script>