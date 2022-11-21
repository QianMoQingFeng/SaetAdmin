<template>
    <div class="min-body">
        <div class="st-flex justify-center align-center st-m-y-20" style="overflow: hidden;">
            <img src="/static/saet/img/saetadmin.svg" class="toplogo svg-color" alt="SaetAdmin Logo" />
        </div>
        <div class="st-flex justify-center st-m-b-30">{:lang('How can we go far without sailing')} ✨</div>

        <div class="st-flex">
            <el-alert class="install-left" title="" type="info">
                <template #default>
                    <el-space :size="20" direction="vertical" fill style="height: 100%;">
                        <div class="st-m-t-20" style="font-weight:500;color: var(--el-text-color-primary);">
                            SaetAdmin {:lang('Development framework')}</div>
                        <div> SaetAdmin {:lang('is a service development framework inclined to automation (SAET)')} ^-^ </div>
                        <div>SaetAdmin {:lang('is still adhering to the principle of letting users')}<span style="color:red;">S</span>imple <span style="color:red;">a</span>nd
                            <span style="color:red;">e</span>legan<span style="color:red;">t</span> {:lang('to develop')}
                        </div>
                        <div> {:lang('Version')}：{{ ST.version }}</div>
                        <div class="line"> <span> {:lang('Doc')}：</span>
                            <el-link class="light-color" style="font-size:12px;font-weight: normal;" target="_blank"
                                href="//admin-doc.saet.io" :underline="false">http://saet.io</el-link>
                        </div>
                        <div class="line"> <span> {:lang('WebSite')}：</span>
                            <el-link class="light-color" style="font-size:12px;font-weight: normal;" target="_blank"
                                href="//admin.doc.saet.io" :underline="false">http://admin-doc.saet.io</el-link>
                        </div>
                        <el-link class="copyright" href="//QianMoKeJi.cn" target="_blank" :underline="false">SaetAdmin©
                            2022
                            By QianMoKeJi.cn
                        </el-link>
                    </el-space>
                </template>
            </el-alert>

            <el-space direction="vertical" style="width:100%;" fill>
                <el-steps :active="stepCur" simple finish-status="success">
                    <el-step title="{:lang('check')}" :icon="stepCur > 0 ? 'select' : stepCur == 0 ? 'edit' : 'none'"></el-step>
                    <el-step title="{:lang('install')}" :icon="stepCur > 1 ? 'select' : stepCur == 1 ? 'edit' : 'none'"></el-step>
                    <el-step title="{:lang('complete')}" icon="none"></el-step>
                </el-steps>


                <template v-if="stepCur == 0">
                    <el-table :data="checkData" border style="width: 100%;border-radius:8px;overflow: hidden;">
                        <el-table-column prop="app" label="{:lang('app')}"></el-table-column>
                        <el-table-column prop="version_keep" label="{:lang('version need')}"></el-table-column>
                        <el-table-column prop="version" label="{:lang('now version')}"></el-table-column>
                        <el-table-column prop="status" label="{:lang('status')}" fixed="right" width="90px">
                            <template #default="{ row }">
                                <template v-if="row.status == 'yes'">
                                    <saet-icon name="ri-checkbox-circle-fill" style="color:var(--el-color-success)"
                                        :size="16"> </saet-icon>
                                    <span class="text"> {:lang('pass')}</span>
                                </template>
                                <template v-if="row.status == 'fail'">
                                    <saet-icon name="ri-close-circle-fill" style="color:var(--el-color-error)"
                                        :size="16">
                                    </saet-icon>
                                    <span class="text"> {:lang('mismatch')}</span>
                                </template>
                                <template v-if="row.status == 'wait'">
                                    <saet-icon name="ri-information-fill" style="color:var(--el-color-warning)"
                                        :size="16">
                                    </saet-icon>
                                    <span class="text"> {:lang('wait check')}</span>
                                </template>
                            </template>
                        </el-table-column>

                    </el-table>

                    <el-form ref="formRef" :model="form" label-width="90px" :label-position="position" :rules="rules">
                        <div class="title">{:lang('database information')}</div>
                        <el-form-item label="地址/端口" required prop="hostname">
                            <el-row :gutter="10" style="flex:1">
                                <el-col :span="13">
                                    <el-input v-model="form.hostname" placeholder="ip地址"
                                        @input="checkData[1].status = 'wait'"></el-input>
                                </el-col>
                                <el-col :span="11">
                                    <el-form-item prop="hostport">
                                        <el-input v-model="form.hostport" placeholder="数据库端口"
                                            @input="checkData[1].status = 'wait'"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form-item>

                        <el-form-item label="账户/密码" required prop="username">
                            <el-row :gutter="10" style="flex:1">
                                <el-col :span="13">
                                    <el-input v-model="form.username" placeholder="数据库账号"
                                        @input="checkData[1].status = 'wait'"></el-input>
                                </el-col>
                                <el-col :span="11">
                                    <el-form-item label="" required prop="password">
                                        <el-input v-model="form.password" placeholder="数据库密码"
                                            @input="checkData[1].status = 'wait'"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form-item>

                        <el-form-item label="库名/前缀" required prop="database">
                            <el-row :gutter="10" style="flex:1">
                                <el-col :span="13">
                                    <el-input v-model="form.database" placeholder="数据库名"
                                        @input="checkData[1].status = 'wait'"></el-input>
                                </el-col>
                                <el-col :span="11">
                                    <el-form-item prop="prefix">
                                        <el-input v-model="form.prefix" placeholder="数据库前缀"></el-input>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form-item>
                    </el-form>

                    <div class="st-flex">
                        <el-button type="warning" :loading="checkIng" @click="check(formRef)" style="flex:1;">
                            {{ checkIng ? '检验中...' : '核验数据库信息' }}</el-button>
                        <el-button type="primary" :disabled="checkStatus" @click="stepCur = 1" style="width: 100px;">下一步
                        </el-button>
                    </div>

                </template>

                <template v-if="stepCur == 1">
                    <el-form ref="formRef" :model="form" label-width="90px" :label-position="position" :rules="rules">

                        <div class="title">
                            站点信息
                        </div>

                        <el-form-item label="站点标题" prop="site_title">

                            <el-input v-model="form.site_title" placeholder="站点标题"></el-input>
                        </el-form-item>
                        <el-form-item label="超管账号" required prop="admin_username">
                            <el-input v-model="form.admin_username" placeholder="管理员账号"></el-input>
                        </el-form-item>
                        <el-form-item label="账号密码" required prop="admin_password">
                            <el-input v-model="form.admin_password" placeholder="管理员密码"></el-input>
                        </el-form-item>
                        <el-form-item label="重复密码" required prop="admin_password2">
                            <el-input v-model="form.admin_password2" placeholder="重复密码"></el-input>
                        </el-form-item>
                        <el-form-item label="定义入口">
                            <div class="st-flex" style="flex: 1;">
                                <el-input v-model="form.entry_file" placeholder="默认admin">
                                    <template #append>.php</template>
                                </el-input>
                                <el-button class="st-m-l-10" type="primary" plain @click="buildRandom" icon="refresh">
                                </el-button>
                            </div>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" :loading="installIng" @click="install(formRef)">{{ installIng ?
                                    '安装中....' :
                                    '开始安装'
                            }}
                            </el-button>
                            <el-button type="info" plain @click="stepCur = 0">返回</el-button>
                        </el-form-item>
                    </el-form>
                </template>

                <template v-if="stepCur == 2">
                    <div class="st-flex-col justify-center align-center st-m-t-40">
                        <saet-icon name="CircleCheck" :size="160" color="var(--el-color-success)"></saet-icon>
                        <span class="st-m-t-12">{{ St.string(form.username).capitalize().toString() }} ，安装成功 ^-^</span>
                        <div style="max-width: 500px;display: flex;flex-direction: column;width: 100%;">
                            <el-input :value="entry_url" class="st-m-y-20">
                                <template #append>
                                    <el-button icon="CopyDocument"
                                        @click="St.copyText(entry_url).then(St.message.success('复制成功'))">
                                    </el-button>
                                </template>
                            </el-input>
                            <div class="st-flex justify-between">
                                <el-button type="primary" size="default" icon="house" @click="go('')">去首页</el-button>
                                <el-button type="primary" size="default" icon="right" @click="go(entry_url)">前往后台
                                </el-button>
                                <el-button type="primary" size="default" icon="setting"
                                    @click="go(entry_url + '/config/index')">配置更多</el-button>
                            </div>
                        </div>
                    </div>
                </template>
            </el-space>
        </div>

    </div>
