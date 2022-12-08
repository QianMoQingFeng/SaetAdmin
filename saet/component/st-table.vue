<template id="st-table">
    <div class="st-table">
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
                                    <!-- <el-select v-model="s.value" >
                                        <el-option v-for="item in s.list" :key="item.value" :label="item.label"
                                            :value="item.value" />
                                    </el-select> -->
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

            <el-button icon="refresh" class="st-m-r-8" circle :loading="loading" @click="getList">
            </el-button>

            <el-button type="primary" class="op-btn" v-if="config.left.includes('add')" @click="addBtnClicked">
                <saet-icon name="ri-add-fill" :size="16"></saet-icon>
                <span class="title">添加</span>
            </el-button>

            <template v-if="fields.findIndex((item) => item.case == 'selection') > -1">
                <el-button type="primary" class="op-btn" :disabled="selectedRows.length ? false : true"
                    v-if="config.left.includes('edit')" @click="editBtnClicked">
                    <saet-icon name="ri-pencil-fill"></saet-icon>
                    <span class="title">编辑</span>
                </el-button>
                <el-popconfirm :title="`确定删除选中的${selectedRows.length}项数据?`" @confirm="delMany()"
                    v-if="config.left.includes('del')">
                    <template #reference>
                        <el-button type="danger" class="op-btn" :disabled="selectedRows.length ? false : true">
                            <saet-icon name="ri-delete-bin-5-fill"></saet-icon>
                            <span class="title">删除</span>
                        </el-button>
                    </template>
                </el-popconfirm>
            </template>

            <el-button type="warning" class="op-btn" @click="expandAll"
                :class="{ 'is-expand': expandAllStatus } && config.left.includes('expand')"
                v-if="fields.findIndex((item) => item.case == 'tree') > -1">
                <saet-icon name="arrowUp" class="no-twinkle"></saet-icon>
                <span class="title">{{ expandAllStatus ? '收起' : '展开' }}全部</span>
            </el-button>

            <template v-for="name in config.left">
                <slot :name="'left-' + name"></slot>
            </template>

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
                        </el-dropdown-menu>
                    </template>
                </el-dropdown>
            </div>
            <template v-for="name in config.right">
                <slot :name="'right-' + name"></slot>
            </template>

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
            @mousewheel.stop="tableScrollChange" @select-all="selectClickAll" @select="selectItem"
            @mouseleave="enableWindowScroll" @header-click="clickColumnHead" @mouseenter="disableWindowScroll"
            @row-contextmenu="rowContextmenu" @current-change="rowCurrentChange"
            style="width: 100%;border-radius: 8px;overflow: hidden;" table-layout="auto"
            header-row-class-name="header-row" highlight-current-row v-bind="tableDefaultConfig" v-drag="dragOptions"
            v-menu="menuObject">
            <!-- v-menu="menuObject" -->

            <template v-for="e in fields">
                <el-table-column :prop="e.name" :label="e.title" align="center" v-if="e.visible" v-bind="e"
                    :class-name="'case-' + e.case">
                    <!-- Header -->
                    <!-- 树形头 -->
                    <template v-if="e.case == 'tree'" #header="{ column, index }">
                        <el-button type="primary" size="small" @click="">
                            <saet-icon name="DCaret"></saet-icon>
                        </el-button>
                    </template>

                    <template #default="{ row, column, $index, expanded }">
                        <!-- 自定义插槽 -->
                        <slot :name="e.name" :row="row" :column="column" :index="$index" v-if="(e.case == 'slot')">
                        </slot>
                        <slot name="_expand" :row="row" :column="column" :index="$index" v-if="(e.case == 'expand')">
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
                            <div v-html="getValue(row, e, $index) ?? e.placeholder ?? config.placeholder">
                            </div>
                        </template>

                        <!-- 图片 -->
                        <template v-if="e.case == 'image'">
                            <el-image :src="getValue(row, e, $index)" :preview-src-list="[getValue(row, e, $index)]"
                                fit="fill" :lazy="true" preview-teleported v-bind="e.bind_image">
                                <template #error>
                                    <div class="image-slot">
                                        <saet-icon name="Warning"></saet-icon>
                                    </div>
                                </template>
                            </el-image>
                        </template>

                        <!-- copy -->
                        <template v-if="e.case == 'copy'">
                            <el-input :value="getValue(row, e, $index)" placeholder="Copy value" v-bind="e.bind_input">
                                <template #append>
                                    <el-button icon="CopyDocument" @click="copyText(row[e.name])"></el-button>
                                </template>
                            </el-input>
                        </template>

                        <!-- switch -->
                        <template v-if="e.case == 'switch'">
                            <el-switch :loading="row['switch_loading_' + e.name]" :value="getValue(row, e, $index)"
                                v-bind="e.bind_switch"
                                :disabled="typeof e.bind_switch.disabled == 'boolean' ? e.bind_switch.disabled : e.bind_switch.disabled(row[e.name], row, $index)"
                                @click="changeSwitch(row[e.name], row, e.name, e.bind_switch)">
                            </el-switch>
                        </template>

                        <!-- tag -->
                        <template v-if="e.case == 'tag'">
                            <el-tag
                                :type="((e.keyValueType || { '1': 'success', '0': 'danger' })[row[e.name]] || (e.keyValueType?.['ELSE']))"
                                v-bind="e.bind_tag" v-text="getValue(row, e, $index)"></el-tag>
                        </template>

                        <!-- 排序 -->
                        <template v-if="e.case == 'order'">
                            <el-button icon="rank" type="info" circle class="order-handle" v-bind="e.bind">
                            </el-button>
                        </template>

                        <!-- icon -->
                        <template v-if="e.case == 'icon'">
                            <saet-icon :name="getValue(row, e, $index)" style="font-size:16px;"></saet-icon>
                        </template>

                        <!-- operation button -->
                        <template v-if="e.case == 'operation' || e.case == 'button'">
                            <!-- 下拉 -->
                            <el-dropdown :trigger="operateDropTrigger" :hide-on-click="operateDropHide"
                                v-if="e.buttons.length > 0 && e.style == 'dropmenu'" v-bind="e.config">
                                <el-button type="primary" plain>操作 <saet-icon name="arrow-down" class="st-m-l-6">
                                    </saet-icon>
                                </el-button>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <div v-for=" v in e.buttons" :ref="(el) => setOperateButtonRefs(el, $index, v)"
                                            @click="() => { tableRef.setCurrentRow(row), v.click(row, v, operateButtonRefs[v.name + $index]) }">
                                            <el-dropdown-item v-bind="v">{{ v.title }}
                                            </el-dropdown-item>
                                        </div>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>
                            <!-- 按钮操作 -->
                            <el-button-group v-if="e.style == 'buttongroup'">
                                <el-button v-for="v in e.buttons" v-bind="v"
                                    @click="() => { tableRef.setCurrentRow(row), v.click(row, v, operateButtonRefs[v.name + $index]) }"
                                    :ref="(el) => setOperateButtonRefs(el, $index, v)">{{
                                            v.title
                                    }}</el-button>
                            </el-button-group>
                            <!-- 按钮 -->
                            <el-button v-for="v in e.buttons" v-bind="v" v-if="e.style == 'button'"
                                @click="() => { tableRef.setCurrentRow(row), v.click(row, v, operateButtonRefs[v.name + $index]) }"
                                :ref="(el) => setOperateButtonRefs(el, $index, v)">{{
                                        v.title
                                }}</el-button>
                        </template>




                    </template>
                </el-table-column>
                <!-- </template> -->
            </template>
        </el-table>

        <!-- 右键菜单 -->
        <st-contextmenu ref="contextmenuRef" :menu="operateMenuList" @click-item="clickContextmenuItem"
            v-if="operateMenuList.length > 0 && fields.find((e) => e.case == 'operation')?.contextmenu">
        </st-contextmenu>

        <el-popconfirm title="确定删除当前项? " v-model:visible="deleteTipVisible" ref="deleteTipRef" placement="left"
            @confirm="delRow(currentRow)" @cancel="deleteTipVisible = false" virtual-triggering
            :virtual-ref="deleteButtonRef">
        </el-popconfirm>


        <div class="st-m-t-10 st-flex justify-between align-center">
            <span class="total-num">共 {{ total }} 条</span>
            <el-pagination :current-page="config.page.current" :total="total" @size-change="sizeChange"
                @current-change="pageCurrentChange" hide-on-single-page v-bind="config.page" v-if="config.page">
            </el-pagination>
        </div>

    </div>
