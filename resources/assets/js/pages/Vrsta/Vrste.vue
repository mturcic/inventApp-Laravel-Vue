<template>
    <div v-if="this.app.user">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Vrste</h3>
                        <div class="card-tools">
                            <a href="#" @click="newModal"><font-awesome-icon icon="plus-square" /> Nova vrsta</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <b-table  id="VrstaTable" responsive hover :items="vrste.data" :fields="fieldsVrsta">
                            <template v-slot:cell(index)="data">
                                {{ data.index + 1}}
                            </template>

                            <template v-slot:cell(naziv_vrste)="data">
                                <router-link :to="{ name: 'showVrsta', params: {id: data.item.id}}">{{data.value}}</router-link>
                            </template>

                            <template v-slot:cell(action)="data">
                                <a href="#" @click="editModal(data.item)">
                                    <font-awesome-icon icon="edit" />
                                </a>
                                <a href="#" @click="deleteVrsta(data.item.id)">
                                    <font-awesome-icon icon="trash-alt" style="color: red;"/>
                                </a>
                            </template>
                        </b-table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="vrste" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Dodaj novu</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Ažuriraj</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateVrsta() : createVrsta()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.naziv_vrste" type="text" name="naziv_vrste"
                                       placeholder="Naziv vrste"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('naziv_vrste') }">
                                <has-error :form="form" field="naziv_vrste"></has-error>
                            </div>

                            <div class="form-group">
                                    <select class="form-control"  v-model="form.kategorija_id" name="kategorija_id"  :class="{ 'is-invalid': form.errors.has('kategorija_id') }">
                                        <option disabled   value="0">--Odaberite kategoriju--</option>
                                        <option
                                            v-for="col in kategorije"
                                            :value="col.id"
                                            :key="col.id"
                                        >{{ col.naziv_kategorije }}</option>
                                    </select>
                                    <has-error :form="form" field="kategorija_id"></has-error>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Natrag</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Ažuriraj</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Spremi</button>
                        </div>
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
<script src="https://kit.fontawesome.com/d83d2b8d88.js" crossorigin="anonymous"></script>
<script>
    import notFound from '../404';
    import moment from 'moment';
    export default {
        props: ['app'],
        components: {
            notFound
        },
        data() {
            return {
                editmode: false,
                vrste : {},
                kategorije : {},
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
                    {
                        label: 'Kategorija',
                        key: 'kategorija.naziv_kategorije',
                        sortable: true,
                    },
                    {
                        label: 'Akcije',
                        key:'action',

                    },
                ],
                form: new Form({
                    id:'',
                    naziv_vrste : '',
                    kategorija_id : 0,
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/vrsta?page=' + page)
                    .then(response => {
                        this.vrste = response.data;
                    });
            },
            updateVrsta(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/vrsta/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        // success
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Ažurirano!',
                            'Informacije o vrsti su uspješno ažurirane.',
                            'success'
                        )
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },
            editModal(vrste){
                this.editmode = true;
                this.deleteClassModal();
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(vrste);
            },
            newModal(){
                this.deleteClassModal();
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteVrsta(id){
                swal.fire({
                    title: 'Jeste li sigurni?',
                    text: "Nećete moći poništiti ovo!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Brisanje',
                    cancelButtonText: 'Odustani'
                }).then((result) => {

                    // Send request to the server
                    if (result.value) {
                        this.form.delete('api/vrsta/'+id).then(()=>{
                            Fire.$emit('AfterCreate');
                            swal.fire(
                                'Obrisano!',
                                'Vrsta je uspješno obrisana.',
                                'success'
                            )
                        }).catch(()=> {
                            swal.fire("Neuspješno!", "Nešto je pošlo po zlu.", "warning");
                        });
                    }
                })
            },
            loadVrsta(){
                    axios.get("api/vrsta").then(({ data }) => (this.vrste = data));
            },
            loadKategorija(){
                    axios.get("api/kategorije").then(({ data }) => (this.kategorije = data));
            },
            deleteClassModal(){
                $('.is-invalid').removeClass("is-invalid");
                $(".invalid-feedback").removeClass("invalid-feedback");
                $(".help-block").text('');
            },

            createVrsta(){
                this.$Progress.start();

                this.form.post('api/vrsta')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide')
                        swal.fire(
                            'Spremljeno!',
                            'Vrsta je uspješno spremljena.',
                            'success'
                        )
                        this.$Progress.finish();

                    })
                    .catch(()=>{

                    })
            }
        },
        created() {
            this.loadVrsta();
            this.loadKategorija();
            Fire.$on('AfterCreate',() => {
                this.loadVrsta();
            });
            //    setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