</template>
<script>

SaetApp({
    setup() {
        const stepCur = ref(0)
        const installIng = ref(false)
        const install = async (formEl) => {
            if (!formEl) return
            await formEl.validate((valid) => {
                if (valid) {
                    installIng.value = true
                    form.value.type = 'install'
                    St.axios.post('install.html', form.value, { successToast: true }).then((res) => {
                        installIng.value = false;
                        stepCur.value = 2
                    }).catch((err) => {
                        installIng.value = false;
                    });
                }
            })
        }

        const rules = reactive({
            hostname: { required: true, message: '请填写数据库IP', trigger: 'blur' },
            hostport: { required: true, message: '请填写数据库端口', trigger: 'blur' },
            database: { required: true, message: '请填写数据库名称', trigger: 'blur' },
            username: { required: true, message: '请填写数据库账号', trigger: 'blur' },
            password: { required: true, message: '请填写数据库密码', trigger: 'blur' },
            admin_username: { required: true, message: '请填写管理员账号', trigger: 'blur' },
            admin_password: { required: true, message: '请填写密码', trigger: 'blur' },
            admin_password2: { required: true, message: '两次输入密码不匹配', trigger: 'blur', validator: () => { return form.value.admin_password == form.value.admin_password2 } },
        })

        const formRef = ref();
        const checkIng = ref(false)

        const checkStatus = Vue.computed(() => {
            return checkData.value.find((item) => item.status != 'yes') ? true : false
        })

        const check = async (formEl) => {
            if (!formEl) return
            await formEl.validate((valid) => {
                if (valid) {
                    checkIng.value = true;
                    form.value.type = 'check'
                    St.axios.post('install.html', form.value, { successToast: true }).then((res) => {
                        checkIng.value = false;
                        checkData.value[1].version = res.version
                        checkData.value[1].status = 'yes'
                    }).catch((err) => {
                        if (err.data && err.data.version) {
                            checkData.value[1].version = err.data.version + '(过低)'
                            checkData.value[1].status = 'fail'
                        }
                        checkIng.value = false;
                    });
                }
            })
        }

        const form = ref({
            prefix: 'st_',
            hostport: '3306',
            hostname: 'localhost',
            // username: 'admin'
        })

        const position = ref('left')

        if (window.innerWidth < 500) position.value = 'top'

        const buildRandom = () => {
            form.value.entry_file = St.string('Letter+number').random(10, true)
        }

        const checkData = ref([{
            app: 'php',
            version_keep: '>= 7.4',
            version: '{$Think.PHP_VERSION}',
            status: St.string('{$Think.PHP_VERSION}').toInt() >= 7.4 ? 'yes' : 'fail'
        },
        {
            app: 'mysql',
            version_keep: '>= 5.7',
            version: '{:lang("wait check")}',
            status: 'wait'
        },
        {
            app: '{:lang("file right")}',
            version_keep: '>= 0755',
            version: ST.file_auth,
            status: ST.file_auth >= 0755 ? 'yes' : 'fail'
        }
        ])

        const entry_url = Vue.computed(() => {
            return window.location.origin + '/' + (form.value.entry_file ?? 'admin') + '.php'
        });

        const go = (u) => window.location.href = u;
        return { go, entry_url, stepCur, install, installIng, form, check, checkIng, position, formRef, rules, buildRandom, checkData, checkStatus }
    }
})

