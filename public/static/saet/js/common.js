
window.SaetComponentList = [];
window.SaetPage = {}


console.log('Vue',Vue.version);
console.log('ElementPlus',ElementPlus.version);

function SaetApp(o) { window.SaetPage = o }

const SaetComponent = o => window.SaetComponentList.push(o);
const ref = Vue.ref;
const reactive = Vue.reactive;
// ceeat view
// 注册saet vue
function useSaetVue(isClearTemp) {
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
     SaetComponent(vuedraggable)
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

    for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
      app.component(key, component)
    }
    for (const [key, component] of Object.entries(SaetAdminComponentVue)) {
      app.component(key, component)
    }




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
  if (i) { url += '&self=1' } else { url += '?self=1' }
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
      // 赋值
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

const St = {
  axios: axios.create({
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    timeout: 10000,
  }),
  string: typeof (S) == 'undefined' ? null : S,
  message: LAST_IS_HOME ? ElementPlus.ElMessage : parent.window.ElementPlus.ElMessage,
  loading: LAST_IS_HOME ? ElementPlus.ElLoading : parent.window.ElementPlus.ElLoading,
  notify: LAST_IS_HOME ? ElementPlus.ElNotification : parent.window.ElementPlus.ElNotification,
  cookie: Cookies,
  copyText: copyText,
  copy: r => { let t = Array.isArray(r) ? [] : {}; for (const o in r) r[o] && "object" == typeof r[o] ? t[o] = St.copy(r[o]) : t[o] = r[o]; return t },
  deepAssign: (...e) => { let t = Object.assign({}, ...e); for (let o of e) for (let [e, r] of Object.entries(o)) "object" == typeof r && "object" == typeof t[e] && (Array.isArray(t[e]) || (t[e] = St.deepAssign(t[e], r))); return t }
}


St.axios.defaults.responseFilterLevel = 2; // 响应过滤级别 0 1 2
St.axios.defaults.responseField = 'data'; // 二级过滤字段 responseFilterLevel == 2 生效
St.axios.defaults.loadingToast = false; //加载全屏 loading
St.axios.defaults.successToast = false;//成功toast
St.axios.defaults.errorToast = true;//失败toast
St.axios.defaults.delayTime = 400;//最大delayTime 耗时<delayTime会补齐到delayTime  耗时>delayTime时无效

St.axios.interceptors.request.use((config) => {
  if (config.delayTime > 0) {
    config.startTime = new Date().getTime();
  }

  if (config.loadingToast) {
    config.loadingCase = St.loading.service({
      lock: true,
      text: 'Loading',
      background: 'rgba(0, 0, 0, 0.7)',
    });
  }
  // 在发送请求之前做些什么
  return config;
}, function (error) {
  // 对请求错误做些什么
  return Promise.reject(error);
});

const getdd = (...arr) => {
  console.log('strings', arr);
  arr.forEach(e => {
    if (e) return e;
  });
}


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

  if (e.config.loadingToast && e.config.loadingCase) {
    e.config.loadingCase.close();
  }
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
      return Promise.reject(e.data.msg);
    }
  } else {
    res = Promise.reject('服务器繁忙');
  }
  return res;

}, async (error) => {
  if (typeof (error.config) == 'undefined') return Promise.reject(error);
  // 对响应错误做点什么
  if (error.config.delayTime > 0 && error.config.startTime) {
    let d = error.config.delayTime - (new Date().getTime() - error.config.startTime);
    if (d > 0) {
      await new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve();
        }, d)
      })
    }
  }


  if (error.config.loadingToast && error.config.loadingCase) {
    error.config.loadingCase.close();
  }
  var errMsg = getdd(error.response.data.message, error.response.data.msg, error.message);
  let title = '提示'
  if (error.response.status == 500) title = '错误提示';
  if (error.response.status == 401) title = '登录提示';
  if (error.response.status == 403) title = '权限提示';

  St.notify.error({
    title: title,
    message: errMsg
  });

  return Promise.reject(error);

});

window.St = St

