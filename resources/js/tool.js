import '../css/tool.css'

import Tool from './pages/Tool.vue'

Nova.booting((app, store) => {
  Nova.inertia('NovaHealth', Tool)
})