</script>
<style>
.title {
    padding: 20px 0;
    color: var(--el-text-color-secondary);
}

.cell {
    display: flex;
    align-items: center;
}

.cell .el-icon {
    margin-right: 5px;
}

.cell .text {
    font-size: 12px;
}

.el-steps--simple {
    background-color: var(--el-bg-color-page);
}

.el-step__head.is-success,
.el-step__title.is-success {
    color: var(--el-text-color-secondary);
}

.toplogo {
    width: 300px;
}

.el-alert {
    --el-alert-bg-color: var(--el-bg-color);
}

.svg-color {
    --svg-color: var(--el-color-primary);
    transform: translateX(-100vw);
    filter: drop-shadow(var(--svg-color) 100vw 0);
}

.install-left {
    display: flex;
    flex-direction: row;
    min-width: 200px;
    width: 200px;
    margin-right: 14px;
    padding: 10px;
}

.install-left .line {
    display: flex;
    align-items: center;
}

.light-color {
    color: var(--el-text-color-placeholder);
}

.copyright {
    font-size: 12px;
    color: var(--el-text-color-placeholder);
    position: absolute;
    bottom: 20px;
}

@media only screen and (max-width: 768px) {
    .install-left {
        display: none;
    }
}


@media only screen and (max-width: 500px) {
    .toplogo {
        width: 76% !important;
    }
}

.min-body {
    max-width: 900px;
    padding: 0 12px;
    margin: auto;
}

.el-alert__content {
    height: 100%;
    overflow: hidden;
    padding: 0 2px;
}
</style>