<?php /*a:5:{s:76:"/media/psf/qianmokeji/SaetAdmin/saet.io/addons/edoc/admin/view/doc/index.vue";i:1666270308;s:36:"../app/admin/view/public/layout.html";i:1666663026;s:36:"../app/admin/view/public/header.html";i:1666258581;s:36:"../app/admin/view/public/assgin.html";i:1666258650;s:36:"../app/admin/view/public/script.html";i:1667032728;}*/ ?>
<!DOCTYPE html>
<html lang="cn" class="<?php echo htmlentities($adminTheme['theme']); ?> <?php echo htmlentities($adminTheme['color']); ?> ">

<head>
    <script>
    // ST = {'xxxx':'yyyy'}
    const ST = <?php echo json_encode($vars); ?>; 
    const __CONFIG__ = ST.__CONFIG__;
    // 防止编辑器格式化出错 
    console.log(__CONFIG__);
    // script 可以通过 ST.XXXXX使用 系统默认vue中 js部分可通过this.ST.xxxx 视图部分 ST.xxxx
    console.info('ST', ST);
</script>
    <script>

        let THEME = ST.adminTheme.theme
        const htmlDom = document.getElementsByTagName('html')[0]

        if (ST.adminTheme.theme == 'system') {
            THEME = window.matchMedia("(prefers-color-scheme: dark)").matches ? 'dark' : 'light';
            htmlDom.setAttribute('class', `${THEME} ${ST.adminTheme.color}`)
        }



    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width,height=device-height,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Document</title>
    <link rel="stylesheet" href="/static/saet/css/common.min.css?v=<?php echo time(); ?>">

    <script src="/static/package/vue/index.min.js"></script>
    <script src=" https://unpkg.com/vuex@4.0.0/dist/vuex.global.js"></script>
    <script src="/static/package/vue/component.js"></script>

    <script src="/static/package/element-plus/index.min.js"></script>
    <link rel="stylesheet" href="/static/package/element-plus/index.min.css">
    <link rel="stylesheet" href="/static/package/remixicon/remixicon.css">
    <script src="/static/package/axios/axios.min.js"></script>
    <script src="/static/package/string/string.min.js"></script>
    <script src="/static/package/element-plus/icon.js"></script>
    <script src="/static/saet/js/common.js?v=<?php echo time(); ?>"></script>
    <script src="/static/package/nprogress.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sortablejs@1.10.2/Sortable.min.js"></script>
    <script src="/static/package/draggable/vuedraggable.umd.min.js"></script>
    <link rel="stylesheet" href="/static/package/nprogress.css">

    <style>
        * {
            margin: 0px;
            -webkit-text-size-adjust: none;
        }



        @keyframes twinkle {
            0% {
                transform: scale(.8)
            }

            50% {
                transform: scale(1.1)
            }

            to {
                transform: scale(1)
            }
        }

        .el-icon svg {
            animation: twinkle 400ms ease-in-out;
        }

        .el-icon svg,
        .el-button:hover .el-icon {
            animation: twinkle 400ms ease-in-out;
        }

        .el-icon.no-twinkle svg,
        .el-button:hover .no-twinkle.el-icon {
            animation: none;
        }
    </style>

</head>

