import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent.vue';
import ContactCreate from '../views/ContactCreate.vue';
import ContactShow from '../views/ContactShow.vue';
import ContactEdit from '../views/ContactEdit.vue'
import ContactsIndex from '../views/ContactsIndex.vue'
import BirthdaysIndex from '../views/BirthdaysIndex.vue'
import Logout from '../js/actions/Logout.vue'

Vue.use(VueRouter);

export default new VueRouter( {
   
    routes: [
        { path: '/', component: ContactsIndex, meta: {title: 'Contacts'}},
        { path: '/contacts', component: ContactsIndex, meta: {title: 'Contacts'}},
        { path: '/contacts/create', component: ContactCreate, meta: {title: 'Add New Contact'}},
        { path: '/contacts/:id', component: ContactShow, meta: {title: 'Details for Contact'}},
        { path: '/contacts/:id/edit', component: ContactEdit, meta: {title: 'Edit Contact'}},
        { path: '/birthdays', component: BirthdaysIndex, meta: {title: 'This Month\'s Birthdays'}},
        { path: '/logout', component: Logout},
    ],
    mode: 'history'
});
