<template>
  <v-app>
    <app-header></app-header>
    <div>
      <v-main>
        <!-- <v-slide-y-transition mode="out-in"> -->
          <router-view></router-view>
        <!-- </v-slide-y-transition> -->
      </v-main>
    </div>
  </v-app>
</template>

<script>
  import Header from '../components/Header.vue'
  export default {
    components: {
      'app-header': Header
    }
  }
</script>

<style lang="scss">
  #app {
    @import url(https://fonts.googleapis.com/css?family=Poppins);
    font-family: "Poppins";
    font-size: 13px;
  }
</style>