/*! js-cookie v3.0.1 | MIT12 */

const St = {};

window.SaetComponentList = [];
window.SaetPage = {}


console.log('Vue', Vue.version);
console.log('ElementPlus', ElementPlus.version);

function SaetApp(o) { window.SaetPage = o }
const SaetComponent = o => window.SaetComponentList.push(o);

const ref = Vue.ref;
const reactive = Vue.reactive;
const lang = (k) => {
  if (typeof (CONFIG.lang) == 'undefined' || typeof (LANG[CONFIG.lang][k]) == 'undefined') return k;
  return LANG[CONFIG.lang][k];
}

// ceeat view
// 注册saet vue
const useSaetVue = (isClearTemp) => {
  const templatetDom = document.getElementsByTagName('template')
  const appDom = document.getElementById('saetApp')
  appDom.append(templatetDom[0].content.cloneNode(true))
  appDom.innerHTML += ' <st-window> </st-window>'
  if (typeof (Vue) != 'undefined') {
    const AppNo = {
      template: `<center style="margin-top:35vh;"></el-button><el-button type="error">{{message}}</el-button></center>`,
      data() {
        return {
          message: "你引入了Vue，快开始创作你的页面吧！",
        };
      },
    };
    typeof (vuedraggable) != 'undefined' ? SaetComponent(vuedraggable) : '';
    const app = Vue.createApp(typeof (window.SaetPage) == 'undefined' ? AppNo : window.SaetPage);
    typeof (ElementPlus) != 'undefined' ? app.use(ElementPlus, { locale: ElementPlusLocaleZhCn }) : console.log('element-plus为必要拓展，请务必引入');

    for (const [key, component] of Object.entries(window.SaetComponentList)) {
      if (component.name) app.component(component.name, component)
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


    const initmenu = (el, binding) => {
      let Els = typeof binding.value.query == 'undefined' || !binding.value.query ? [el] : el.querySelectorAll(binding.value.query)
      for (let i = 0; i < Els.length; i++) {
        const element = Els[i];
        element.oncontextmenu = ((e) => {
          if (binding.value.ref) {
            binding.value.ref.close()
            let trigger = binding.value.ref.popoverRef.popperRef.triggerRef;
            trigger.style.position = document.body.scrollHeight > window.screen.height ? 'absolute' : 'fixed';
            trigger.style.top = e.pageY + 'px'
            trigger.style.left = e.pageX + 'px'
            // e.pageX
            setTimeout(() => {
              binding.value.ref.open(binding.value.ref.width / 2)
            }, 0);
            if (typeof binding.value.callback == 'function') binding.value.callback(i, element, Els);
          }
          return false
        })
      }
    }

    app.directive('menu', {
      mounted(el, binding) {
        initmenu(el, binding)
      },
      updated(el, binding) {
        initmenu(el, binding)
      }
    })



    // 注册 remixicon
    if (remixClass = Object.values(document.styleSheets).find((item) => item.href.indexOf('remixicon') >= 0)) {
      var REMIXICON = localStorage.getItem('REMIXICON') ? St.string(localStorage.getItem('REMIXICON')).parseCSV(',', null) : []
      if (REMIXICON.length == 0) {
        remixClass.cssRules.forEach(css => {
          let s = css.selectorText;
          if (s && (r = s.match('ri-.*(?=::before)'))) {
            REMIXICON.push(r[0])
          }
        });
        localStorage.setItem('REMIXICON', REMIXICON)
      }
      for (let index = 0; index < REMIXICON.length; index++) {
        const icon = REMIXICON[index];
        app.component(icon, { template: `<i class="${icon}"/>` })
      }
    }

    // 注册 ElementPlusIconsVue
    for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
      app.component(key, component)
    }


    app.component('QmkjIcon', { template: '<svg t="1660558197675" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1178" width="200" height="200"><path d="M697.8 745.89H501.55c-37.3 0-74.86-8.37-108.62-24.23-89.03-41.8-146.55-132.26-146.55-230.46V378.93c0-18.21 10.72-34.87 27.31-42.44 16.58-7.58 36.23-4.79 50.03 7.12l117.71 101.55c7.1 6.13 17.78 6.1 24.84-0.08l115.75-101.11c13.79-12.04 33.47-14.93 50.13-7.38 16.67 7.55 27.44 24.23 27.44 42.5v191.96c0 20.88-16.96 37.8-37.87 37.8-20.91 0-37.87-16.93-37.87-37.8v-128.2l-67.69 59.13c-35.32 30.87-88.74 31.02-124.26 0.39l-69.78-60.2v49.04c0 69.05 40.45 132.66 103.04 162.05 23.74 11.14 50.15 17.04 76.38 17.04H697.8c20.91 0 37.87 16.93 37.87 37.8s-16.95 37.79-37.87 37.79z" p-id="1179"></path><path d="M647.82 890.09c0-13.5 7.56-26.46 20.54-32.74 4.59-2.23 9.14-4.55 13.62-6.95 17.72-9.51 39.81-2.88 49.33 14.81 9.54 17.66 2.89 39.72-14.83 49.24-5.38 2.89-10.83 5.67-16.34 8.32-18.1 8.77-39.89 1.22-48.67-16.85-2.47-5.11-3.65-10.51-3.65-15.83z"  p-id="1180"></path><path d="M477.38 65.52C258.09 81.96 81.07 258.66 64.63 477.53c-19.71 262.3 188.53 482.03 447.21 482.03 13.5 0 26.98-0.63 40.38-1.85 20.75-1.89 35.41-21.19 31.62-41.64l-0.38-2.04c-3.37-18.2-20.21-30.32-38.68-28.67-10.93 0.98-21.93 1.48-32.94 1.48-216.02 0-390.03-182.93-374.72-401.74C150.06 300.4 299.95 150.78 485 137.88c219.22-15.29 402.5 158.39 402.5 374.01 0 98.29-37.78 191.08-106.4 261.47-13.53 13.88-15.08 36.49-2.05 50.85 14.21 15.66 38.46 15.96 53.06 1.1 82.7-84.18 128.25-195.49 128.25-313.41-0.01-258.23-220.18-466.09-482.98-446.38z" p-id="1181"></path></svg>' })
    app.component('SaetIcon', { template: '<el-icon :size="size" :color="color"> <i :class="name" v-if="isRemixIcon"></i><component :is="name" v-else></component></el-icon>', props: { name: { type: String, default: 'ri-checkbox-blank-circle-line' }, size: Number, color: String }, computed: { isRemixIcon() { return this.name ? St.string(this.name).include('ri-') : false; } } })

    app.mixin({ data() { return { ST: ST, St: St } } })
    app.mount("#saetApp");

  }

  if (isClearTemp === true) {
    var templates = document.getElementsByTagName('template');
    for (let index = 0; index < templates.length; index++) {
      const element = templates[index];
      setTimeout(() => {
        element.remove();
      }, 0);
    }
  }

}

