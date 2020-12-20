<template>
<div v-if="this.app.user">
    <b-tabs content-class="mt-3">
        <b-tab title="Informacije" active>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Prostor</div>
                            <div class="card-tools">
                            </div>
                        </div>
                        <b-table responsive hover :items="[prostor]" :fields="fieldsProstor">
                            <!-- <template v-slot:cell(action)="data">
                                <a href="#" v-on:click="editModalParent(data.item)"><i class="fa fa-edit blue"></i></a>
                            </template> -->
                        </b-table>
                        <!-- /.card-header -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Prostorije">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" v-if="prostor.prostorija && prostor.prostorija.length>0">Prostorije u prostoru "{{prostor.opis_prostora}}"</div>
                            <div class="card-title" v-else>U prostoru nema zabilježenih prostorija</div>
                            <div class="card-tools">
<!-- 
                                <button class="btn btn-outline-primary" @click="newModalChild"><i class="fas fa-plus-square"></i></button>
                                <button class="btn btn-outline-primary" @click="openModalAutocomplete"><i class="fas fa-connectdevelop"></i></button> -->
                            </div>
                        </div>

                        <b-table  responsive hover :items="prostor.prostorija" :fields="fieldsProstorija">
                            <template v-slot:cell(naziv_prostorije)="data">
                                <router-link :to="{ name: 'showProstorija', params: {id: data.item.id } }">
                                    {{ data.value}}
                                </router-link>
                            </template>
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
    import moment from 'moment';
    import notFound from '../404';
    export default {
        props: ['app'],
        components:{
            VueCtkDateTimePicker,
            notFound,
        },
        data() {
            return {
                editmode: false,
                prostor: {},
                prostorije:[],
                fieldsProstorija: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Naziv prostorije',
                        key: 'naziv_prostorije',
                        sortable: true,
                    },
                ],
                fieldsProstor: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Opis prostora',
                        key: 'opis_prostora',
                        sortable: true,
                    },
                    {
                        label: 'Adresa',
                        key: 'adresa_prostora',
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
            loadProstor(){
                console.log(this.$route.params.id);
                    axios.get('/api/prostor/'+this.$route.params.id).then(({ data }) => (this.prostor = data));
            },
            
        },

        created() {
            this.loadProstor();

            Fire.$on('AfterCreate',() => {
                this.loadProstor();
            });
        }, 
    }
</script>