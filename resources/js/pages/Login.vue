<template>
  <div class="container">
    <div class="alert alert-danger" role="alert" v-if="error !== null">
      {{ error }}
    </div>
    <form>
      <div class="form-group">
        <label for="email" class="col-sm-4 col-form-label text-md-right"
          >Email</label
        >

        <input
          id="email"
          type="email"
          class="form-control"
          v-model="email"
          required
          autofocus
        />
      </div>

      <div class="form-group">
        <label for="password" class="col-md-4 col-form-label text-md-right"
          >Senha</label
        >

        <input
          id="password"
          type="password"
          class="form-control"
          v-model="password"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary confirm" @click="handleSubmit">
        Login
      </button>
    </form>
  </div>
</template>



<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      error: null,
    };
  },
  methods: {
    handleSubmit(e) {
      e.preventDefault();
      if (this.password.length > 0) {
        this.$axios.get("/sanctum/csrf-cookie").then((response) => {
          this.$axios
            .post("api/login", {
              email: this.email,
              password: this.password,
            })
            .then((response) => {
              if (response.data.success) {
                this.$router.go("/dashboard");
              } else {
                this.error = response.data.message;
              }
            })
            .catch(function (error) {
              console.error(error);
            });
        });
      }
    },
  },
  beforeRouteEnter(to, from, next) {
    if (window.Laravel.isLoggedin) {
      return next("dashboard");
    }
    next();
  },
};
</script>
