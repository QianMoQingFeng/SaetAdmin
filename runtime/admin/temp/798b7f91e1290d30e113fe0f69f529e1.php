<?php /*a:3:{s:76:"/media/psf/qianmokeji/SaetAdmin/saet.io/addons/edoc/admin/view/doc/index.vue";i:1667745915;s:36:"../app/admin/view/public/layout.html";i:1668688293;s:36:"../app/admin/view/public/assgin.html";i:1667877771;}*/ ?>
<!DOCTYPE html>
<html lang="cn" class="<?php echo htmlentities($adminTheme['theme']); ?> <?php echo htmlentities($adminTheme['color']); ?> ">

<head>

  <script>
    // ST = {'xxxx':'yyyy'}
    const ST = <?php echo json_encode($vars); ?>; 
    const CONFIG = ST.CONFIG;
    // 防止编辑器格式化出错 
    console.log('CONFIG',CONFIG);
    // script 可以通过 ST.XXXXX使用 系统默认vue中 js部分可通过this.ST.xxxx 视图部分 ST.xxxx
    console.info('ST', ST);
</script>

  <script>
    let THEME = ST.adminTheme.theme
    const htmlDom = document.getElementsByTagName('html')[0]


    // 主题是否通用
    if (ST.adminTheme.theme == 'system') {
      THEME = window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
      htmlDom.setAttribute('class', `${THEME} ${ST.adminTheme.color}`)
    }

  </script>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport"
    content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

  <title>SaetAdmin</title>

  <script>const LANG = {};</script>
  <script src="<?php echo LANG_URL; ?>"></script>

  <script src="/static/package/axios/axios.min.js"></script><script src="/static/package/nprogress/nprogress.min.js"></script><link rel="stylesheet" href="/static/package/nprogress/nprogress.min.css"><script src="/static/package/sortable/sortable.min.js"></script><script src="/static/package/vue/vue.global.prod.js"></script><script src="/static/package/element-plus/index.full.min.js"></script><script src="/static/package/element-plus/icon.min.js"></script><link rel="stylesheet" href="/static/package/element-plus/index.min.css"><link rel="stylesheet" href="/static/package/element-plus/dark.min.css"><script src="/static/package/element-plus/locale/zh-cn.min.js"></script><script src="/static/package/string/string.min.js"></script><script src="/static/saet/js/common.min.js"></script><link rel="stylesheet" href="/static/saet/css/common.min.css"><link rel="stylesheet" href="/static/package/remixicon/remixicon.css">

  <script src="/static/package/draggable/vuedraggable.umd.min.js"></script>




</head>

<body>
  <div id="saetApp"></div>
  <div id="js-style"></div>
  
  <vue>
<template>
    <st-table :list="ST.list" :total="ST.total" :fields="fields">
       
    </st-table>
</template>

