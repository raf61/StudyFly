import "./bootstrap";
import "../css/app.css";
import asset from './helpers/asset'
import uploaded from './helpers/uploaded'
import "vue-toastification/dist/index.css"

import { createApp, h } from "vue"
import { createInertiaApp, Link, Head, router } from "@inertiajs/vue3"
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers"
import Toast from "vue-toastification"
import { useToast } from "vue-toastification";
import vClickOutside from "click-outside-vue3"
import App from './Pages/App.vue'

createInertiaApp({
  title: (title) => {
    if (title.startsWith("  ")){
      return title
    }
    return `${title} - StudyFly`
  },
  resolve: async (name) =>{
    const pageComponent = await resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    )
    if (pageComponent.default.layout === undefined)
      pageComponent.default.layout = App;
    return pageComponent
  },
  setup({ el, App, props, plugin }) {
    const VueApp = createApp({ render: () => h(App, props) })
    VueApp.config.globalProperties.$route = window.route
    VueApp.config.globalProperties.$asset = asset
    VueApp.config.globalProperties.$uploaded = uploaded
    VueApp
    .use(plugin)
    .use(Toast, {
      transition:'Vue-Toastification__fade',
      timeout:3000,
      pauseOnHover:true
    })
    .use(vClickOutside)
    .component("Link", Link)
    .component("Head", Head)
    .mount(el)
    
    return VueApp
  },
});



router.on('navigate', function(event){
  const {flash} = event.detail.page.props
  const toast = useToast()

  for (let key in flash){
    if (flash[key]){
      toast[key](flash[key])
    }
  }
})