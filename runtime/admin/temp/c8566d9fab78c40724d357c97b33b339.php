<?php /*a:3:{s:71:"/media/psf/qianmokeji/SaetAdmin/saet.io/app/admin/view/config/index.vue";i:1667999342;s:36:"../app/admin/view/public/layout.html";i:1668688293;s:36:"../app/admin/view/public/assgin.html";i:1667877771;}*/ ?>
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
  
  <vue><template>
    <div>
        <el-tabs type="border-card" v-model="defaultName">
            <el-tab-pane label="刷新" name="refresh" disabled>
                <template #label>
                    <el-button icon="refresh" size="small" circle @click="refresh" :loading="refreshIng"></el-button>
                </template>
            </el-tab-pane>
            <el-tab-pane :label="title" :name="name" v-for="(title, name) in groupList">
                <el-alert title="⚠️ 注意，请谨慎修改" type="warning" :closable="false" v-if="name == 'admin_theme'">
                    <template #default>
                        主题相关设置请点击，右上角 <img src="/static/saet/img/theme.png" style="width: 20px;height: 20px;"
                            alt="主题设置" />
                        图标设置，下方仅用于开发者调试全局默认配置
                    </template>
                </el-alert>
                <st-config :list="configList[name]" :url="ST.apiContUrl + '/edit_value'" @edit="edit"
                    :is-operation="true" @success="refresh()"></st-config>
            </el-tab-pane>
            <el-tab-pane label="添加" name="addConfig">
                <template #label>
                    <el-tag type="info" size="normal" effect="plain" @close="">
                        <saet-icon name="plus"></saet-icon>
                    </el-tag>
                </template>
                <st-config :list="addConfig" :url="ST.apiContUrl + '/add'" @success="addConfigSuccess()"
                    ref="addConfigRef" :is-Back="false"></st-config>
            </el-tab-pane>
        </el-tabs>
    </div>

    <el-dialog v-model="editShow" :title="'修改`' + editRow.title + '`配置项'">
        <st-config :list="editConfig" :url="ST.apiContUrl + '/edit'" @success="addConfigSuccess()" ref="editConfigRef"
            :is-Back="false"></st-config>
    </el-dialog>
