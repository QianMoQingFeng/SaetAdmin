<template id="st-contextmenu">
    <el-popover v-model:visible="visible" @show="show" ref="popoverRef" trigger="contextmenu" :show-arrow="false"
        :popper-options="{
            modifiers: [
                {
                    name: 'offset',
                    options: {
                        offset: [offsetX, -5],
                    },
                },
            ],
        }" :hide-after="100" v-bind="config"
        :popper-class="'st-contextmenu-popper ' + (typeof (config['popperClass']) == 'undefined' ? '' : config['popperClass'])"
        :width="width">
        <slot name="default"></slot>
        <!-- $slots['default'] -->
        <div class="st-flex-col st-p-y-6">
            <template v-for="(v, i) in menu">
                <div class="st-contextmenu-item" @click="$emit('clickItem', v, clickRefs[i])"
                    :ref="(el) => setRefs(el, $index, v)">
                    <saet-icon :size="14" :name="v.icon">
                    </saet-icon><span class="title">{{ v.title }}</span>
                </div>
            </template>
        </div>

        <template #reference>
            <div class="trigger" style="z-index:1000"></div>
        </template>
    </el-popover>
</template>
    
<script>


SaetComponent({
    name: 'st-contextmenu',
    template: '#st-contextmenu',
    props: { config: { type: Object, default: {} }, width: { type: Number, default: 120 }, menu: Array },
    setup() {
        const popoverRef = ref(null)
        const visible = ref(false)
        const offsetX = ref(0)
        const open = (n) => { visible.value = true; offsetX.value = n; }
        const close = () => visible.value = false;
        const show = () => {
            popoverRef.value.popperRef.contentRef.oncontextmenu = () => { return false }
        }
        const clickRefs = ref([])

        const setRefs = (el) => {
            if (el) {
                clickRefs.value.push(el)
            }
        }
        return { show, offsetX, popoverRef, visible, open, close, setRefs, clickRefs }
    }
})


</script>
<style>
.st-contextmenu-popper {
    min-width: auto !important;
}

.st-contextmenu-popper {
    --el-popover-padding: 0;
}

.st-contextmenu-item {
    padding: 0px 12px;
    cursor: pointer;
    height: 32px;
    display: flex;
    flex-direction: row;
    align-items: center;
}

.st-contextmenu-item:hover {
    background-color: var(--el-fill-color-light);
    color: var(--el-color-primary)
}

.st-contextmenu-item .title {
    margin-left: 8px;
    font-size: 13px;
}
</style>