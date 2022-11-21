<template>
    <div>
        <st-table ref="saetTable" :list="ST.list" :total="ST.total" :fields="fields" :config="config">
            <template #table-operation-left>
                <el-button>导入插件</el-button>
                <el-button plain class="st-m-l-10">
                    <el-radio-group v-model="source">
                        <el-radio label="local" size="small">已安装插件</el-radio>
                        <el-radio label="appstore" size="small">插件商店</el-radio>
                        <el-radio label="appstore-mine" size="small">我的插件</el-radio>
                    </el-radio-group>
                </el-button>
            </template>

            <template #default="{data,loading}">
                <el-row :gutter="20" class="addon-list" v-loading="loading" v-if="data.length">
                    <el-col :lg="6" :md="8" :sm="12" :xs="24" v-for="row in data">

                        <div class="item">
                            <div class="top">
                                <el-image class="logo"
                                    src="https://ecmb.bdimg.com/kmarketingadslogo/327c77f2512faf01c9430d70a4eeabae_259_194.png">
                                </el-image>
                                <div style="flex:1;">
                                    <div class="st-flex justify-between">
                                        <span class="title" @click="showDetail(row)">{{row.title}} </span>
                                        <!-- <span class="version">{{row.version}}</span> -->
                                        <div style="position: relative;">
                                            <el-tag effect="light" size="small" type="info">版本 {{row.version}}</el-tag>
                                            <div class="have-update">
                                                <i class="ri-arrow-up-circle-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="description">{{row.description}}</div>
                                </div>
                            </div>
                            <div class="st-m-t-10">
                                <el-button>配置</el-button>
                                <el-button>安装</el-button>
                                <el-button>详情</el-button>
                            </div>

                        </div>
                    </el-col>
                </el-row>
                <el-empty description="暂无插件" v-else></el-empty>
            </template>
        </st-table>

        <el-drawer v-if="detailContent" v-model="detailShow" title="详情" direction="btt" size="80%"
            :before-close="handleClose">
            <div class="detail-panel">
                <div class="st-flex align-center st-p-b-20">
                    <el-image class="logo st-m-r-20"
                        src="https://ecmb.bdimg.com/kmarketingadslogo/327c77f2512faf01c9430d70a4eeabae_259_194.png">
                    </el-image>
                    <div class="info">
                        <div class="title">{{detailContent.title}}</div>
                        <div class="description">{{detailContent.description}}</div>
                        <div style="flex:1;"></div>
                        <div>
                            <el-tag effect="dark" size="large" type="primary" round style="padding: 0 20px;">免费</el-tag>
                        </div>
                    </div>
                </div>
                <div class="param">
                    <div class="item">
                        <div class="label">1231个评分</div>
                        <div class="value">4.9</div>
                        <div class="desc">
                            <el-rate size="small" :model-value="3" clearable disabled></el-rate>
                        </div>
                    </div>
                    <div class="devide"></div>
                    <div class="item">
                        <div class="label">开发者</div>
                        <div class="value"><i class="ri-shield-user-line"></i></div>
                        <div class="desc">阡陌欺负</div>
                    </div>
                    <div class="devide"></div>
                    <div class="item">
                        <div class="label">大小</div>
                        <div class="value">123.2</div>
                        <div class="desc">MB</div>
                    </div>
                    <div class="devide"></div>
                    <div class="item">
                        <div class="label">版本</div>
                        <div class="value">{{detailContent.version}}</div>
                        <div class="desc">1 次更新</div>
                    </div>
                </div>
            </div>
        </el-drawer>



    </div>
</template>

{component is="st-table"/}

<script>
new SaetApp({
    setup() {
        const fields = [
            { name: 'title', title: '名称' },
            { name: 'name', title: '别名' },
            { name: 'author', title: '作者' },
            { name: 'version', title: '版本' },
        ]
        const source = ref('local')

        const config = reactive({ fastSearch: false, search: false })

        Vue.watch(
            () => source.value,
            (n, o) => {
                console.log('n', n);
                if (n == 'local') {
                    config.fastSearch = false
                    config.search = false
                }
                if (n == 'appstore' || n == 'appstore-mine') {
                    config.fastSearch = true
                    delete config.search
                }
                saetTable.value.getList()
            }, { deep: true, immediate: false }
        )

        const saetTable = ref();

        const detailContent = ref();
        const detailShow = ref(false);
        const showDetail = (row) => {
            detailContent.value = row
            detailShow.value = true
        }
        return { fields, source, config, saetTable, detailContent, detailShow, showDetail }
    }
})
</script>
<style>
.addon-list .item {
    background-color: var(--el-bg-color);
    padding: 14px;
    border-radius: 5px;
    margin-bottom: 10px;
}

.addon-list .item .top {
    display: flex;
    flex-direction: row;
}

.addon-list .item .logo {
    width: 70px;
    height: 70px;
    border-radius: 6px;
    margin-right: 10px;
}

.addon-list .item .title {
    position: relative;
    color: var(--el-text-color-regular);
    font-size: 14px;
    font-weight: 500;
}

.addon-list .item .description {
    color: var(--el-text-color-secondary);
    font-size: 13px;
}

@media only screen and (min-width: 900px) {
    .detail-panel {
        max-width: 900px;
        margin: auto;
    }
}

.detail-panel {}

.detail-panel .info {
    height: 100px;
    display: flex;
    flex-direction: column;
}

.detail-panel .logo {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    margin-left: 10px;
}

.detail-panel .title {
    color: var(--el-text-color-primary);
    font-size: 24px;
    font-weight: 700;
}

.detail-panel .description {
    color: var(--el-text-color-secondary);
    font-size: 16px;
}

.detail-panel .param {
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    border-top: 1px solid var(--el-border-color-light);
    padding: 20px 0;
}

.detail-panel .param .item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    height: 75px;
}

.detail-panel .param .devide {
    content: '';
    width: .8px;
    height: 50px;
    background: var(--el-border-color-light);
}

.detail-panel .param .label {
    font-size: 12px;
    font-weight: 500;
    color: var(--el-text-color-placeholder);
}

.detail-panel .param .value {
    font-size: 24px;
    font-weight: 700;
    color: var(--el-text-color-secondary);
}

.detail-panel .param .desc {
    font-size: 12px;
    color: var(--el-text-color-secondary);
}

.el-rate {
    --el-rate-icon-margin: 0px;
}

.have-update {
    position: absolute;
    right: 0;
    top: 0;
    transform: translate(60%, -30%);
    color: var(--el-color-error);
    font-size: 20px;

}
.have-update [class^="ri-"]{
    background-color: #fff;
    border-radius: 20px;
}
</style>