</template>


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
</style><template id="st-array">
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
 SaetComponent({
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
</script><template id="st-json">
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
 SaetComponent({
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
</script><template id="st-image-upload">
    <el-upload v-drag="dragOptions" v-model:file-list="fileList"
        action="http://10.211.55.6:66/admin.php/index/upload?_self=1" list-type="picture-card"
        :on-preview="handlePictureCardPreview" :on-exceed="handleExceed" multiple drag v-bind="config">
        <el-icon>
            <Plus />
        </el-icon>
    </el-upload>
    <el-image :initial-index="previewList.findIndex((item) => item == previewUrl)"
        style="width:0px;height:0px;display: block;" :src="previewUrl" id="st-image-upload-preview"
        :preview-src-list="previewList" preview-teleported></el-image>
</template>
<script>
 SaetComponent({
    name: 'st-image-upload',
    template: '#st-image-upload',
    props: { modelValue: [Array, String], resType: { type: String, default: 'string' }, config: { type: Object, default: {} } },
    setup(props, context) {
        let dom = '<style>.el-upload-list,.el-upload--picture-card{--el-upload-list-picture-card-size:80px !important;--el-upload-picture-card-size:80px !important;}</style>'
        document.getElementById('js-style').innerHTML += dom;

        Vue.defineEmits(['update:modelValue'])

        const dragOptions = [
            {
                selector: ".el-upload-list", // add drag support for row
                option: {
                    handle: '.el-upload-list__item',
                    animation: 150,
                    onEnd: (e) => {
                        let old = previewList.value[e.oldIndex].concat()
                        let new1 = previewList.value[e.newIndex].concat()
                        previewList.value[e.oldIndex] = new1
                        previewList.value[e.newIndex] = old
                    },
                },
            },
        ];

        const fileList = ref([])


        Vue.watch(
            () => props.modelValue,
            (n, o) => {
                if (props.modelValue && typeof (props.modelValue) == 'string') {
                    let list = St.string(props.modelValue).parseCSV(',', null)
                    let c = []
                    for (const url of list) {
                        c.push({ url: url })
                    }
                    fileList.value = c
                }
                if (!props.modelValue) {
                    fileList.value = []
                }
            }, { deep: true, immediate: true }
        )


        const handlePictureCardPreview = (e) => {
            previewUrl.value = e.response ? e.response.data : e.url
            setTimeout(() => {
                document.getElementById('st-image-upload-preview').click();
            }, 0);
        }
        const previewUrl = ref('')
        const previewList = ref([])
        Vue.watch(
            () => fileList.value,
            (n, o) => {
                let r = []
                for (let index = 0; index < fileList.value.length; index++) {
                    let e = fileList.value[index];
                    if (e.response) {
                        r.push(e.response.data)
                    } else {
                        r.push(e.url)
                    }
                }
                previewList.value = r
            }, { deep: true, immediate: true }
        )

        Vue.watch(
            () => previewList.value,
            (n, o) => {
                context.emit('update:modelValue', n.length > 0 ? (props.resType == 'string' ? St.string(n).toCSV(',', null).s : n) : '')
            }, { deep: true, immediate: false }
        )

        const handleExceed = (files, uploadFiles) => {
            St.message.warning(
                ` 最多只能上传 ${props.config.limit} 张`
            )
        }
        return { dragOptions, handlePictureCardPreview, previewUrl, previewList, fileList, handleExceed }
    }
})
</script>
<style>
.el-upload-dragger {
    width: calc(var(--el-upload-picture-card-size)-2px);
    height: 100%;
    padding: 0px !important;
    border: none !important;
    background-color: transparent;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<script type="module">
new SaetApp({
    setup() {
        const groupList = ref(ST.groupList);
        const configList = ref(ST.configList);
        const defaultName = ref(Object.keys(groupList.value)[0])

        const typeList = {
            'text': '文本',
            'long-text': '长文本',
            'image': '图片',
            'array': '一维数组',
            'json': '键值对',
            'select': '下拉单选',
            'radio': '单选框'
        }

        const addConfig = ref([
            { name: 'group', title: '分组', type: 'select', option: groupList.value },
            { name: 'name', title: '键名', type: 'text' },
            { name: 'title', title: '名称', type: 'text' },
            { name: 'type', title: '类型', type: 'select', option: typeList, value: Object.keys(typeList)[0] },
            { name: 'option', title: '预选值', type: 'json', visible: false },
            { name: 'value', title: '默认值', type: 'text' },
        ])


        const valueType = Vue.computed(() => {
            return addConfig.value.find((item) => item.name == 'type')['value']
        })


        Vue.watch(
            () => valueType,
            (n, o) => {
                let i = addConfig.value.findIndex((item) => item.name == 'value')
                if (n.value != o.value) addConfig.value[i].value = null;
                addConfig.value[i].type = n.value
                let i2 = addConfig.value.findIndex((item) => item.name == 'option')
                if (n.value == 'select' || n.value == 'radio') {
                    addConfig.value[i2].visible = true
                } else {
                    addConfig.value[i2].visible = false
                }
            }, { deep: true, immediate: false }
        )


        const optionValue = Vue.computed(() => {
            return addConfig.value.find((item) => item.name == 'option')['value']
        })

        Vue.watch(
            () => optionValue,
            (n, o) => {
                let i = addConfig.value.findIndex((item) => item.name == 'value')
                addConfig.value[i].option = n.value ? JSON.parse(n.value) : ''
            }, { deep: true, immediate: true }
        )

        const refreshIng = ref(false)
        const refresh = () => {
            refreshIng.value = true
            St.axios.get('').then((res) => {
                refreshIng.value = false
                groupList.value = res.groupList
                configList.value = res.configList
                addConfig.value = addConfig.value
                let groupIndex = addConfig.value.findIndex((item) => item.name == 'group')
                addConfig.value[groupIndex].option = groupList.value
            }).catch(() => {
                refreshIng.value = false
            })
        }

        const addConfigRef = ref()
        const addConfigSuccess = () => {
            refresh()
            addConfigRef.value.reset()
        }

        const editShow = ref(false)
        const editRow = ref([])
        const editConfig = ref(St.copy(addConfig.value))
        const edit = (row) => {
            editConfig.value.forEach((e, i) => {
                editConfig.value[i].value = row[e.name]
            });
            editShow.value = true
            editRow.value = row
        }


        return { defaultName, addConfig, refresh, refreshIng, groupList, configList, addConfigRef, edit, editRow, editShow, addConfigSuccess, editConfig }
    }
})


</script>
<style>
.el-tabs--border-card {
    border-radius: 5px;
}

.el-tabs--border-card>.el-tabs__header {
    border-radius: 5px 5px 0 0;
}


.config-item {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid var(--el-fill-color-light);
}

.config-item .title {
    width: 120px;
    padding-left: 10px;
    color: var(--el-text-color-secondary);
    font-size: 14px;
    font-weight: 500;
}

.config-item .content {
    display: flex;
    width: 500px;
}
</style>




</vue>

  
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