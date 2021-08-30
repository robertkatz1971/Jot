<template>
  <div class="border-gray-400 rounded-full text-white bg-blue-400 w-10 h-10 flex justify-center items-center">
        {{ getInitials }}
  </div>
</template>

<script>
export default {
    name: "UserCircle",
    props: [
        'name'
    ],
    computed: {
        getInitials: function() {
            if (this.name.match(/[A-Z]/g)) {
                return this.name.match(/[A-Z]/g).slice(0,2).join('');
            } else {
                return this.name.slice(0, 1);
            }
        }
    }
}
</script>

<style scoped>

</style>