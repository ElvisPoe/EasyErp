import { createApp, h } from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import Paginator from '@/Shared/Paginator'
import General from '@/Layouts/General'
import SearchFilter from '@/Shared/SearchFilter'
import TextInput from '@/Shared/TextInput'
import SelectInput from "@/Shared/SelectInput";
import FileInput from "@/Shared/FileInput";
import LoadingButton from '@/Shared/LoadingButton'
import TrashedMessage from "@/Shared/TrashedMessage";

InertiaProgress.init({
    showSpinner: true,
});

createInertiaApp({

    resolve: async name => {
        let page = (await import(`./Pages/${name}`)).default;
        if(page.layout === undefined){
            page.layout = General;
        }
        return page
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Link', Link)
            .component('Head', Head)
            .component('Icon', Icon)
            .component('Paginator', Paginator)
            .component('SearchFilter', SearchFilter)
            .component('TextInput', TextInput)
            .component('SelectInput', SelectInput)
            .component('FileInput', FileInput)
            .component('LoadingButton', LoadingButton)
            .component('TrashedMessage', TrashedMessage)
            .mount(el)
    },

    title: title => title ? `${title} - EasyErp` : 'EasyERP',
})