<template id="st-table">
    <div class="st-table">
        <el-collapse-transition v-if="config.search">
            <div v-if="config.search.visible" class="search">
                <el-row>
                    <template v-for="s in searchList">
                        <el-col :lg="s.lg ?? 6" :md="s.md ?? 8" :sm="s.sm ?? 12" :xs="s.xs ?? 24">
                            <el-form-item :label="s.title">
                                
                                <template v-if="s.type == 'text'">
                                    <el-input v-model="s.value" v-bind="s"></el-input>
                                </template>
                                
                                <template v-if="s.type == 'select'">
                                </template>
                                
                                <template v-if="s.type == 'day' || s.type == 'month' || s.type == 'year'">
                                    <el-date-picker v-model="s.value" v-bind="s"></el-date-picker>
                                </template>
                                
                                <template
                                    v-if="s.type == 'daterange' || s.type == 'monthrange' || s.type == 'datetimerange'">
                                    <el-date-picker v-model="s.value" v-bind="s"></el-date-picker>
                                </template>
                                
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
        
        <div class="head st-flex ">
            
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
                    
                    <el-button @click="config.search.visible = !config.search.visible" v-if="config.search">
                        <template #icon>
                            <saet-icon name="ri-search-line"></saet-icon>
                        </template>
                    </el-button>
                    
                    <el-button v-if="!isset($slots['default'])">
                        <template #icon>
                            <saet-icon name="ri-file-excel-2-line"></saet-icon>
                        </template>
                    </el-button>
                    
                    <el-button v-if="!isset($slots['default'])" @click="changeFiledDopdown">
                        <template #icon>
                            <saet-icon name="grid"></saet-icon>
                        </template>
                    </el-button>
                </el-button-group>

                
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

            <slot name="table-operation-right"></slot>
        </div>

        

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
                    
                    <template v-if="e.case == 'tree'" #header="{ column, index }">
                        <el-button type="primary" size="small" @click="">
                            <saet-icon name="DCaret"></saet-icon>
                        </el-button>
                    </template>
                    <template #default="{ row, column, $index, expanded }">
                        
                        <slot :name="e.name" :row="row" :column="column" :index="$index" v-if="e.case == 'slot'">
                        </slot>
                        
                        <template v-if="e.case == 'tree'">
                            <el-button :type="row.children ? 'primary' : 'info'" size="small" @click="expandRow([row])"
                                :disabled="!row.children" :class="{ 'is-expand': row._isExpand }">
                                <saet-icon name="ArrowUp" class="no-twinkle"></saet-icon>
                            </el-button>
                        </template>
                        
                        <template v-if="e.case == 'text'">
                            <div
                                v-html="e.customValue(row[e.name], row, $index) ?? e.placeholder ?? config.placeholder">
                            </div>
                        </template>
                        
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
                        
                        <template v-if="e.case == 'copy'">
                            <el-input :value="e.customValue(row[e.name], row, $index)" placeholder="Copy value">
                                <template #append>
                                    <el-button icon="CopyDocument" @click="copyText(row[e.name])"></el-button>
                                </template>
                            </el-input>
                        </template>
                        
                        <template v-if="e.case == 'switch'">
                            <el-switch :loading="row['switch_loading_' + e.name]"
                                :value="e.customValue(row[e.name], row, $index)" v-bind="e.switchConfig"
                                :disabled="typeof e.switchConfig.disabled == 'boolean' ? e.switchConfig.disabled : e.switchConfig.disabled(row[e.name], row, $index)"
                                @click="changeSwitch(row[e.name], row, e.name, e.switchConfig)">
                            </el-switch>
                        </template>

                        
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
                        
                        <template v-if="e.case == 'icon'">
                            <saet-icon :name="row[e.name]" style="font-size:16px;"></saet-icon>
                        </template>
                    </template>
                </el-table-column>
                
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
        name: 'st-table',
        template: '#st-table',
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

