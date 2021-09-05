<template>
  <div>
      <div class="text-blue-400" @click="$router.back()">
                < Back
     </div>
      <form @submit.prevent="submitForm">
          <input-field name="name" label="Name" placeholder="Name" @update:field="form.name = $event" :errors="errors" :data="form.name"></input-field>
          <input-field name="email" label="Email" placeholder="Email" @update:field="form.email = $event" :errors="errors" :data="form.email"></input-field>
          <input-field name="company" label="Company" placeholder="Company" @update:field="form.company = $event" :errors="errors" :data="form.company"></input-field>
          <input-field name="birthday" label="Birthday" placeholder="MM/DD/YYYY" @update:field="form.birthday = $event" :errors="errors" :data="form.birthday"></input-field>
          <div class="flex justify-end">
              <button class="text-red-700 border py-2 px-4 rounded mr-5 hover:bg-red-200">Cancel</button>
              <button class="bg-blue-500 py-2 px-4 text-white rounded hover:bg-blue-400">Save</button>
          </div>
      </form>
  </div>
</template>

<script>
import InputField from '../js/components/InputField.vue';
export default {
  components: { InputField },
  name: "ContactCreate",
  data: function() {
      return {
          form: {
              'name': '', 
              'email': '',
              'company': '',
              'birthday': '',
          },
          errors: null,
      }
  },
  methods: {
      submitForm: function() {
          axios.patch('/api/contacts/' + this.$route.params.id, this.form)
            .then(response => {
                this.$router.push(response.data.links.self);
            })
            .catch(errors => {
                this.errors = errors.response.data.errors;
            });
      }
  },
  mounted() {
       axios.get('/api/contacts/' + this.$route.params.id)
            .then(response => {
                this.form = response.data.data;
                this.loading = false;
            })
            .catch(errors => {
                this.errors = errors.response.data.errors;
                this.loading = false;
                if (errors.response.status === 404) {
                    this.$router.push('/contacts');
                }
            });
  }
    
}

</script>

<style scoped>

</style>