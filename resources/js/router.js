import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent.vue';
import ContactCreate from '../views/ContactCreate.vue'

Vue.use(VueRouter);

export default new VueRouter( {
   
    routes: [
        { path: '/', component: ExampleComponent},
        { path: '/contacts/create', component: ContactCreate}
    ],
    mode: 'history'
});
