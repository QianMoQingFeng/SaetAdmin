<template id="st-select">

    <el-select v-model="modelValue" v-bind="$attrs" ref="selectRef" @visible-change="visibleChange" :loading="loading"
        filterable :filter-method="(total == list.length && list.length) ? null : inputValue">
        <el-option v-for="(row, index) in list " :key="index" :label="(row[label] || row)" :value="(row[value] || row)">
        </el-option>
    </el-select>

    <div ref="opeartionRef">
        <div v-if="(loading == false && total != list.length && total)" class="st-flex st-m-10 align-center">
            <el-pagination :hide-on-single-page="true" :total="total" layout="->,prev, next,jumper, " :page-size="limit"
                :current-page="page" small background @current-change="(n) => { page = n; getList() }"></el-pagination>
            / {{ Math.ceil(total / limit) }}
        </div>
    </div>

</template>

<script>
SaetComponent({
    name: 'st-select',
    template: '#st-select',
    props: {
        modelValue: [Object, String],
        label: { type: String, default: 'name' },
        value: { type: String, default: 'id' },
        limit: { type: Number, default: 10 },
        url: String, init: { default: false }, alwaysUpdatet: { default: false }
    },

    setup(props) {

        const selectRef = ref()
        const opeartionRef = ref(null)
        const list = ref([])
        const total = ref(0)
        Vue.onMounted(() => {
            let wrap = selectRef.value.tooltipRef.popperRef.contentRef.querySelector('.el-select-dropdown__wrap')
            wrap.appendChild(opeartionRef.value)
        })
        // })
        const visibleChange = (s) => {
            // 排除数据
            if (s) {
                if (total.value == 0 || props.alwaysUpdatet) {
                    getList()
                }
            } else {
                if (fast_value.value) {
                    fast_value.value = null
                    page.value = 1
                }
            }
        }

        const placement = ref(null)
        const loading = ref(true)
        const page = ref(1);
        const getList = () => {
            loading.value = true
            St.axios.post(props.url, { _label: [props.value, props.label], page: page.value, limit: props.limit, fast_value: fast_value.value }).then((res) => {
                list.value = res.list
                total.value = res.total || res.list.length
                loading.value = false
            })
        }

        const fast_value = ref(null);
        const inputValue = (value) => {
            if (typeof value != 'undefined') {
                fast_value.value = value
                getList()
            }
        }
        if (props.init) {
            getList()
        }
        return { page, opeartionRef, inputValue, placement, selectRef, getList, list, selectRef, visibleChange, loading, total }
    }
})
</script>