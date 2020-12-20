<template>
    <div class="container">
      <div class="card">
        <div class="card-header">Registracija</div>

        <div class="card-body">
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
                    <label>Ime</label>
                    <input type="text" class="form-control" v-model="name">
                </div>

                <div class="form-group">
                    <label>Prezime</label>
                    <input type="text" class="form-control" v-model="lastname">
                </div>

                <div class="form-group">
                    <label>Korisničko ime</label>
                    <input type="text" class="form-control" v-model="username">
                </div>
                
                <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" v-model="email">
                  </div>

                <div class="form-group">
                    <label>Lozinka</label>
                    <input type="password" class="form-control" v-model="password">
                </div>

                <div class="form-group">
                    <label>Ponovljena lozinka</label>
                    <input type="password" class="form-control" v-model="passwordAgain">
                </div>

                <b-button @click="onSubmit" variant="success">Registracija</b-button>
            </form>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    name: 'register',
    props: ['app'],
    data() {
        return{
            name: '',
            lastname: '',
            username: '',
            email: '',
            password: '',
            passwordAgain: '',
            errors: []
        }
    },
    methods: {
        onSubmit()
        {
            this.errors = [];
            if (!this.name) 
            {
                this.errors.push('Ime je obavezno.')    
            }
            if (!this.lastname) 
            {
                this.errors.push('Prezime je obavezno.')    
            }
            if (!this.username)
            {
                this.errors.push('Korisničko ime je obavezno.')
            }
            if (!this.email) 
            {
                this.errors.push('Email je obavezan.')    
            }
            if (!this.password)
            {
                this.errors.push('Lozinka je obavezna.')
            }
            if (!this.passwordAgain)
            {
                this.errors.push('Ponovni unos lozinke je obavezan.')
            }
            if (this.password !== this.passwordAgain)
            {
                this.errors.push('Lozinke se ne podudaraju.')
            }
            if (!this.errors.length)
            {
                const data = {
                    name: this.name,
                    lastname: this.lastname,
                    username: this.username,
                    email: this.email,
                    password: this.password
                }
                console.log(this.app)
                this.app.req
                .post("auth/register", data)
                .then(response => {
                    this.app.user = response.data;
                    this.$router.push("/");
                }).catch(error => {
                    this.errors.push(error.response.data.error);
                });
            }
        }
    }
}
</script>

<style>
</style>