<template>
    <div>
      <div v-if="loading">Loading...</div>
      <div v-else>
          <div v-if="contacts.length === 0">
              <p>No contacts exist. 
                  <router-link to="/contact/create">Get started...</router-link>
              </p>
          </div>
          <div v-else>
                <div v-for="contact in contacts" v-bind:key="contact.contact_id">
                    <router-link :to="'/contacts/' + contact.data.contact_id" 
                        class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                        <user-circle :name="contact.data.name"></user-circle>
                        <div class="pl-2">
                            <p class="text-blue-400 font-bold">{{ contact.data.name }}</p>
                            <p class="text-gray-500">{{ contact.data.company }}</p>
                            <p class="text-gray-500" v-if="showBirthday">Birthday: {{ contact.data.birthday }}</p>
                        </div>
                    </router-link>
                </div>
          </div>
      </div>
  </div>
    
</template>

<script>
import UserCircle from '../components/UserCircle.vue'
export default {
    name: "ContactsList",
    components: {
        UserCircle
    },
    props: [
        'endpoint',
        'showBirthday'
    ],
    data: function () {
        return {
            contacts: null,
            loading: true,
        }
    },
     mounted() {
        axios.get(this.endpoint)
            .then(response => {
                this.contacts = response.data.data;
                this.loading = false;
            })
            .catch(error => {
                this.loading = false;
                alert('Unable to fetch contacts');
            })
     } 
}
</script>

<style scoped>

</style>