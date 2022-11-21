<template>
    <div class="st-m-b-40  st-flex justify-between" >
        <div>
            <el-button type="primary" plain @click="setCheckedNodes()">全选</el-button>
            <el-button @click="resetChecked()">清空</el-button>
        </div>
        <el-button @click="save()" :loading="saving" icon="select" type="primary">保存</el-button>
    </div>
    
    <el-tree ref="treeRef" :data="ST.rules" node-key="id" :props="{ label: 'title', class: 'is-penultimate' }"
        show-checkbox :default-checked-keys="defaultCheckedKeys" default-expand-all :expand-on-click-node="false"
        check-on-click-node>
    </el-tree>

</template>
<!-- current-node-key -->
<script>
new SaetApp({
    setup() {
        const treeRef = ref(null)
        const getCheckedKeys = () => {
            let ruleArr = treeRef.value.getCheckedKeys(false);
            return ruleArr.length > 0 ? St.string(ruleArr).toCSV(',', null).s : null;
        }

        const resetChecked = () => {
            treeRef.value.setCheckedKeys([], false)
        }

        const setCheckedNodes = () => {
            treeRef.value.setCheckedNodes(ST.rules, false)
        }

        const save = () => {
            console.log(getCheckedKeys());
            saving.value = true
            St.axios.post('', { rules: getCheckedKeys() }, { successToast: 1 }).then((e) => {
                saving.value = false
            })
        }
        const saving = ref(false)

        const defaultCheckedKeys = St.string(ST.group.rule_ids).parseCSV(',', null)

        return { defaultCheckedKeys, treeRef, getCheckedKeys, resetChecked, setCheckedNodes, save, saving }
    }
})
</script>
<style>


.el-tree-node.is-expanded>.el-tree-node__children {
    display: flex !important;
    flex-direction: row;
    flex-wrap: wrap;
}
</style>