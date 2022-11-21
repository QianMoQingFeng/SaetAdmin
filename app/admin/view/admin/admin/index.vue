<template>
    <div>
        <st-table :list="ST.list" :total="ST.total" :fields="fields" :config="config">
        </st-table>
    </div>
</template>

<!-- 引入并注册组件 -->
{component is="st-table"/}

<script>
new SaetApp({
    setup() {
        // top.St.window.open({
        //     title: '编辑', url: 'http://192.168.1.13:66/admin.php'
        // })
        const fields = [
            { case: 'selection' },
            { name: 'aid', title: '管理员ID' },
            { name: 'username', title: '用户名' },
            { name: 'nick_name', title: '昵称' },
            { name: 'avatar', title: '头像', case: 'image', search: false },
            { name: 'email', title: '邮箱' },
            { name: 'mobile', title: '手机' },
            { name: 'create_time', title: '注册时间', search: [{ type: 'daterange' }, { type: 'monthrange' }, { type: 'datetimerange' }] },
            { name: 'online_time', title: '上线时间', search: [{ type: 'day' }, { type: 'year' }] },
            { case: 'operation' },
        ]
        const config = { pk: 'aid', search: true, page: { size: 1 } }
        return { fields, config }
    }
})
</script>