const only = (url, param) => {
  let i = St.string(url).contains('?');
  if (i) { url += '&_self=1' } else { url += '?_self=1' }
  if (param) {
    for (const key in param) {
      let value = param[key]
      url += `&${key}=${value}`
    }
  }
  return url;
}


const copyText = (text) => {
  return new Promise((resolve, reject) => {
    if (navigator.clipboard) {
      // clipboard api 复制
      navigator.clipboard.writeText(text);
    } else {
      var textarea = document.createElement('textarea');
      document.body.appendChild(textarea);
      // 隐藏此输入框
      textarea.style.position = 'fixed';
      textarea.style.clip = 'rect(0 0 0 0)';
      textarea.style.top = '10px';
      // 赋值1
      textarea.value = text;
      // 选中
      textarea.select();
      // 复制
      document.execCommand('copy', true);
      // 移除输入框
      document.body.removeChild(textarea);
    }
    resolve(true)
  })
}

const LAST_IS_HOME = parent.document.getElementById('frame-entrance');

St.string = typeof (S) == 'undefined' ? null : S;
St.message = ElementPlus.ElMessage;
St.loading = ElementPlus.ElLoading;
St.notify = ElementPlus.ElNotification;

!function (e, t) { "object" == typeof exports && "undefined" != typeof module ? module.exports = t() : "function" == typeof define && define.amd ? define(t) : (e = e || self, function () { var n = e.Cookies, o = e.Cookies = t(); o.noConflict = function () { return e.Cookies = n, o } }()) }(this, (function () { "use strict"; function e(e) { for (var t = 1; t < arguments.length; t++) { var n = arguments[t]; for (var o in n) e[o] = n[o] } return e } return function t(n, o) { function r(t, r, i) { if ("undefined" != typeof document) { "number" == typeof (i = e({}, o, i)).expires && (i.expires = new Date(Date.now() + 864e5 * i.expires)), i.expires && (i.expires = i.expires.toUTCString()), t = encodeURIComponent(t).replace(/%(2[346B]|5E|60|7C)/g, decodeURIComponent).replace(/[()]/g, escape); var c = ""; for (var u in i) i[u] && (c += "; " + u, !0 !== i[u] && (c += "=" + i[u].split(";")[0])); return document.cookie = t + "=" + n.write(r, t) + c } } return Object.create({ set: r, get: function (e) { if ("undefined" != typeof document && (!arguments.length || e)) { for (var t = document.cookie ? document.cookie.split("; ") : [], o = {}, r = 0; r < t.length; r++) { var i = t[r].split("="), c = i.slice(1).join("="); try { var u = decodeURIComponent(i[0]); if (o[u] = n.read(c, u), e === u) break } catch (e) { } } return e ? o[e] : o } }, remove: function (t, n) { r(t, "", e({}, n, { expires: -1 })) }, withAttributes: function (n) { return t(this.converter, e({}, this.attributes, n)) }, withConverter: function (n) { return t(e({}, this.converter, n), this.attributes) } }, { attributes: { value: Object.freeze(o) }, converter: { value: Object.freeze(n) } }) }({ read: function (e) { return '"' === e[0] && (e = e.slice(1, -1)), e.replace(/(%[\dA-F]{2})+/gi, decodeURIComponent) }, write: function (e) { return encodeURIComponent(e).replace(/%(2[346BF]|3[AC-F]|40|5[BDE]|60|7[BCD])/g, decodeURIComponent) } }, { path: "/" }) }));
St.cookie = Cookies;