</template>
{component is="st-contextmenu"/}
<script>
console.log(Object.values(document.styleSheets));
let remix = Object.values(document.styleSheets).find((item) => item.href.indexOf('remixicon') >= 0)
console.log(remix);
remix.cssRules.forEach(element => {

});
// setTimeout(() => {
//     console.log(Object.values(document.styleSheets).find((item) => item.href.indexOf('remix') >= -1));
// }, 0);
// console.log(document.styleSheets.find((a)=> a.href ==1));
// console.log(document.styleSheets.find((item) => item.href.indexOf('remix') >= -1));
SaetComponent(
    {
        name: 'st-table',
        template: '#st-table',
        props: {
            list: Array, fields: Array, config: { type: Object, default: {} }, total: 0, tableDefaultConfig: { type: Object, default: {} }, init: { default: false }
        },
        setup(props, context) {

            //全局配置
            let configDefault = {
                pk: 'id',
                apiUrl: {
                    index: ST.apiContUrl + '/index',
                    add: ST.apiContUrl + '/edit',
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
                left: [],
                right: [],
            };

            const fieldDefault = {
                case: 'text',
                visible: true,       //显示
                search: {
                    type: 'text', exp: 'like'
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
                select: { exp: 'in', placeholder: '精确查询' },
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
                St.window.open({
                    width: '65%', top: '10vh',
                    title: '编辑', url: only(config.value.apiUrl.edit, { [[config.value.pk]]: row[config.value.pk] })
                })
            };
            // 删除某一行
            const delRow = (row) => {

                let toast = St.message({
                    message: '正在删除，请稍等',
                    type: 'info',
                    showClose: false,
                    icon: 'loading',
                    customClass: 'is-loading',
                    duration: 0
                })

                deleteTipVisible.value = false

                St.axios.post(config.value.apiUrl.del, { [config.value.pk]: row[config.value.pk] }, { delayTime: 500 }).then((res) => {

                    setTimeout(() => {
                        // 修复树形index不正确
                        let index2 = list.value.findIndex((e) => e[config.value.pk] == row[config.value.pk])
                        if (index2 > -1 && index2 != currentRowIndex.value) index = currentRowIndex.value;
                        total.value -= 1
                        list.value.splice(currentRowIndex.value, 1)
                        toast.close()
                    }, 500);
                    // 删除动画

                    let currentDom = tableRef.value.$refs.tableWrapper.querySelector('.current-row')
                    currentDom.style = `--max-height: ${currentDom.offsetHeight}px;`
                    currentDom?.classList.add('del-animation')
                }).catch((err) => {
                    toast.close()
                })
            }

            // 初始化字段配置
            function getFields() {
                let caseDefault = {
                    expand: { type: 'expand', name: 'expand', search: false },
                    selection: { title: '选框Btn', type: 'selection', search: false },
                    tree: { title: '树形折叠Btn', width: '50', search: false },
                    switch: {
                        bind_switch: {
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
                    buttons: { title: '操作', 'min-width': 1, search: false, buttons: [], style: 'button', contextmenu: true, fixed: 'right' },
                    operation: { title: '操作', 'min-width': 1, search: false, buttons: [], style: 'dropmenu', contextmenu: true, fixed: 'right' }
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
                console.log(searchList.value);
                let d = []
                for (let i = 0; i < searchList.value.length; i++) {
                    let e = searchList.value[i];
                    if (typeof (e.value) !== 'undefined' && e.value !== '') {
                        let value = e.value; if (e.exp == 'like') value = '%' + e.value + '%'
                        d.push([e.name, value ?? e.value, e.exp]);
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
                St.axios.get(config.value.apiUrl.index, { params: { search: getSearchData(), limit: config.value.page.pageSize, page: config.value.page.current, fast_value: fastSearchValue.value } }).then((res) => {
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

            const pageCurrentChange = (c) => {
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

            const selectItem = (arr, row) => {
                selectedRows.value = arr
            }


            // 添加按钮
            const addBtnClicked = () => {
                St.window.open({
                    title: '添加', url: config.value.apiUrl.add
                })
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


            const isset = (i) => {
                return typeof i === 'undefined' ? false : true
            }

            // contextmenu 
            const contextmenuRef = ref(null)
            const currentRow = ref()
            const currentRowIndex = ref()

            const operateDropTrigger = ref('click')
            const operateDropHide = ref(false)

            const operateButtonRefs = ref({});
            const setOperateButtonRefs = (el, i, v) => {
                operateButtonRefs.value[v.name + i] = el
            };

            const menuObject = ref({
                ref: contextmenuRef, query: 'tbody tr', callback: (index, element, elements) => { }
            })

            // 编辑删除默认显示，权限不过关则显示，权限过关也可以控制隐藏，当所有buttons为空以及case == 'operation'为隐藏列
            const operateEdit = { name: 'edit', title: "编辑", icon: 'edit', type: 'primary', plain: true, circle: true, click: (row) => { editRow(row ?? currentRow.value) } }
            const operateDelete = {
                name: 'delete', title: "删除", icon: 'delete', type: 'danger', plain: true, circle: true, click: (row, item, clickRef) => {
                    if (deleteButtonRef.value != clickRef) {
                        deleteButtonRef.value = clickRef
                        deleteTipVisible.value = true
                    }
                }
            }
            const deleteButtonRef = ref()
            const deleteTipVisible = ref(false)
            const deleteTipRef = ref()

            let operation = fields.find((v) => v.case == 'operation')
            if (operation) {
                if (editButton = operation.buttons.find((t) => t.name == 'edit')) { editButton = St.deepAssign(operateEdit, editButton) } else {
                    // havebug 权限验证
                    operation.buttons.push(operateEdit)
                };
                if (delButton = operation.buttons.find((t) => t.name == 'delete')) { delButton = St.deepAssign(operateDelete, delButton) } else {
                    // havebug 权限验证
                    operation.buttons.push(operateDelete)
                };
            }


            const operateMenuList = ref(operation?.buttons ?? [])

            const clickContextmenuItem = (item, refItem) => {
                if (isset(item.click)) {
                    item.click(currentRow.value, item, refItem)
                }
            }

            const rowContextmenu = (row, column, event) => {
                tableRef.value.setCurrentRow(row)
                context.emit('rowContextmenu', row, column, event)
            }

            const rowCurrentChange = (row) => {
                currentRow.value = row;
                currentRowIndex.value = list.value.findIndex((i) => i == currentRow.value)
            }

            const getValue = (row, config, index) => {
                const name = config.name;
                let value = row[name]
                if (St.string(config.name).includes('.')) {
                    let arr = St.string(config.name).parseCSV('.', null);
                    value = St.copy(row)
                    for (let i = 0; i < arr.length; i++) {
                        const key = arr[i];
                        if (!value || typeof value[key] == 'undefined') break;
                        value = value[key]
                    }
                }
                // console.log(name,value);
                if (typeof config.customValue == 'function') return config.customValue(value, row, index, config)
                if (typeof config.keyValue == 'object' && (typeof config.keyValue[value] != 'undefined' || (typeof config.keyValue['ELSE'] != 'undefined' && value))) return config.keyValue[value] || config.keyValue['ELSE']
                if (typeof config.keyValue == 'object' && typeof config.keyValue['NULL'] != 'undefined' && !value) return config.keyValue['NULL']
                return value
            }

            if (props.init !== false) getList()
            return {
                addBtnClicked, getValue, rowCurrentChange, currentRowIndex, currentRow, operateDropTrigger, operateDropHide, operateButtonRefs, deleteTipVisible, setOperateButtonRefs, rowContextmenu, deleteButtonRef, deleteTipRef, clickContextmenuItem, operateMenuList, contextmenuRef, menuObject, isset, dragOptions, isTreeTable, expandAllStatus, expandAll, expandRow, clickColumnHead, selectItem, delMany, editBtnClicked, selectedRows, selectClickAll, enableWindowScroll, disableWindowScroll, tableRef, tableScrollChange, fastSearchValue, fastSearch, editRow, delRow, loading, config, fields, searchList, total, list, getList, sizeChange, copyText, pageCurrentChange, changeSwitch, clearSearchValue, dropdownRef, changeFiledDopdown, filedVisibleChange
            }
        }
    }
)
</script>
<style>
/* 选择框 */
.st-table .el-table .el-table-column--selection .cell {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* 树形表格下拉 */
.st-table .el-table .case-tree .cell .el-button .el-icon,
.head .el-button .el-icon {
    transition: transform 300ms;
}

.st-table .el-table .case-tree .cell .el-button.is-expand .el-icon,
.head .el-button.is-expand .el-icon {
    transform: rotate(180deg);
}

.st-table .el-table .case-icon .cell {
    display: flex;
    justify-content: center;
    align-items: center;
}

/* havebug */
.st-table .el-table .el-table__cell:not(.el-table__expand-column) .el-table__expand-icon,
.st-table .el-table .el-table__cell:not(.el-table__expand-column) .el-table__indent {
    /* display: none; */
    /* color: transparent; */
}

.st-table .el-table .case-tree .cell .el-table__expand-icon {
    display: inline-flex;
    background: var(--el-color-primary);
    color: #fff;
    width: 30px;
    height: 30px;
    justify-content: center;
    align-items: center;
    border-radius: 3px;
}

.st-table .cell .el-image {
    width: 36px;
    height: 36px;
    border-radius: 3px;
}

.st-table .head {
    margin-bottom: 10px;
    flex-wrap: wrap;
    justify-content: space-around;
}

.st-table .head>* {
    margin-top: 4px;
}

.st-table .head .el-button.op-btn {
    padding: 8px 10px;
}

.st-table .head .el-button.op-btn [class*=el-icon]+span {
    margin-left: 4px;
    font-size: 12px;
}

.st-table .head .el-button+.el-button.op-btn {
    margin-left: 4px;
}

.st-table .el-table {
    font-size: 13px;
}

.st-table .search input,
.st-table input {
    font-size: 12.2px;
}

.st-table .search .el-form-item__label {
    font-size: 13px;
    width: 72px;
    justify-content: center;
    padding-right: 0px;
}

.st-table .search .el-date-editor.el-input,
.el-date-editor.el-input__wrapper {
    width: 100%;
}

.st-table .header-row {
    color: var(--el-text-color-primary);
}

.st-table .case-image .el-image {
    line-height: 36px;
}

.st-table .case-operation .el-button.is-circle span,
.st-table .case-button .el-button.is-circle span {
    display: none;
}

/* 删除动画havebug */


.st-table .el-table .el-table__row.del-animation .el-table__cell {
    --del-time: 500ms;
    padding: 0px;
    transition: padding var(--del-time);
    transition-delay: 150ms;
}

@keyframes del-animation {
    0% {
        max-height: var(--max-height);
    }

    4% {
        opacity: 1;
    }

    100% {
        max-height: 0px;
        opacity: 0;
    }
}

.el-table .el-table__row.del-animation .cell {
    animation-delay: 150ms;
    animation-name: del-animation;
    animation-duration: var(--del-time);
    animation-fill-mode: forwards;
}


/* 选择按钮+树形 */
.st-table .el-table .cell .el-table__placeholder {
    display: none;
}

.st-table .el-table .header-row .el-table__cell {
    padding: 10px 0;
}

.st-table .total-num {
    color: var(--el-text-color-secondary);
}


.st-table .el-table {
    border: 1px solid var(--el-table-border-color);
    border-bottom-width: 0px;
}

/* 黑暗模式：表格操作固定栏  */
html.dark .el-table.is-scrolling-left .el-table-fixed-column--right.is-first-column::before {
    box-shadow: inset -10px 0 10px -8px rgb(50 50 50 / 50%);
}

html.dark [class*=" el-table-fixed-column--"] {
    --el-bg-color: var(--el-bg-color-page)
}
</style>
    