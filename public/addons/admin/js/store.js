

export const store = reactive({
    adminTheme: reactive(ST.adminTheme),
    W_LIST: [],
    mainMenuId: ST.openMenu ? ST.openMenu.id : 0,
    subMenuId: ST.openMenu ? ST.openMenu.id : 0,
    tabActiveId: 0, openTabList: []
})