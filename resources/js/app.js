/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");

import {
    library
} from "@fortawesome/fontawesome-svg-core";
import {
    fab
} from "@fortawesome/free-brands-svg-icons";

import {
    fas
} from "@fortawesome/free-solid-svg-icons";

import {
    far
} from "@fortawesome/free-regular-svg-icons";

import {
    FontAwesomeIcon
} from "@fortawesome/vue-fontawesome";

library.add(fas);
library.add(fab);
library.add(far);

Vue.component("font-awesome-icon", FontAwesomeIcon);

import BootstrapVue from "bootstrap-vue";

Vue.use(BootstrapVue);

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import "slick-carousel/slick/slick.css";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import {
    TablePlugin
} from "bootstrap-vue";
import {
    ClientTable
} from "vue-tables-2";

Vue.use(TablePlugin);

Vue.use(ClientTable, {}, false, 'bootstrap3', 'default');

import VuejsDialog from 'vuejs-dialog';
import VuejsDialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min.js'; // only needed in custom components
 
// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
import "vue2-editor/dist/vue2-editor.css";
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.bubble.css';
import 'quill/dist/quill.snow.css';

// Copy to clipboard library
import VueClipboard from 'vue-clipboard2';
Vue.use(VueClipboard);
 
// Tell Vue to install the plugin.
Vue.use(VuejsDialog);

// vue scroll
import VueScrollTo  from 'vue-scrollto'

Vue.use(VueScrollTo)

Vue.component("home-dashboard", require("./components/admin/HomeDashboard.vue").default);

Vue.component("aside-admin", require("./components/admin/AsideAdmin.vue").default);

Vue.component("users-list", require("./components/admin/UsersList.vue").default);

Vue.component("posts-list", require("./components/admin/PostsList.vue").default);

Vue.component("post-form", require("./components/admin/PostForm.vue").default);

Vue.component("questions-list", require("./components/admin/QuestionsList.vue").default);

Vue.component("glosary-list", require("./components/admin/GlosaryList.vue").default);

Vue.component("acronimo-list", require("./components/admin/AcronimoList.vue").default);

Vue.component("surveys-list", require("./components/admin/SurveysList.vue").default);

Vue.component("pages-list", require("./components/admin/PagesList.vue").default);

Vue.component("links-list", require("./components/admin/LinksList.vue").default);

Vue.component("page-form", require("./components/admin/PageForm.vue").default);

Vue.component("menu-list", require("./components/admin/MenuList.vue").default);

Vue.component("laws-list", require("./components/admin/LawsList.vue").default);

Vue.component("social-links", require("./components/admin/Social.vue").default);

Vue.component("header-manager", require("./components/admin/HeaderManager.vue").default);

Vue.component("aside-manager", require("./components/admin/AsideManager.vue").default);

Vue.component("page-template", require("./views/PageTemplate.vue").default);

Vue.component("faqs", require("./views/Faqs.vue").default);

Vue.component("glosary-component", require("./views/Glosary.vue").default);

Vue.component("acronimos-component", require("./views/Acronimos.vue").default);

Vue.component("surveys", require("./views/Encuestas.vue").default);

Vue.component("survey", require("./views/EncuestaTemplate.vue").default);

Vue.component("pregunta-adicional", require("./views/Consulta.vue").default);

Vue.component("legal-view", require("./views/LegalView.vue").default);

Vue.component("cabecera", require("./components/Cabecera.vue").default);

Vue.component("authorizations-list", require("./components/permissions/AuthorizationsList.vue").default);

Vue.component("permissions-list", require("./components/permissions/PermissionsList.vue").default);

Vue.component("comercial-export-species-requirements", require("./components/permissions/requirements/ComercialExportSpeciesRequirements").default);

Vue.component("navi", require("./components/Nav.vue").default);

Vue.component("navmobile", require("./components/Nav-mobile.vue").default);
Vue.component("sidebar", require("./components/Sidebar.vue").default);
Vue.component("pie", require("./components/Pie-de-pagina.vue").default);
Vue.component("error", require("./components/Error404.vue").default);


if ($("#app").length !== 0) {

    let app = new Vue({
        el: "#app"
    });
}