<style>
  html.dark {

    --el-bg-color: #161819;

    --el-text-color-primary: #dddddd;

    /* border */
    --el-border-color: #333333;

    /* input */

    --el-color-success: #62ba46;
    --el-color-success-light-3: #4e8e2f;
    --el-color-success-light-5: #3e6b27;
    --el-color-success-light-7: #2d481f;
    --el-color-success-light-8: #25371c;
    --el-color-success-light-9: #1c2518;
    --el-color-warning: #ffc726;
    --el-color-warning-light-3: #a77730;
    --el-color-warning-light-5: #7d5b28;
    --el-color-warning-light-7: #533f20;
    --el-color-warning-light-8: #3e301c;
    --el-color-warning-light-9: #292218;
    --el-color-danger: #f68219;
    --el-color-danger-light-3: #b25252;
    --el-color-danger-light-5: #854040;
    --el-color-danger-light-7: #582e2e;
    --el-color-danger-light-8: #412626;
    --el-color-danger-light-9: #2b1d1d;
    --el-color-error: #e0373e;
    --el-color-error-light-3: #b25252;
    --el-color-error-light-5: #854040;
    --el-color-error-light-7: #582e2e;
    --el-color-error-light-8: #412626;
    --el-color-error-light-9: #2b1d1d;
    --el-color-info: #909399;
    --el-color-info-light-3: #6b6d71;
    --el-color-info-light-5: #525457;
    --el-color-info-light-7: #393a3c;
    --el-color-info-light-8: #2d2d2f;
    --el-color-info-light-9: #202121;
    --el-color-info-dark-2: #a6a9ad;
    --el-box-shadow: 0px 12px 32px 4px rgba(0, 0, 0, .36), 0px 8px 20px rgba(0, 0, 0, .72);
    --el-box-shadow-light: 0px 0px 12px rgba(0, 0, 0, .72);
    --el-box-shadow-lighter: 0px 0px 6px rgba(0, 0, 0, .72);
    --el-box-shadow-dark: 0px 16px 48px 16px rgba(0, 0, 0, .72), 0px 12px 32px #000000, 0px 8px 16px -8px #000000;
    --el-bg-color-page: #202020;
    --el-bg-color: #161616;
    --el-bg-color-overlay: #1d1e1f;
    --el-text-color-primary: #E5EAF3;
    --el-text-color-regular: #CFD3DC;
    --el-text-color-secondary: #A3A6AD;
    --el-text-color-placeholder: #8D9095;
    --el-text-color-disabled: #6C6E72;
    --el-border-color-darker: #636466;
    --el-border-color-dark: #58585B;
    --el-border-color: #4C4D4F;
    --el-border-color-light: #414243;
    --el-border-color-lighter: #363637;
    --el-border-color-extra-light: #2B2B2C;
    --el-fill-color-darker: #424243;
    --el-fill-color-dark: #39393A;
    --el-fill-color: #303030;
    --el-fill-color-light: #262727;
    --el-fill-color-lighter: #1D1D1D;
    --el-fill-color-extra-light: #191919;
    --el-fill-color-blank: transparent;
    --el-mask-color: rgba(0, 0, 0, .8);
    --el-mask-color-extra-light: rgba(0, 0, 0, .3);

  }

  html,
  body {
    background-color: var(--el-bg-color-page);
    transition: background-color 300ms;
  }

  /* 兼容组件支持effect属性的夜间主题 */
  .is-dark.el-popover {
    --el-popover-title-text-color: var(--el-bg-color);
  }

  /* 兼容调试模式的夜晚模式 */
  html.dark .exception .source-code {
    background-color: var(--el-bg-color-page);
  }

  html.dark pre.prettyprint .pln {
    color: var(--el-color-info-light-3);
  }

  html.dark pre.prettyprint .kwd {
    color: var(--el-color-warning);
  }

  html.dark pre.prettyprint .line-error .pln {
    color: var(--el-bg-color);
  }

  html.dark body {
    color: var(--el-text-color-primary);
  }

  pages {
    display: flex;
    height: 100%;
  }


  @media only screen and (max-width: 767px) {
    .hidden-xs-only {
      display: none !important;
    }
  }

  @media only screen and (min-width: 768px) {
    .hidden-sm-and-up {
      display: none !important;
    }
  }

  @media only screen and (min-width: 768px) and (max-width: 991px) {
    .hidden-sm-only {
      display: none !important;
    }
  }

  @media only screen and (max-width: 991px) {
    .hidden-sm-and-down {
      display: none !important;
    }
  }

  @media only screen and (min-width: 992px) {
    .hidden-md-and-up {
      display: none !important;
    }
  }

  @media only screen and (min-width: 992px) and (max-width: 1199px) {
    .hidden-md-only {
      display: none !important;
    }
  }

  @media only screen and (max-width: 1199px) {
    .hidden-md-and-down {
      display: none !important;
    }
  }

  @media only screen and (min-width: 1200px) {
    .hidden-lg-and-up {
      display: none !important;
    }
  }

  @media only screen and (min-width: 1200px) and (max-width: 1919px) {
    .hidden-lg-only {
      display: none !important;
    }
  }

  @media only screen and (max-width: 1919px) {
    .hidden-lg-and-down {
      display: none !important;
    }
  }

  @media only screen and (min-width: 1920px) {
    .hidden-xl-only {
      display: none !important;
    }
  }


  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }

  ::-webkit-scrollbar-thumb {
    border-radius: 5px;
    background-color: var(--el-border-color-dark);
  }


</style>

<body>

  <div id="saetApp"></div>
  <div id="js-style"></div>
  <template>
    <saet-table :list="ST.list" :total="ST.total" :fields="fields">
       
    </saet-table>
</template>

