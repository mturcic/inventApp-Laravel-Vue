<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                                <form class="form-horizontal">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label for="inputName" class="col-sm-6 control-label">Ime</label>
                                           <input type="" v-model="form.name" class="form-control" id="inputName" placeholder="Ime" :class="{ 'is-invalid': form.errors.has('name') }">
                                           <has-error :form="form" field="name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputLastname" class="col-sm-6 control-label">Prezime</label>
                                                <input type="" v-model="form.lastname" class="form-control" id="inputLastname" placeholder="Prezime" :class="{ 'is-invalid': form.errors.has('lastname') }">
                                                <has-error :form="form" field="lastname"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputusername" class="col-sm-6 control-label">Korisničko ime</label>
                                            <input type="" v-model="form.username" class="form-control" id="inputUsername" placeholder="Korisničko ime" :class="{ 'is-invalid': form.errors.has('username') }">
                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-6 control-label">E-mail</label>
                                            <input type="email" v-model="form.email" class="form-control" id="inputEmail" placeholder="Email"  :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                    <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Ažuriraj</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            form: new Form({
                name: '',
                lastname: '',
                username: '',
                email: '',
            })
        }
    },
    mounted() {
        console.log('Komponenta sastavljena.')
    },

    methods:{
        updateInfo(){
                this.$Progress.start();
                this.form.put('api/userUpdate')
                .then(()=>{
                     Fire.$emit('AfterCreate');
                    swal(
                        'Ažurirano!',
                        'Informacije profila uspješno ažurirane.',
                        'success'
                    )
                    this.$Progress.finish();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
            },
    },

    created() {
        axios.get("auth/init")
        .then(({ data }) => (this.form.fill(data)));
    }
}
</script>











    <!--div class="container" v-if="this.app.user">
      <div class="card">
        <div class="card-header">Izmjena korisničkih podataka</div>

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

                <b-button @click="onSubmit" variant="success">Spremi</b-button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div id="404" v-else>
        <router-view></router-view>
        <not-found/>
    </div>
</template>

<script>
import notFound from './404';
export default {
    name: 'korisnik',
    props: ['app'],
    components: {
            notFound
        },
    user: [],
    data() {
        return{
            name: '',
            lastname: '',
            username: '',
            email: '',
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
            if (!this.errors.length)
            {
                const data = {
                    name: this.name,
                    lastname: this.lastname,
                    username: this.username,
                    email: this.email,
                }
                console.log(this.app)
                this.app.req
                .put('api/userUpdate/', data)
                .then(response => {
                    this.app.user = response.data;
                }).catch(error => {
                    this.errors.push(error.response.data.error);
                });
            }
        },
        loadUsers(){
            axios.get("auth/init").then(({ data }) => (
                this.user=data
                // console.log(data)
            ));
            this.user.name=this.user.name;
            this.lastname=this.user.lastname;
            data.fill(this.user);
          
        },

        created() {
        this.loadUsers();
        
        Fire.$on('AfterCreate',() => {
            this.loadUsers();
        });
        }
    }
}
</script>

<style>
</style>