St.copyText = copyText;
St.copy = r => { let t = Array.isArray(r) ? [] : {}; for (const o in r) r[o] && "object" == typeof r[o] ? t[o] = St.copy(r[o]) : t[o] = r[o]; return t };
St.deepAssign = (...e) => { let t = Object.assign({}, ...e); for (let o of e) for (let [e, r] of Object.entries(o)) "object" == typeof r && "object" == typeof t[e] && (Array.isArray(t[e]) || (t[e] = St.deepAssign(t[e], r))); return t };

St.axios = axios.create({
  headers: { 'X-Requested-With': 'XMLHttpRequest' },
  timeout: 10000,
});
St.axios.defaults.responseFilterLevel = 2; // 响应过滤级别 0 1 2
St.axios.defaults.responseField = 'data'; // 二级过滤字段 responseFilterLevel == 2 生效
St.axios.defaults.loadToast = false; //加载全屏 loading
St.axios.defaults.successToast = false;//成功toast
St.axios.defaults.errorToast = true;//失败toast
St.axios.defaults.delayTime = 400;//最大delayTime 耗时<delayTime会补齐到delayTime  耗时>delayTime时无效


console.log('window', window.location);
St.axios.interceptors.request.use((config) => {
  if (config.url != '' && config.url != null) config.baseURL = ST.baseUrl;

  if (config.delayTime > 0) config.startTime = new Date().getTime();

  if (config.loadToast === true || config.loadToast === 'full' || (typeof config.loadToast == 'object') && config.loadToast.case == 'full') {
    let tCon = {}
    if (typeof config.loadToast == 'object') tCon = St.deepAssign(tCon, config.loadToast);
    config.loadingCase = St.loading.service(tCon);
  } else if (config.loadToast === 'toast' || (typeof config.loadToast == 'object') && config.loadToast.case == 'toast') {
    let tCon = {
      message: 'Loading',
      type: 'info',
      showClose: false,
      icon: 'loading',
      customClass: 'is-loading',
      duration: 0
    }
    if (typeof config.loadToast == 'object') tCon = St.deepAssign(tCon, config.loadToast)
    config.loadingCase = St.message(tCon)
  }
  // 在发送请求之前做些什么1
  return config;
}, function (error) {
  // 对请求错误做些什么
  return Promise.reject(error);
});



// 200状态码
St.axios.interceptors.response.use(async (e) => {

  // 对响应数据做点什么
  if (e.config.delayTime > 0) {
    let d = e.config.delayTime - (new Date().getTime() - e.config.startTime);
    if (d > 0) {
      await new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve();
        }, d)
      })
    }
  }
  // 关闭加载窗口
  if (e.config.loadToast && e.config.loadingCase) e.config.loadingCase.close();

  var res = null;
  if (e.status == 200 && e.config.responseFilterLevel != 0) {
    res = e.config.responseFilterLevel == 1 ? e.data : e.data[e.config.responseField];
    if (e.data.code == 1) {
      if (e.config.successToast) {
        St.message.success(e.data.msg && e.data.msg != '' ? e.data.msg : '执行成功');
      }
    } else {
      if (e.config.errorToast) {
        St.message.error(e.data.msg);
      }
      return Promise.reject(e.data);
    }
  } else {
    res = Promise.reject('服务器繁忙');
  }
  return res;

},
  // 非200状态码
  async (e) => {

    // 关闭加载窗口
    if (e.config.loadToast && e.config.loadingCase) {
      e.config.loadingCase.close()
    };

    const errMsg = e.response.data.message || e.response.data.msg || e.message;
    const errType = { 500: '系统错误提示', 401: '请先登录', 403: '你没有该权限', 404: '访问不存在', }

    St.notify.error({
      title: errType[e.response.status] || '错误提示',
      message: errMsg, duration: 5000
    });

    return Promise.reject(error);

  });

window.St = St

