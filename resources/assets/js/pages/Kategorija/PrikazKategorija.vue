<template>
<div v-if="this.app.user">
    <b-tabs content-class="mt-3">
        <b-tab title="Informacije" active>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Kategorija</div>
                            <div class="card-tools">
                            </div>
                        </div>
                        <b-table responsive hover :items="[kategorija]" :fields="fieldsKategorija">
                        </b-table>
                        <!-- /.card-header -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Vrste">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" v-if="kategorija.vrsta && kategorija.vrsta.length>0">Vrste u kategoriji "{{kategorija.naziv_kategorije}}"</div>
                            <div class="card-title" v-else>U kategoriji nema zabilježenih vrsta</div>
                            <div class="card-tools">
<!-- 
                                <button class="btn btn-outline-primary" @click="newModalChild"><i class="fas fa-plus-square"></i></button>
                                <button class="btn btn-outline-primary" @click="openModalAutocomplete"><i class="fas fa-connectdevelop"></i></button> -->
                            </div>
                        </div>

                        <b-table  responsive hover :items="kategorija.vrsta" :fields="fieldsVrsta">
                            <template v-slot:cell(name)="data">
                                <router-link :to="{ name: 'showVrsta', params: {id: data.item.id } }">
                                    {{ data.value}}
                                </router-link>
                            </template>

                            <template v-slot:cell(naziv_vrste)="data">
                                <router-link :to="{ name: 'showVrsta', params: {id: data.item.id}}">{{data.value}}</router-link>
                            </template>
                            <!-- <template v-slot:cell(action)="data">
                                <a href="#" v-on:click="editModalChild(data.item)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" v-on:click="deleteChildParent(data.item)"><i class="fa fa-trash red"></i></a>
                            </template> -->
                        </b-table>
                        <!-- /.card-header -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </b-tab>
    </b-tabs>
</div>
<div id="404" v-else>
        <router-view></router-view>
        <not-found/>
    </div>
</template>

<script>
    import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
    import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
    import notFound from '../404';
    import moment from 'moment';
    export default {
        props: ['app'],
        components:{
            VueCtkDateTimePicker,
            notFound,
        },
        data() {
            return {
                editmode: false,
                kategorija: {},
                vrste:[],
                fieldsVrsta: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Naziv vrste',
                        key: 'naziv_vrste',
                        sortable: true,
                    },
                ],
                fieldsKategorija: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Naziv kategorije',
                        key: 'naziv_kategorije',
                        sortable: true,
                    },
                ],
            }
        },
        methods: {
            
            deleteClassModal(){
                $('.is-invalid').removeClass("is-invalid");
                $(".invalid-feedback").removeClass("invalid-feedback");
                $(".help-block").text('');
            },
            editModalChild(child){
                this.deleteClassModal();
                this.editmode=true;
                this.form2.reset();
                $('#addNew3').modal('show');
                this.form2.fill(child);
            },
            newModalChild(){
                this.deleteClassModal();
                this.editmode = false;
                this.form2.reset();
                $('#addNew3').modal('show');
            },
            loadKategorija(){
                console.log(this.$route.params.id);
                    axios.get('/api/kategorija/'+this.$route.params.id).then(({ data }) => (this.kategorija = data));
            },
            
        },

        created() {
            this.loadKategorija();

            Fire.$on('AfterCreate',() => {
                this.loadKategorija();
            });
        },
    }
</script>
