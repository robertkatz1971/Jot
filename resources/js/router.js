import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent.vue';
import ContactCreate from '../views/ContactCreate.vue';
import ContactShow from '../views/ContactShow.vue'

Vue.use(VueRouter);

export default new VueRouter( {
   
    routes: [
        { path: '/', component: ExampleComponent},
        { path: '/contacts/create', component: ContactCreate},
        { path: '/contacts/:id', component: ContactShow}
    ],
    mode: 'history'
});
