<template>
  <div class="container-fluid main">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="collapse navbar-collapse">
        <!-- Se o usuário estiver logado-->
        <div class="navbar-nav" v-if="isLoggedIn">
          <router-link to="/dashboard" class="nav-item nav-link text-white"
            >Dashboard</router-link
          >
          <router-link to="/products" class="nav-item nav-link text-white"
            >Produtos</router-link
          >
          <a
            class="nav-item nav-link text-white"
            style="cursor: pointer"
            @click="logout"
            >Logout</a
          >
        </div>
        <!-- Se o usuário não estiver logado -->
        <div class="navbar-nav" v-else>
          <router-link to="/login" class="nav-item nav-link text-white"
            >Login</router-link
          >
          <router-link to="/register" class="nav-item nav-link text-white"
            >Registro</router-link
          >
        </div>
      </div>
    </nav>
    <div class="App">
      <div class="vertical-center">
        <div class="inner-block">
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.container-fluid {
  padding: 0px;
}
</style>


<script>
export default {
  name: "App",
  data() {
    return {
      isLoggedIn: false,
    };
  },
  created() {
    if (window.Laravel.isLoggedin) {
      this.isLoggedIn = true;
    }
  },
  methods: {
    logout(e) {
      console.log("ss");
      e.preventDefault();
      this.$axios.get("/sanctum/csrf-cookie").then((response) => {
        this.$axios
          .post("/api/logout")
          .then((response) => {
            if (response.data.success) {
              window.location.href = "/";
            } else {
              console.log(response);
            }
          })
          .catch(function (error) {
            console.error(error);
          });
      });
    },
  },
};
</script>