<template id="saet-table">
    <div class="saet-table">
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
                <el-button type="primary" class="op-btn" :disabled="selectedRows.length?false:true"
                    @click="editBtnClicked">
                    <saet-icon name="ri-pencil-fill"></saet-icon>
                    <span class="title">编辑</span>
                </el-button>
                <el-popconfirm :title="`确定删除选中的${selectedRows.length}项数据?` " @confirm="delMany()">
                    <template #reference>
                        <el-button type="danger" class="op-btn" :disabled="selectedRows.length?false:true">
                            <saet-icon name="ri-delete-bin-5-fill"></saet-icon>
                            <span class="title">删除</span>
                        </el-button>
                    </template>
                </el-popconfirm>
            </template>

            <el-button type="warning" class="op-btn" @click="expandAll" :class="{'is-expand':expandAllStatus}"
                v-if="fields.findIndex((item) => item.case == 'tree') > -1">
                <saet-icon name="arrowUp" class="no-twinkle"></saet-icon>
                <span class="title">{{expandAllStatus?'收起':'展开'}}全部</span>
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
            :row-class-name="(e) => { return ['row_line_' , e.row.isDelSuccess == true ? 'del-animation' : ''] }"
            table-layout="auto" header-row-class-name="header-row" v-bind="tableDefaultConfig" v-drag="dragOptions">

            <template v-for="e in fields">
                <el-table-column :prop="e.name" :label="e.title" align="center" v-if="e.visible" v-bind="e"
                    :class-name="'case-' + e.case">
                    
                    <template v-if="e.case == 'tree'" #header="{ column, index }">
                        <el-button type="primary" size="small" @click="">
                            <saet-icon name="DCaret"></saet-icon>
                        </el-button>
                    </template>
                    <template #default="{ row, column ,$index ,expanded}">
                        
                        <slot :name="e.name" :row="row" :column="column" :index="$index" v-if="e.case == 'slot'">
                        </slot>
                        
                        <template v-if="e.case == 'tree'">
                            <el-button :type="row.children?'primary':'info'" size="small" @click="expandRow([row])"
                                :disabled="!row.children" :class="{'is-expand':row._isExpand}">
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
                            <el-switch :loading="row['switch_loading_'+e.name]"
                                :value="e.customValue(row[e.name], row, $index)" v-bind="e.switchConfig"
                                :disabled="typeof e.switchConfig.disabled == 'boolean' ? e.switchConfig.disabled: e.switchConfig.disabled(row[e.name], row, $index)"
                                @click="changeSwitch(row[e.name],row,e.name,e.switchConfig)">
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
                                    b.title }}</el-button>

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

