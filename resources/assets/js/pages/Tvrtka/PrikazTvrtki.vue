<template>
<div v-if="this.app.user">
    <b-tabs content-class="mt-3">
        <b-tab title="Informacije" active>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Tvrtka</div>
                            <div class="card-tools">
                            </div>
                        </div>
                        <b-table responsive hover :items="[tvrtka]" :fields="fieldsTvrtka">
                        </b-table>
                        <!-- /.card-header -->
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </b-tab>
        <b-tab title="Inventar">
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" v-if="tvrtka.inventar && tvrtka.inventar.length>0">Inventar koji se nalazi u tvrtki: "{{tvrtka.naziv_tvrtke}}"</div>
                            <div class="card-title" v-else>U tvrtki nema zabilježenih stavki inventara</div>
                            <div class="card-tools">
<!-- 
                                <button class="btn btn-outline-primary" @click="newModalChild"><i class="fas fa-plus-square"></i></button>
                                <button class="btn btn-outline-primary" @click="openModalAutocomplete"><i class="fas fa-connectdevelop"></i></button> -->
                            </div>
                        </div>

                        <b-table  responsive hover :items="tvrtka.inventar" :fields="fieldsInventar">
                            <template v-slot:cell(name)="data">
                                <router-link :to="{ name: 'showInventar', params: {id: data.item.id } }">
                                    {{ data.value}}
                                </router-link>
                            </template>

                            <template  v-slot:cell(qr_code)="row">
                                <qr-code :id="row.item.id" error-level="H" :size="120" :text="row.item.naziv_inventara + ' \nKoličina: '+row.item.kolicina + ' \nProstor: '+row.item.prostorija[0].prostor.opis_prostora + ' \nProstorija: '+row.item.prostorija[0].naziv_prostorije + ' \nGenerirani kod: '+row.item.generirani_kod"></qr-code>
                            </template>
                        </b-table>
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
        components: {
            notFound,
            VueCtkDateTimePicker,
        },
        data() {
            return {
                editmode: false,
                tvrtka:{},
                inventar:[],
                prostorija:[],
                prostor:[],
                fieldsInventar: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Naziv inventara',
                        key: 'naziv_inventara',
                        sortable: true,
                    },
                    {
                        label: 'Kolicina',
                        key: 'kolicina',
                        sortable: true,
                    },
                    {
                        label: 'Jedinica mjere',
                        key: 'jedinica_mjere',
                        sortable: true,
                    },
                    {
                        label: 'QR',
                        key: 'qr_code',
                    },
                    {
                        label: 'Datum nabave',
                        key: 'datum_nabave',
                        sortable: true,
                    },
                    {
                        label: 'Generirani kod',
                        key: 'generirani_kod',
                        sortable: true,
                    },
                ],
                fieldsTvrtka: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Naziv tvrtke',
                        key: 'naziv_tvrtke',
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
            loadTvrtka(){
                console.log(this.$route.params.id);
                    axios.get('/api/tvrtka/'+this.$route.params.id).then(({ data }) => (this.tvrtka = data));
            },
            
        },

        created() {
            this.loadTvrtka();
            Fire.$on('AfterCreate',() => {
                this.loadTvrtka();
            });
        }, 
    }
</script>