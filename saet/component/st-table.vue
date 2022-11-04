<template id="saet-table">
    <div class="saet-table">
        <el-collapse-transition v-if="config.search">
            <div v-if="config.search.visible" class="search">
                <el-row>
                    <template v-for="s in searchList">
                        <el-col :lg="s.lg ?? 6" :md="s.md ?? 8" :sm="s.sm ?? 12" :xs="s.xs ?? 24">
                            <el-form-item :label="s.title">
                                <!-- 文本 -->
                                <template v-if="s.type == 'text'">
                                    <el-input v-model="s.value" v-bind="s"></el-input>
                                </template>
                                <!-- 下拉单选 -->
                                <template v-if="s.type == 'select'">
                                </template>
                                <!-- 选择日期/月份/年份 -->
                                <template v-if="s.type == 'day' || s.type == 'month' || s.type == 'year'">
                                    <el-date-picker v-model="s.value" v-bind="s"></el-date-picker>
                                </template>
                                <!-- 日期/时间/月份区间 -->
                                <template
                                    v-if="s.type == 'daterange' || s.type == 'monthrange' || s.type == 'datetimerange'">
                                    <el-date-picker v-model="s.value" v-bind="s"></el-date-picker>
                                </template>
                                <!-- 单选 -->
                                <template v-if="s.type == 'radio'">
                                    <el-radio-group v-model="s.value">
                                        <template
                                            v-for="r in s.list ?? [{ title: '是', value: 1 }, { title: '否', value: 0 }]">
                                            <el-radio :label="r.value">
                                                {{ r.title }}
                                            </el-radio>
                                        </template>
                                    </el-radio-group>
                                </template>
                                <!-- <template
                                v-if="e.type == 'daterange' || e.type == 'monthrange' || e.type == 'datetimerange'">
                                <el-date-picker v-model="e.value" :type="e.type" :placeholder="e.desc"
                                    :value-format="e.valueFormat"></el-date-picker>
                            </template> -->
                            </el-form-item>
                        </el-col>
                    </template>
                    <el-col :lg="6" :md="8" :sm="12" :xs="24" class="item">
                        <el-form-item label="操作">
                            <el-button :loading="loading" type="primary" @click="getList">
                                {{ loading ? '加载中' : '查询' }}
                            </el-button>
                            <el-button @click="clearSearchValue">清空</el-button>
                        </el-form-item>
                    </el-col>
                </el-row>
            </div>
        </el-collapse-transition>
        <!-- tpl_cache -->
        <div class="head st-flex ">
            <!-- <el-row>
                    <template v-for="s in searchList">
                        <el-col :lg="s.lg ?? 6" :md="s.md ?? 8" :sm="s.sm ?? 12" :xs="s.xs ?? 24"> -->
            <el-button icon="refresh" class="st-m-r-8" circle :loading="loading" @click="getList">
            </el-button>

            <el-button type="primary" class="op-btn">
                <saet-icon name="ri-add-fill" :size="16"></saet-icon>
                <span class="title">添加</span>
            </el-button>

            <template v-if="fields.findIndex((item) => item.case == 'selection') > -1">
                <el-button type="primary" class="op-btn" :disabled="selectedRows.length ? false : true"
                    @click="editBtnClicked">
                    <saet-icon name="ri-pencil-fill"></saet-icon>
                    <span class="title">编辑</span>
                </el-button>
                <el-popconfirm :title="`确定删除选中的${selectedRows.length}项数据?`" @confirm="delMany()">
                    <template #reference>
                        <el-button type="danger" class="op-btn" :disabled="selectedRows.length ? false : true">
                            <saet-icon name="ri-delete-bin-5-fill"></saet-icon>
                            <span class="title">删除</span>
                        </el-button>
                    </template>
                </el-popconfirm>
            </template>

            <el-button type="warning" class="op-btn" @click="expandAll" :class="{ 'is-expand': expandAllStatus }"
                v-if="fields.findIndex((item) => item.case == 'tree') > -1">
                <saet-icon name="arrowUp" class="no-twinkle"></saet-icon>
                <span class="title">{{ expandAllStatus ? '收起' : '展开' }}全部</span>
            </el-button>

            <slot name="table-operation-left"></slot>

            <div class="st-flex" style="flex: 1;">
            </div>



            <el-input v-if="config.fastSearch" v-model="fastSearchValue" placeholder="快速搜索"
                style="width: 150px;display: inline-block;" class="st-m-x-10" @keyup.enter.native="fastSearch">
            </el-input>

            <div style="position: relative;">
                <el-button-group>
                    <!-- 搜索按钮 -->
                    <el-button @click="config.search.visible = !config.search.visible" v-if="config.search">
                        <template #icon>
                            <saet-icon name="ri-search-line"></saet-icon>
                        </template>
                    </el-button>
                    <!-- 导出按钮 -->
                    <el-button v-if="!isset($slots['default'])">
                        <template #icon>
                            <saet-icon name="ri-file-excel-2-line"></saet-icon>
                        </template>
                    </el-button>
                    <!-- 表格字段 -->
                    <el-button v-if="!isset($slots['default'])" @click="changeFiledDopdown">
                        <template #icon>
                            <saet-icon name="grid"></saet-icon>
                        </template>
                    </el-button>
                </el-button-group>

                <!-- 下拉 -->
                <el-dropdown v-if="!isset($slots['default'])" ref="dropdownRef" :hide-on-click="false"
                    style=" position: absolute; right: 0px;z-index:-1;" trigger="contextmenu"
                    @visible-change="filedVisibleChange">
                    <div style="width: 46px;height: 32px;"></div>
                    <template #dropdown>
                        <el-dropdown-menu>
                            <el-dropdown-item v-for="v in fields">
                                <el-checkbox v-model="v.visible" :label="v.title" size="small">
                                </el-checkbox>
                            </el-dropdown-item>

                            <!-- <draggable v-model="fields" tag="el-dropdown-menu" item-key="title">
                                <template #item="{element}">
                                    <el-dropdown-item>
                                        <el-checkbox v-model="element.visible" :label="element.title" size="small">
                                        </el-checkbox>
                                    </el-dropdown-item>
                                </template>
                            </draggable> -->

                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </div>

            <slot name="table-operation-right"></slot>
        </div>

        <!-- <template v-for="(index, name) in $slots" :slot="name">
            {{name}}
        </template> -->

        <div class="custom-search" v-if="isset($slots['default'])">
            <slot name="adad"></slot>
        </div>

        <div class="custom-table" v-if="isset($slots['default'])">
            <slot :data="list" :loading="loading"></slot>
        </div>


        <el-table v-if="!isset($slots['default'])" ref="tableRef" v-loading="loading" :data="list"
            @mousewheel.stop="tableScrollChange" @select-all="selectClickAll" @selection-change="selectChange"
            @mouseleave="enableWindowScroll" @header-click="clickColumnHead" @mouseenter="disableWindowScroll"
            @expand-change="expandChange" style="width: 100%;border-radius: 8px;overflow: hidden;"
            :row-class-name="(e) => { return ['row_line_', e.row.isDelSuccess == true ? 'del-animation' : ''] }"
            table-layout="auto" header-row-class-name="header-row" v-bind="tableDefaultConfig" v-drag="dragOptions">

            <template v-for="e in fields">
                <el-table-column :prop="e.name" :label="e.title" align="center" v-if="e.visible" v-bind="e"
                    :class-name="'case-' + e.case">
                    <!-- 树形头 -->
                    <template v-if="e.case == 'tree'" #header="{ column, index }">
                        <el-button type="primary" size="small" @click="">
                            <saet-icon name="DCaret"></saet-icon>
                        </el-button>
                    </template>
                    <template #default="{ row, column, $index, expanded }">
                        <!-- 自定义插槽 -->
                        <slot :name="e.name" :row="row" :column="column" :index="$index" v-if="e.case == 'slot'">
                        </slot>
                        <!-- tree-btn -->
                        <template v-if="e.case == 'tree'">
                            <el-button :type="row.children ? 'primary' : 'info'" size="small" @click="expandRow([row])"
                                :disabled="!row.children" :class="{ 'is-expand': row._isExpand }">
                                <saet-icon name="ArrowUp" class="no-twinkle"></saet-icon>
                            </el-button>
                        </template>
                        <!-- 文本 -->
                        <template v-if="e.case == 'text'">
                            <div
                                v-html="e.customValue(row[e.name], row, $index) ?? e.placeholder ?? config.placeholder">
                            </div>
                        </template>
                        <!-- 图片 -->
                        <template v-if="e.case == 'image'">
                            <el-image :src="e.customValue(row[e.name], row, $index)"
                                :preview-src-list="[e.customValue(row[e.name], row, $index)]" fit="fill" :lazy="true"
                                preview-teleported>
                                <template #error>
                                    <div class="image-slot">
                                        <saet-icon name="Warning"></saet-icon>
                                    </div>
                                </template>
                            </el-image>
                        </template>
                        <!-- copy -->
                        <template v-if="e.case == 'copy'">
                            <el-input :value="e.customValue(row[e.name], row, $index)" placeholder="Copy value">
                                <template #append>
                                    <el-button icon="CopyDocument" @click="copyText(row[e.name])"></el-button>
                                </template>
                            </el-input>

                        </template>
                        <!-- switch -->
                        <template v-if="e.case == 'switch'">
                            <el-switch :loading="row['switch_loading_' + e.name]"
                                :value="e.customValue(row[e.name], row, $index)" v-bind="e.switchConfig"
                                :disabled="typeof e.switchConfig.disabled == 'boolean' ? e.switchConfig.disabled : e.switchConfig.disabled(row[e.name], row, $index)"
                                @click="changeSwitch(row[e.name], row, e.name, e.switchConfig)">
                            </el-switch>
                        </template>

                        <!-- operation button -->
                        <template v-if="e.case == 'operation' || e.case == 'button'">
                            <div>
                                <template v-if="e.case == 'operation'">
                                    <el-button icon="edit" type="primary" plain circle @click="editRow(row, e, index)">
                                    </el-button>
                                    <el-popconfirm title="确定删除当前项? " @confirm="delRow(row, e, index)">
                                        <template #reference>
                                            <el-button :icon="row.isDelSuccess ? 'select' : 'delete'"
                                                :type="row.isDelSuccess ? 'success' : 'danger'"
                                                :loading="row.delLoading" plain circle>
                                            </el-button>
                                        </template>
                                    </el-popconfirm>
                                    <el-button icon="rank" type="info" circle class="order-handle">
                                    </el-button>
                                </template>

                                <el-button v-for="b in e.buttons" v-bind="b" :title="b.title"
                                    @click="b.click(row, e, index)">{{
                                            b.title
                                    }}</el-button>

                            </div>
                        </template>
                        <!-- icon -->
                        <template v-if="e.case == 'icon'">
                            <saet-icon :name="row[e.name]" style="font-size:16px;"></saet-icon>
                        </template>
                    </template>
                </el-table-column>
                <!-- </template> -->
            </template>
        </el-table>
        <div class="st-m-t-10 st-flex justify-between align-center">
            <span class="total-num">共 {{ total }} 条</span>
            <el-pagination :current-page="config.page.current" :total="total" @size-change="sizeChange"
                @current-change="currentChange" hide-on-single-page v-bind="config.page">
            </el-pagination>
        </div>
    </div>
