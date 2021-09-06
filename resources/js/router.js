import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent.vue';
import ContactCreate from '../views/ContactCreate.vue';
import ContactShow from '../views/ContactShow.vue';
import ContactEdit from '../views/ContactEdit.vue'
import ContactsIndex from '../views/ContactsIndex.vue'
import BirthdaysIndex from '../views/BirthdaysIndex.vue'

Vue.use(VueRouter);

export default new VueRouter( {
   
    routes: [
        { path: '/', component: ContactsIndex},
        { path: '/contacts', component: ContactsIndex},
        { path: '/contacts/create', component: ContactCreate},
        { path: '/contacts/:id', component: ContactShow},
        { path: '/birthdays', component: BirthdaysIndex},
    ],
    mode: 'history'
});
