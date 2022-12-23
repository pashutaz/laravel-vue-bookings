<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Register</div>

          <div class="card-body">
            <form @submit.prevent="submit">
              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end" for="name">Your name</label>
                <div class="col-md-6">
                  <input id="name"
                         v-model="user.name"
                         autocomplete="name"
                         autofocus
                         class="form-control"
                         :class="[{ 'is-invalid': getErrorsFor('name') }]"
                         name="name"
                         placeholder="John Doe"
                  >
                  <invalid-feedback :errors="getErrorsFor('name')"/>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end" for="email">Email Address</label>
                <div class="col-md-6">
                  <input id="email"
                         v-model="user.email"
                         autocomplete="email"
                         class="form-control"
                         :class="[{ 'is-invalid': getErrorsFor('email') }]"
                         name="email"
                         placeholder="johndoe@gmail.com"
                         required
                         type="email"
                  >
                  <invalid-feedback :errors="getErrorsFor('email')"/>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end" for="password">Password</label>
                <div class="col-md-6">
                  <input id="password"
                         v-model="user.password"
                         class="form-control"
                         :class="[{ 'is-invalid': getErrorsFor('password') }]"
                         name="password"
                         required
                         type="password"
                  >
                  <invalid-feedback :errors="getErrorsFor('password')"/>
                </div>
              </div>

              <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end" for="password_confirmation">Confirm Password</label>
                <div class="col-md-6">
                  <input id="password_confirmation"
                         v-model="user.password_confirmation"
                         class="form-control"
                         name="password_confirmation"
                         required
                         type="password"
                  >
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button class="btn btn-primary btn-lg float-right" type="submit">Register</button>
                </div>
              </div>
            </form>

            <hr/>

            <div>
              <router-link :to="{name: 'login'}">Already have an account?</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import validationErrors from "../shared/mixins/validationErrors";
import InvalidFeedback from "../shared/components/InvalidFeedback";
import {logIn} from "../shared/auth";

export default {
  name: "Register",

  mixins: [validationErrors],

  components: {
    InvalidFeedback
  },

  data() {
    return {
      loading: false,

      user: {
        email: null,
        password: null,
        password_confirmation: null
      }
    }
  },

  methods: {
    async submit() {
      this.loading = true;

      try {
        await axios.get('sanctum/csrf-cookie');
        await axios.post('/register', this.user);

        logIn();
        await this.$store.dispatch('loadUser');
        await this.$router.push({name: 'home'});
      } catch (e) {
        this.errors = e.response && e.response.data.errors
        this.status = e.response.status;
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>

</style>