</template>
<script>

 SaetComponent(
    {
        name: 'saet-table',
        template: '#saet-table',
        props: {
            list: Array, fields: Array, config: { type: Object, default: {} }, total: 0, tableDefaultConfig: { type: Object, default: {} }
        },

        setup(props, context) {

            //全局配置
            let configDefault = {
                pk: 'id',
                apiUrl: {
                    index: ST.apiContUrl + '/index',
                    add: ST.apiContUrl + '/add',
                    edit: ST.apiContUrl + '/edit',
                    del: ST.apiContUrl + '/del',
                    switch: ST.apiContUrl + '/switch',
                },
                search: {
                    visible: false,
                    autocol: true
                }, //全搜索框
                fastSearch: true,  //快速搜索
                page: {
                    pageSize: ST.LIMIT ?? 12,
                    pageSizes: [12, 16, 20, 50, 100],
                    layout: 'sizes, prev, pager, next, jumper ',
                    small: false,
                    background: false,
                    current: 1
                },
                placeholder: '-',//占位符
            };
            const fieldDefault = {
                case: 'text',
                visible: true,       //显示
                search: {
                    type: 'text', exp: 'like'
                },
                customValue: (value, row, index) => {
                    return value
                },
                'min-width': 120
            }

            // p排序
            function compare(attr, rev) {
                if (rev == undefined) {
                    rev = 1;
                } else {
                    rev = (rev) ? 1 : -1;
                }
                return (a, b) => {
                    a = a[attr];
                    b = b[attr];
                    if (a < b) {
                        return rev * -1;
                    }
                    if (a > b) {
                        return rev * 1;
                    }
                    return 0;
                }
            }


            const config = Vue.computed(() => {
                let config1 = {}
                Object.keys(props.config).forEach((key) => {
                    config1[St.string(key).camelize().s] = props.config[key];
                })
                return reactive(St.deepAssign(configDefault, config1))
            })

            const searchCaseList = {
                text: { exp: 'like', placeholder: '模糊查询' },
                select: { exp: '=', placeholder: '精确查询' },
                selects: { exp: 'in', placeholder: '多选查询' },
                between: { exp: 'between', placeholder: ['开始', '结束'], startPlaceholder: '开始', endPlaceholder: '结束' },
                daterange: { exp: 'between time', desc: ['开始日期', '结束日期'], startPlaceholder: '开始日期', endPlaceholder: '结束日期', valueFormat: 'YYYY-MM-DD' },
                monthrange: { exp: 'between time', desc: ['开始月份', '结束月份'], startPlaceholder: '开始月份', endPlaceholder: '结束月份', valueFormat: 'YYYY-MM' },
                datetimerange: { exp: 'between time', desc: ['开始时间', '结束时间'], startPlaceholder: '开始时间', endPlaceholder: '结束时间', 'default-time': [new Date(2000, 1, 1, 0, 0, 0), new Date(2000, 1, 1, 23, 59, 59)], md: 12 },
                day: { exp: 'where_day', placeholder: '选择某一天', valueFormat: 'YYYY-MM-DD' },
                month: { exp: 'where_month', placeholder: '选择某一个月', valueFormat: 'YYYY-MM' },
                year: { exp: 'where_year', placeholder: '选择某一年', valueFormat: 'YYYY' },
                radio: { exp: '=' }
            }
            Object.keys(searchCaseList).forEach((key) => { searchCaseList[key] = St.deepAssign({ exp: 'like', md: 8 }, searchCaseList[key]) })

            // 编辑某一行
            const editRow = (row) => {
                console.log(row);
                St.window.open({
                    title: '编辑', url: only(config.value.apiUrl.edit, { [[config.value.pk]]: row[config.value.pk] })
                })
            };
            // 删除某一行
            const delRow = (row, item, index) => {
                row.delLoading = true
                St.axios.post(config.value.apiUrl.del, { [config.value.pk]: row[config.value.pk] }, { successToast: true }).then((res) => {
                    row.delLoading = false
                    row.isDelSuccess = true
                    setTimeout(() => {
                        // 修复树形index不正确
                        let index2 = list.value.findIndex((e) => e[config.value.pk] == row[config.value.pk])
                        if (index2 > -1 && index2 != index) {
                            index = index2
                        }
                        total.value -= 1
                        list.value.splice(index, 1)
                    }, 700);
                }).catch((err) => {
                    row.delLoading = false
                })
            }


            function getFields() {
                let caseDefault = {
                    expand: { title: '展开Btn', type: 'expand', search: false },
                    selection: { title: '选框Btn', type: 'selection', search: false },
                    tree: { title: '树形折叠Btn', width: '50', search: false },
                    switch: {
                        switchConfig: {
                            'inline-prompt': true,
                            'active-value': 1,
                            'inactive-value': 0,
                            isRemote: true,
                            disabled: () => {
                                return false
                            }
                        }
                    },
                    icon: { width: 60 },
                    operation: { title: '操作', 'min-width': 120, search: false }
                }

                let o = []
                for (let i = 0; i < props.fields.length; i++) {
                    let e = props.fields[i];
                    let caseConfig = fieldDefault
                    if (typeof caseDefault[e.case] != 'undefined') {
                        caseConfig = St.deepAssign(fieldDefault, caseDefault[e.case])
                    }
                    o[i] = St.deepAssign(caseConfig, e)
                }
                console.log(o);
                return o
            }
            const fields = reactive(getFields());


            // 表格搜索
            function getSearchList() {
                if (config.value.search === false) return false;
                let k = []
                for (let i = 0; i < fields.length; i++) {
                    if (fields[i].search === false) continue;
                    if (Array.isArray(fields[i].search)) {
                        for (let ii = 0; ii < fields[i].search.length; ii++) {
                            let x = fields[i].search[ii];
                            x = St.deepAssign(fieldDefault.search, searchCaseList[x.type], { title: fields[i].title, name: fields[i].name }, fields[i].search[ii]);
                            k.push(x)
                        }
                    } else {
                        k.push(St.deepAssign(searchCaseList[fields[i].search.type], { title: fields[i].title, name: fields[i].name }, fields[i].search))
                    }
                }
                let res = config.value.search.autocol ? k.sort(compare('md', true)) : k
                return res
            }
            const searchList = ref(getSearchList())
            Vue.watch(
                () => config.value.search,
                (n, o) => {
                    searchList.value = getSearchList();
                }, { deep: true, immediate: false }
            )
            const clearSearchValue = () => {
                for (let i = 0; i < searchList.value.length; i++) {
                    let e = searchList.value[i];
                    delete e.value
                }
            }
            const getSearchData = () => {
                let d = []
                for (let i = 0; i < searchList.value.length; i++) {
                    let e = searchList.value[i];
                    if (typeof (e.value) !== 'undefined' && e.value !== '') {
                        let value = e.value; if (e.exp == 'like') value = '%' + e.value + '%'
                        d.push({ name: e.name, value: value ?? e.value, exp: e.exp });
                    }
                }
                return d
            }


            const copyText = (text) => {
                St.copyText(text).then(() => {
                    St.message.success('复制成功')
                })
            }
            // 读取表格数据
            const loading = ref(false)
            const getList = () => {
                loading.value = true;
                St.axios.post(config.value.apiUrl.index, { search: getSearchData(), limit: config.value.page.pageSize, page: config.value.page.current, fast_value: fastSearchValue.value }).then((res) => {
                    list.value = res.list
                    total.value = res.total
                    loading.value = false
                }).catch((err) => {
                    loading.value = false
                })
            }
            const sizeChange = (s) => {
                config.value.page.pageSize = s
                config.value.page.current = 1
                getList()
            }

            const currentChange = (c) => {
                config.value.page.current = c
                getList()
            }


            const changeSwitch = (value, row, field, switchConfig) => {
                if (!switchConfig.isRemote) return;
                let new_value = switchConfig['active-value'] == value ? switchConfig['inactive-value'] : switchConfig['active-value'];
                row['switch_loading_' + field] = true;
                St.axios.post(config.value.apiUrl.switch, { [config.value.pk]: row[config.value.pk], [field]: new_value }, { successToast: true }).then((res) => {
                    if (res.row[field] == new_value) row[field] = new_value;
                    row['switch_loading_' + field] = false;
                }).catch((err) => {
                    row['switch_loading_' + field] = false;
                })
            }

            const total = ref(props.total)
            const list = ref(props.list)

            // 字段下拉
            const dropdownStatus = ref(false)
            const dropdownRef = ref()
            const changeFiledDopdown = () => {
                if (dropdownStatus.value) {
                    dropdownRef.value.handleClose()
                } else {
                    dropdownRef.value.handleOpen()
                }
            }
            const filedVisibleChange = (e) => {
                dropdownStatus.value = e
            }

            // 快速搜索
            const fastSearchValue = ref('');
            const fastSearch = (e, a, v) => {
                clearSearchValue()
                getList();
            }


            // 表格滑动
            var winY = null;
            window.addEventListener('scroll', function () {
                if (tableRef.value.$refs.scrollBarRef.$refs.wrap$.scrollWidth != tableRef.value.$refs.scrollBarRef.$refs.wrap$.clientWidth) {
                    if (winY !== null) {
                        window.scrollTo({ top: winY, behavior: 'instant' });
                    }
                }
            });
            function disableWindowScroll() {
                if (tableRef.value.$refs.scrollBarRef.$refs.wrap$.scrollWidth != tableRef.value.$refs.scrollBarRef.$refs.wrap$.clientWidth) {
                    winY = window.scrollY;
                }
            }
            function enableWindowScroll() {
                winY = null;
            }
            const tableRef = ref()
            const tableScrollChange = (e) => {
                if (tableRef.value.$refs.scrollBarRef.$refs.wrap$.scrollWidth != tableRef.value.$refs.scrollBarRef.$refs.wrap$.clientWidth) {
                    let eventDelta = 40;
                    if (e.deltaY < 0) {
                        eventDelta *= -1;
                    }
                    tableRef.value.$refs.scrollBarRef.setScrollLeft(tableRef.value.$refs.scrollBarRef.$refs.wrap$.scrollLeft + eventDelta)
                }
            }

            // 选择项操作
            const selectedRows = ref([])
            const selectedAllStatus = ref(false)
            const selectClickAll = (arr) => {
                selectedAllStatus.value = !selectedAllStatus.value
                // 取消全选
                if (!selectedAllStatus.value) {
                    tableRef.value.clearSelection()
                }
                // 全选
                if (selectedAllStatus.value) {
                    selectRow(arr)
                }
            }
            const selectRow = (arr) => {
                arr.forEach((row) => {
                    if (row.children) { selectRow(row.children) }
                    let have = tableRef.value.getSelectionRows().includes(row);
                    if (!have) tableRef.value.toggleRowSelection(row)
                })
            }
            const selectChange = (arr) => {
                selectedRows.value = arr
            }

            // 批量编辑
            const editBtnClicked = () => {
                for (let i = 0; i < tableRef.value.getSelectionRows().length; i++) {
                    const e = tableRef.value.getSelectionRows()[i];
                    St.window.open({
                        title: '编辑', url: only(config.apiUrl.edit, { [config.pk]: e[config.pk] })
                    })
                }
            }
            // 批量删除
            const delBtnClicked = () => {
                let delPks = []
                for (let i = 0; i < selectedRows.value.length; i++) {
                    const e = selectedRows.value[i];
                    if (e[config.pk] != undefined) {
                        delPks.push(e[config.pk])
                    }
                }
            }

            // 删除多个
            const delMany = () => {
                console.log(selectedRows.value);
            }


            let treeIndex = props.fields.findIndex((item) => item.case == 'tree')
            const isTreeTable = ref(treeIndex > -1 ? true : false)

            // 点击头部 递归展开
            const expandRow = (arr) => {
                arr.forEach((row) => {
                    if (row.children) { tableRef.value.toggleRowExpansion(row); }
                })
            }

            const expandAllStatus = ref(false)
            const expandAll = () => {
                expandAllStatus.value = !expandAllStatus.value;
                expandRowTree(props.list)
            }
            const expandRowTree = (arr) => {
                arr.forEach((row) => {
                    if (row.children) { tableRef.value.toggleRowExpansion(row, expandAllStatus.value); expandRowTree(row.children); }
                })
            }

            const expandChange = (row, expanded) => {
                row._isExpand = expanded
            }

            const clickColumnHead = (column) => {
                if (column.className == 'case-tree' || column.className.includes['case-tree']) {
                    props.list.forEach((row) => {
                        if (row.children) { tableRef.value.toggleRowExpansion(row); }
                    })
                }
            }


            const dragOptions = [
                {
                    selector: "tbody", // add drag support for row
                    option: {
                        handle: '.order-handle',
                        animation: 150,
                        onEnd: (e) => {
                            console.log('line', e);
                            // ElMessage.success(
                            //     `Drag the ${evt.oldIndex}th row to ${evt.newIndex}`
                            // );
                            // console.log(evt.oldIndex, evt.newIndex);
                        },
                    },
                },
            ];

            shallowCopy = function (obj) {
                // 只拷贝对象
                if (typeof obj !== 'object') return;
                // 根据obj的类型判断是新建一个数组还是一个对象
                var newObj = obj instanceof Array ? [] : {};
                // 遍历obj,并且判断是obj的属性才拷贝
                for (var key in obj) {
                    if (obj.hasOwnProperty(key)) {
                        newObj[key] = obj[key];
                    }
                }
                return newObj;
            }
            console.log('adadadada', {});
            const isset = (i) => {
                if (typeof i === 'undefined') {
                    return false
                }
                return true
            }

            return {
                isset, dragOptions, isTreeTable, expandAllStatus, expandAll, expandChange, expandRow, clickColumnHead, selectChange, delMany, editBtnClicked, selectedRows, selectClickAll, enableWindowScroll, disableWindowScroll, tableRef, tableScrollChange, fastSearchValue, fastSearch, editRow, delRow, loading, config, fields, searchList, total, list, getList, sizeChange, copyText, currentChange, changeSwitch, clearSearchValue, dropdownRef, changeFiledDopdown, filedVisibleChange
            }
        }
    }
)
</script>
<style>
/* 选择框 */
.saet-table .el-table .el-table-column--selection .cell {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* 树形表格下拉 */
.saet-table .el-table .case-tree .cell .el-button .el-icon,
.head .el-button .el-icon {
    transition: transform 300ms;
}

.saet-table .el-table .case-tree .cell .el-button.is-expand .el-icon,
.head .el-button.is-expand .el-icon {
    transform: rotate(180deg);
}

.saet-table .el-table .case-icon .cell {
    display: flex;
    justify-content: center;
    align-items: center;
}

.saet-table .el-table .el-table__cell:not(.el-table__expand-column) .el-table__expand-icon,
.saet-table .el-table .el-table__cell:not(.el-table__expand-column) .el-table__indent {
    display: none;
}

.saet-table .el-table .case-tree .cell .el-table__expand-icon {
    display: inline-flex;
    background: var(--el-color-primary);
    color: #fff;
    width: 30px;
    height: 30px;
    justify-content: center;
    align-items: center;
    border-radius: 3px;
}

.saet-table .cell .el-image {
    width: 36px;
    height: 36px;
    border-radius: 3px;
}

.saet-table .head {
    margin-bottom: 10px;
    flex-wrap: wrap;
    justify-content: space-around;
}

.saet-table .head>* {
    margin-top: 4px;
}

.saet-table .head .el-button.op-btn {
    padding: 8px 10px;
}

.saet-table .head .el-button.op-btn [class*=el-icon]+span {
    margin-left: 4px;
    font-size: 12px;
}

.saet-table .head .el-button+.el-button.op-btn {
    margin-left: 4px;
}

.saet-table .el-table {
    font-size: 13px;
}

.saet-table .search input,
.saet-table input {
    font-size: 12.2px;
}

.saet-table .search .el-form-item__label {
    font-size: 13px;
    width: 72px;
    justify-content: center;
    padding-right: 0px;
}

.saet-table .search .el-date-editor.el-input,
.el-date-editor.el-input__wrapper {
    width: 100%;
}

.saet-table .header-row {
    color: var(--el-text-color-primary);
}

.saet-table .case-image .el-image {
    line-height: 36px;
}

.saet-table .case-operation .el-button.is-circle span,
.saet-table .case-button .el-button.is-circle span {
    display: none;
}

/* 删除动画 */

.saet-table .el-table .el-table__row .el-table__cell {
    transition: all 200ms;
    transition-delay: 300ms;
}

.saet-table .el-table .el-table__row.del-animation .el-table__cell {
    padding: 0px;
}


@keyframes delRow {
    0% {
        height: 80px;
        opacity: 1;
    }

    100% {
        opacity: 0;
        height: 0px;
    }
}

.el-table .el-table__row.del-animation .cell {
    animation-delay: 300ms;
    animation-name: delRow;
    animation-duration: 400ms;
    animation-fill-mode: forwards;
}

/* 选择按钮+树形 */
.saet-table .el-table .cell .el-table__placeholder {
    display: none;
}

.saet-table .el-table .header-row .el-table__cell {
    padding: 10px 0;
}

.saet-table .total-num {
    color: var(--el-text-color-secondary);
}


.saet-table .el-table {
    border: 1px solid var(--el-table-border-color);
    border-bottom-width: 0px;
}

</style>
    