.st-table .el-table .el-table__cell:not(.el-table__expand-column) .el-table__expand-icon,
.st-table .el-table .el-table__cell:not(.el-table__expand-column) .el-table__indent {
    display: none;
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

/* 删除动画 */

.st-table .el-table .el-table__row .el-table__cell {
    transition: all 200ms;
    transition-delay: 300ms;
}

.st-table .el-table .el-table__row.del-animation .el-table__cell {
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

</style>
    

<script>
new SaetApp({
    data() {
        return {
            fields: [
                { case: 'selection' },
                { name: 'id', title: 'id' },
                {
                    name: 'title', title: '名称'
                },
                {
                    name: 'diyname', title: '地址', case: 'copy', customValue(value, row) {
                        if (row.group) return `/edoc/${row.group.name}/${value ?? row.id}`;
                    }
                },
                { name: 'weight', title: '权重' },
                { case: 'operation' },
            ]
        }
    }
})
</script></vue>

  
<template id="st-window">
    <div class="st-window">
        <div class="fixed-box" style="position: fixed;left:0px;bottom:0px;    z-index: 20000;">
            <el-tabs v-model="editableTabsValue" type="card" closable @tab-remove="close" @tab-click="tabRecovery">
                <template v-for="(e, key) in list">
                    <el-tab-pane :name="e.id" v-if="!e.visible && e.minimize">
                        <template #label>
                            <span class="">
                                <span class="st-m-r-10">{{ e.title }}</span>
                                <saet-icon name="ri-picture-in-picture-line"></saet-icon>
                            </span>
                        </template>
                    </el-tab-pane>
                </template>
            </el-tabs>
        </div>
        <template v-for="(e, key) in list">
            <div>
                
                
                <el-dialog v-model="e.visible" width="600px" v-bind="e" :show-close="false"
                    :custom-class="'window-box ' + (e.fullscreenAnimation ? 'fullscreen-animation ' : '') + e.customClass"
                    @closed="closed(key, e)" :style="{ color: '#333', fontSize: '14px' }" @opened="opened">
                    <template #header>
                        <div class="st-flex align-center">
                            <span class="window-title">{{ e.title }}</span>
                            <saet-icon class="is-loading" name="loading"
                                v-if="!e.loadEnd && (e.loadType == 'tip' || e.loadType == 'all') && e.url">
                            </saet-icon>
                            <div style=" flex: 1;">
                            </div>
                            <el-button icon="ArrowLeftBold" circle v-if="isLast(key, e)"></el-button>
                            <el-button icon="ArrowRightBold" circle v-if="isLast(key, e)" class="st-m-r-12"></el-button>

                            <div class="st-dots" v-if="e.showClose || e.showMinimize || e.showMaximize">
                                <div class="color-dot error" @click="close(key, true)" v-if="e.showClose">
                                    <saet-icon name="ri-close-line"></saet-icon>
                                </div>
                                <div class="color-dot warning" @click="minimize(key)" v-if="e.showMinimize">
                                    <saet-icon name="ri-subtract-fill"></saet-icon>
                                </div>
                                <div class="color-dot success" :class="{ 'is-fullscreen': e.fullscreen }"
                                    v-if="e.showMaximize" @click="changFullscreen(key, e.fullscreen)">
                                    <saet-icon class="left" name="ri-arrow-up-s-fill"></saet-icon>
                                    <saet-icon class="right" name="ri-arrow-up-s-fill"></saet-icon>
                                </div>
                            </div>
                        </div>
                    </template>

                    
                    <div :id="'iframe-box-' + e.id" class="iframe-box"></div>
                    
                </el-dialog>
            </div>
        </template>
    </div>
</template>
<script type="module">
import { store } from '/app_static/admin/js/store.js'

const windowDefault = {
    title: 'Saet',
    fullscreen: false,
    visible: true,
    draggable: true,
    customClass: '',
    fullscreenAnimation: true,
    delayTime: 600,
    loadEnd: false,
    loadType: 'all',//full tip
    height: '400px',
    width: '50%',
    top: '12vh',
    modal: false,
    showClose: true,
    showMinimize: true,
    showMaximize: true,
    closeOnClickModal: false, closeOnPressEscape: false
}

const windowTool = {
    open: (e) => {
        e = Vue.mergeProps(windowDefault, e);
        if (!e.id) e.id = store.W_LIST.length + 1
        if (!e.top) e.top = 'calc(15vh + ' + store.W_LIST.length * 40 + 'px)'
        let length = store.W_LIST.push(e);
        var startTime = new Date().getTime();
        setTimeout(() => {
            let iframeBox = document.getElementById('iframe-box-' + e.id);
            iframeBox.appendChild(iframe)
        }, 10);

        let iframe = document.createElement('iframe');
        iframe.src = e.url;
        iframe.width = '100%';
        iframe.id = 'iframe-' + e.id;
        iframe.height = e.height;
        iframe.onload = () => {
            //去掉内容背景色
            let iframeDoc = iframe.contentWindow.document;
            let style = document.createElement('style');
            style.appendChild(document.createTextNode('html,body{background-color:unset;}'))
            iframeDoc.head.appendChild(style)
            let d = e.delayTime - (new Date().getTime() - startTime)
            if (d > 0) {
                setTimeout(() => {
                    store.W_LIST[length - 1].loadEnd = true
                }, d)
            } else {
                store.W_LIST[length - 1].loadEnd = true
            }
        }
    }, edit(k, e) {
        store.W_LIST[k] = Vue.mergeProps(store.W_LIST[k], e);
    }, close(k) {
        store.W_LIST.splice(k, 1);
    }
}

St.window = windowTool
 SaetComponent({
    name: 'st-window',
    template: '#st-window',
    setup() {
        const assign = {};
        assign.list = ref(store.W_LIST);
        assign.changFullscreen = (k, s) => {
            St.window.edit(k, { fullscreen: !s })
        }
        assign.close = (k, is_key) => {
            if (is_key !== true) k = assign.list.value.findIndex((item) => item.id == k);
            if (assign.list.value[k].visible == false) return St.window.close(k);
            St.window.edit(k, { visible: false })
        }
        assign.minimize = (k) => {
            St.window.edit(k, { visible: false, minimize: true })
        }
        assign.recovery = (k) => {
            St.window.edit(k, { visible: true, minimize: false })
        }
        assign.tabRecovery = (e) => {
            let k = assign.list.value.findIndex((item) => item.id == e.props.name)
            St.window.edit(k, { visible: true, minimize: false })
        }

        assign.closed = (k, e) => {
            if (!e.minimize) {
                St.window.close(k)
            }
        }
        assign.dialogVisible = true
        assign.isLast = (k, e) => {
            return false
        }
        assign.opened = (e) => {
            return false
        }
        return assign
    },
})

</script>
<style>
.st-window {}

.st-window .window-box .el-dialog__header {
    margin-right: 0px !important;
}

.st-window .window-box {
    border-radius: 5px;
}

.st-window .window-box.is-fullscreen {
    border-radius: 0px;
    height: 100vh;
    display: flex;
    flex-direction: column;
}

.st-window .window-box.fullscreen-animation {
    transition-property: width, margin;
    transition-duration: 150ms;
}

.st-window .window-box .el-dialog__body {
    --el-dialog-padding-primary: 12px;
    padding: var(--el-dialog-padding-primary);
}

.st-window .window-box.is-fullscreen .el-dialog__body {
    height: calc(100vh - 86.5px);
}

.st-window .iframe-box {
    display: flex;
}

.st-window .iframe-box>iframe {
    border: none;
    transition: all 300ms;
}

.st-window .window-title {
    margin-right: 10px;
    color: var(--el-text-color-regular);
}

.st-window .fixed-box .el-tabs__header {
    margin: 0;
}

</style>

  <script type="module">

    useSaetVue()

    if (self == top && ST.rule != 'index/index' && ST.rule != 'index/login' && ST.rule != '') {
      let headDom = document.head || document.getElementsByTagName('head')[0]
      let style = document.createElement('style');
      style.appendChild(document.createTextNode('body{padding:15px;}'))
      headDom.appendChild(style)
    }

    // iframe 父级 主题切换
    window.addEventListener('message', function (e) {  // 监听 message 事件
      htmlDom.setAttribute('class', `${e.data.theme} ${e.data.color}`)
    });

    // 单窗口主动切换
    if (ST.adminTheme.theme == 'system') {
      window.matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', event => {
          if (event.matches) {
            htmlDom.setAttribute('class', `dark ${ST.adminTheme.color}`)
          } else {
            htmlDom.setAttribute('class', `light ${ST.adminTheme.color}`)
          }
        })
    }


  </script>



</body>

</html>