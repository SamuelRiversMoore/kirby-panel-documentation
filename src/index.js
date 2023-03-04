import Documentation from './views/Documentation.vue'
import './index.pcss'

window.panel.plugin('samrm/documentation', {
  use: {
    plugin(Vue) {
      if (window.__VUE_DEVTOOLS_GLOBAL_HOOK__) window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = Vue
    }
  },
  components: {
    documentation: Documentation
  }
})
