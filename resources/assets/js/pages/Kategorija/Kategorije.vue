<template>
    <div v-if="this.app.user">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kategorije</h3>
                        <div class="card-tools">
                            <a href="#" @click="newModal"><font-awesome-icon icon="plus-square" /> Nova kategorija</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <b-table  id="KategorijaTable" responsive hover :items="kategorije.data" :fields="fieldsKategorija">
                            <template v-slot:cell(index)="data">
                                {{ data.index + 1}}
                            </template>

                            <template v-slot:cell(naziv_kategorije)="data">
                                <router-link :to="{ name: 'showKategorija', params: {id: data.item.id}}">{{data.value}}</router-link>
                            </template>

                            <template v-slot:cell(action)="data">                                
                                <a href="#" @click="editModal(data.item)">
                                    <font-awesome-icon icon="edit" />
                                </a>
                                <a href="#" @click="deleteKategorija(data.item.id)">
                                    <font-awesome-icon icon="trash-alt" style="color: red;"/>
                                </a>
                            </template>
                        </b-table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="kategorije" @pagination-change-page="getResults"></pagination>
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
                    <form @submit.prevent="editmode ? updateKategorija() : createKategorija()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.naziv_kategorije" type="text" name="naziv_kategorije"
                                       placeholder="Naziv kategorije"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('naziv_kategorije') }">
                                <has-error :form="form" field="naziv_kategorije"></has-error>
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
    import moment from 'moment';
    import notFound from '../404';
    export default {
        props: ['app'],
        components: {
            notFound
        },
        data() {
            return {
                editmode: false,
                kategorije : {},
                fieldsKategorija: [
                    {
                        label: '#',
                        key: 'index',
                    },
                    {
                        label: 'Naziv',
                        key: 'naziv_kategorije',
                        sortable: true,
                    },
                    {
                        label: 'Akcije',
                        key:'action',

                    },
                ],
                form: new Form({
                    id:'',
                    naziv_kategorije : '',
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/kategorija?page=' + page)
                    .then(response => {
                        this.kategorije = response.data;
                    });
            },
            updateKategorija(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/kategorija/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        // success
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Ažurirano!',
                            'Informacije o kategoriji su uspješno ažurirane.',
                            'success'
                        )
                      
                        this.$Progress.finish();
                        
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

            },
            editModal(kategorije){
                this.editmode = true;
                this.deleteClassModal();
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(kategorije);
            },
            newModal(){
                this.deleteClassModal();
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteKategorija(id){
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
                        this.form.delete('api/kategorija/'+id).then(()=>{
                            Fire.$emit('AfterCreate');
                            swal.fire(
                                'Obrisano!',
                                'Kategorija je uspješno obrisana.',
                                'success'
                            )
                        }).catch(()=> {
                            swal.fire("Neuspješno!", "Nešto je pošlo po zlu.", "warning");
                        });
                    }
                })
            },
            loadKategorija(){
                    axios.get("api/kategorija").then(({ data }) => (this.kategorije = data));
            },
            deleteClassModal(){
                $('.is-invalid').removeClass("is-invalid");
                $(".invalid-feedback").removeClass("invalid-feedback");
                $(".help-block").text('');
            },

            createKategorija(){
                this.$Progress.start();

                this.form.post('api/kategorija')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide')
                        swal.fire(
                            'Spremljeno!',
                            'Kategorija je uspješno spremljena.',
                            'success'
                        )
                        this.$Progress.finish();

                    })
                    .catch(()=>{

                    })
            }
        },
        created() {
            this.loadKategorija();
            Fire.$on('AfterCreate',() => {
                this.loadKategorija();
            });
            //    setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
