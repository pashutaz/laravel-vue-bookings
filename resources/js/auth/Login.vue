<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Log in</div>

          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end" for="email">Email Address</label>
                <div class="col-md-6">
                  <input id="email"
                         v-model="user.email"
                         autocomplete="email"
                         autofocus
                         class="form-control"
                         name="email"
                         placeholder="johndoe@gmail.com"
                         required
                         type="email"
                  >
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end" for="password">Password</label>
                <div class="col-md-6">
                  <input id="password"
                         v-model="user.password"
                         autocomplete="current-password"
                         class="form-control"
                         name="password"
                         required
                         type="password"
                  >
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input id="remember" v-model="remember" class="form-check-input" name="remember" type="checkbox">
                    <label class="form-check-label" for="remember">Remember Me</label>
                  </div>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button class="btn btn-primary btn-lg float-right" type="submit">Login</button>
                </div>
              </div>
            </form>

            <hr/>

            <div>
              <router-link :to="{name: 'home'}">Forgot password?</router-link>
              <router-link :to="{name: 'home'}" class="float-right">Sign up</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";
import {logIn} from "../shared/auth";

export default {
  name: "Login",

  mixins: [validationErrors],

  data() {
    return {
      loading: false,
      remember: false,

      user: {
        email: null,
        password: null,
      }
    }
  },

  methods: {
    async submit() {
      this.loading = true;

      try {
        await axios.get('sanctum/csrf-cookie');
        await axios.post('/login', this.user);

        logIn();
        await this.$store.dispatch('loadUser');
        await this.$router.push({name: 'home'});
      } catch (e) {
        this.errors = e.response && e.response.data.errors
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>

</style>
