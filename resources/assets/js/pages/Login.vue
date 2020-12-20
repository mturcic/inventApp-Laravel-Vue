<template>
    <div class="container">
      <div class="card">
        <div class="card-header">Prijava u sustav</div>

        <div class="card-body" img-src="/images/qr-code.jpg">
          <div class="col-md-6 offset-md-3">
              <form v-on:submit.prevent="onSubmit">
                  <div class="alert alert-danger" v-if="errors.length">
                      <ul class="mb-0">
                          <li v-for="(error, index) in errors" :key="index">{{error}}</li>
                      </ul>
                  </div>
                <center>
                <img src="/img/InventAppLogo1.png" alt="logo">
                </center>
                  <div class="form-group">
                      <label>Korisničko ime</label>
                      <input type="text" class="form-control" v-model="username">
                  </div>

                  <div class="form-group">
                      <label>Lozinka</label>
                      <input type="password" class="form-control" v-model="password">
                  </div>

                  <div class="col-md-5 offset-md-4">
                  <b-button @click="onSubmit" variant="success">Prijava</b-button>
                  </div>
                  <br>
                  <a>Nemate korisnički račun?</a>
                  <b-button @click= router-link to="/register" variant="info">Registrirajte se</b-button>
                </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    name: 'login',
    props: ['app'],
    data() {
        return{
            username: '',
            password: '',
            errors: []
        }
    },
    methods: {
        onSubmit()
        {
            this.errors = [];
            if (!this.username)
            {
                this.errors.push('Korisničko ime je obavezno.')
            }
            if (!this.password)
            {
                this.errors.push('Lozinka je obavezna.')
            }
            if (!this.errors.length)
            {
                const data = {
                    username: this.username,
                    password: this.password
                };

                this.app.req
                .post("auth/login", data)
                .then(response => {
                    this.app.user = response.data;
                    this.$router.push("/");
                })
                .catch(error => {
                    this.errors.push(error.response.data.error);
                });
            }
        }
    }
}
</script>

<style>
</style>