new SaetComponent(
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
                St.copy(text).then(() => {
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
</script>

  
<template id="st-window">
    <div class="st-window">
        <div class="fixed-box" style="position: fixed;left:0px;bottom:0px;    z-index: 20000;">
            <el-tabs v-model="editableTabsValue" type="card" closable @tab-remove="close" @tab-click="tabRecovery">
                <template v-for="(e, key) in list">
                    <el-tab-pane :name="e.id" v-if="!e.visible && e.minimize">
                        <template #label>
                            <span class="">
                                <span class="st-m-r-10">{{  e.title  }}</span>
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
                            <span class="window-title">{{  e.title  }}</span>
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
<script>

new SaetComponent({
    name: 'st-window',
    template: '#st-window',
    created() {

    },
    setup() {

        const assign = {};
        const store = Vuex.useStore();

        assign.list = Vue.computed(() => {
            return store.state.W_LIST;
        });

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
    color:var(--el-text-color-regular);
}

.st-window .fixed-box .el-tabs__header {
    margin: 0;
}

/* .st-window .el-scrollbar__view{
    height: inherit;
}
.st-window .el-scrollbar__view>div{
    height: inherit; 
}*/
</style>
<script>


    // ceeat view
    const templatetDom = document.getElementsByTagName('template')
    const appDom = document.getElementById('saetApp')
    appDom.append(templatetDom[0].content.cloneNode(true))
    appDom.innerHTML += ' <st-window> </st-window>'

    if (self == top && ST.rule != 'index/index' && ST.rule != 'index/login') {
        let headDom = document.head || document.getElementsByTagName('head')[0]
        let style = document.createElement('style');
        style.appendChild(document.createTextNode('body{padding:15px;}'))
        headDom.appendChild(style)
    }


    /** 根地址模式
     * false-无根地址
     * admin-截止到admin.php/
     * addon-截止到admin.php/more_module@admin/访问非插件url时等效于root
     */
    St.axios.defaults.baseUrlType = 'addon';
    St.axios.interceptors.request.use((config) => {
        if (config.url == '') return config;
        if (config.baseUrlType == 'addon' && typeof (ST.apiBaseUrl) != 'undefined') {
            config.baseURL = ST.apiBaseUrl;
        }
        if (config.baseUrlType == 'root' && typeof (ST.apiRootUrl) != 'undefined') {
            config.baseURL = ST.apiRootUrl;
        }
        return config;
    });

    const only = (url, param) => {
        console.log(param);
        let i = St.string(url).contains('?');
        if (i) { url += '&self=1' } else { url += '?self=1' }
        if (param) {
            for (const key in param) {
                let value = param[key]
                url += `&${key}=${value}`
            }
        }
        return url;
    }

    if (typeof (Vue) != 'undefined') {
        const AppNo = {
            template: `<center style="margin-top:35vh;"></el-button><el-button type="error">{{message}}</el-button></center>`,
            data() {
                return {
                    message: "你引入了Vue，快开始创作你的页面吧！",
                };
            },
        };

        // directives: {
        //     drag: {
        //         mounted(el, binding) {
        //             console.log('自定义', el);
        //             console.log('自定义', binding);
        //             const options = binding.value;
        //             for (let oi = 0; oi < options.length; oi++) {
        //                 const o = options[oi];
        //                 new Sortable(el.querySelector(o.selector), o.option);
        //             }
        //         }
        //     }
        // },

        new SaetComponent(vuedraggable)

        const app = Vue.createApp(typeof (this.SaetPage) == 'undefined' ? AppNo : this.SaetPage);
        typeof (ElementPlus) != 'undefined' ? app.use(ElementPlus, { locale: ElementPlusLocaleZhCn }) : console.log('element-plus为必要拓展，请务必引入');
        if (typeof (this.SaetComponentList) != 'undefined') {
            for (const [key, component] of Object.entries(this.SaetComponentList)) {
                if (component.name) app.component(component.name, component)
            }
        }

        app.directive('drag', {
            mounted(el, binding) {
                const options = binding.value;
                for (let oi = 0; oi < options.length; oi++) {
                    const o = options[oi];
                    new Sortable(el.querySelector(o.selector), o.option);
                }
            }
        })

        for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
            app.component(key, component)
        }
        // created(){
        //     document.getElementById("saet-table").remove();
        // },
        for (const [key, component] of Object.entries(SaetAdminComponentVue)) {
            app.component(key, component)
        }

        // console.log(ST.defaultMenu.id);


        // ST.adminTheme
        if (window.innerWidth < 991) ST.adminTheme.menu.minimize = true
        const store = Vuex.createStore({
            state() {
                return {
                    adminTheme: reactive(ST.adminTheme),
                    W_LIST: [],
                    mainMenuId: ST.openMenu ? ST.openMenu.id : 0,
                    subMenuId: ST.openMenu ? ST.openMenu.id : 0,
                    tabActiveId: 0, openTabList: []
                }
            },
            mutations: {
                setStore(state, provider) {
                    let key = provider.key;
                    let data = provider.data;
                    let noStorage = provider.noStorage ? true : false;
                    state[key] = data;
                    if (noStorage == false) {
                        uni.setStorageSync(key, data);
                    } else {
                        console.log(key, '不缓存');
                    }
                },
            }
        })
        app.use(store)


        app.mixin({ data() { return { ST: ST } } })


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
                e = mergeProps(windowDefault, e);
                if (!e.id) e.id = store.state.W_LIST.length + 1
                if (!e.top) e.top = 'calc(15vh + ' + store.state.W_LIST.length * 40 + 'px)'
                let length = store.state.W_LIST.push(e);
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
                // html,body{background-color:unset;}
                // iframe.scrolling = 'no';



                iframe.onload = () => {
                    //去掉内容背景色
                    let iframeDoc = iframe.contentWindow.document;
                    let style = document.createElement('style');
                    style.appendChild(document.createTextNode('html,body{background-color:unset;}'))
                    iframeDoc.head.appendChild(style)

                    // // 监听高度变化
                    // let reizeHeight = new ResizeObserver(() => {
                    //     iframe.height = iframeBody.scrollHeight;
                    //     if (e.height < iframeBody.scrollHeight) {
                    //         iframe.height = iframeBody.scrollHeight;
                    //     }
                    // });
                    // reizeHeight.observe(iframeBody)

                    // iframe.height = iframeBody.scrollHeight;
                    // console.log('addddd', iframeBody);
                    // if (iframe.height > parseInt(e.height)) {
                    //     iframe.style = "width:calc(100% - 12px);"
                    // }
                    let d = e.delayTime - (new Date().getTime() - startTime)
                    if (d > 0) {
                        setTimeout(() => {
                            store.state.W_LIST[length - 1].loadEnd = true
                        }, d)
                    } else {
                        store.state.W_LIST[length - 1].loadEnd = true
                    }
                }
                console.log(store.state.W_LIST);
            }, edit(k, e) {
                store.state.W_LIST[k] = mergeProps(store.state.W_LIST[k], e);
            }, close(k) {
                store.state.W_LIST.splice(k, 1);
            }
        }

        St.window = windowTool


        app.mount("#saetApp");

        var templates = document.getElementsByTagName('template');
        for (let index = 0; index < templates.length; index++) {
            const element = templates[index];
            element.remove();
        }
    }
</script>
</body>

</html>