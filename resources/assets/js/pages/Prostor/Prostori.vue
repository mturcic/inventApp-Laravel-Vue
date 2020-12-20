<template>
    <div v-if="this.app.user">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Prostori</h3>
                        <div class="card-tools">
                            <a href="#" @click="newModal"><font-awesome-icon icon="plus-square" /> Novi prostor</a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <b-table  id="ProstorTable" responsive hover :items="prostori.data" :fields="fieldsProstor">
                            <template v-slot:cell(index)="data">
                                {{ data.index + 1}}
                            </template>

                            <template v-slot:cell(opis_prostora)="data">
                                <router-link :to="{ name: 'showProstor', params: {id: data.item.id}}">{{data.value}}</router-link>
                            </template>

                            <template v-slot:cell(action)="data">
                                <a href="#" @click="editModal(data.item)">
                                    <font-awesome-icon icon="edit" />
                                </a>
                                <a href="#" @click="deleteProstor(data.item.id)">
                                    <font-awesome-icon icon="trash-alt" style="color: red;"/>
                                </a>
                            </template>
                        </b-table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="prostori" @pagination-change-page="getResults"></pagination>
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Dodaj novi</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Ažuriraj</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateProstor() : createProstor()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.opis_prostora" type="text" name="opis_prostora"
                                       placeholder="Opis prostora"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('opis_prostora') }">
                                <has-error :form="form" field="opis_prostora"></has-error>
                                <br>
                                <input v-model="form.adresa_prostora" type="text" name="adresa_prostora"
                                       placeholder="Adresa prostora"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('adresa_prostora') }">
                                <has-error :form="form" field="adresa_prostora"></has-error>
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
                prostori : {},
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
                    {
                        label: 'Akcije',
                        key:'action',
                    },
                ],
                form: new Form({
                    id:'',
                    opis_prostora : '',
                    adresa_prostora : '',
                })
            }
        },
        methods: {
            getResults(page = 1) {
                axios.get('api/prostor?page=' + page)
                    .then(response => {
                        this.prostori = response.data;
                    });
            },
            updateProstor(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/prostor/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        // success
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Ažurirano!',
                            'Informacije o prostoru su uspješno ažurirane.',
                            'success'
                        )
                      
                        this.$Progress.finish();
                        
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },
            editModal(prostori){
                this.editmode = true;
                this.deleteClassModal();
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(prostori);
            },
            newModal(){
                this.deleteClassModal();
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteProstor(id){
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
                        this.form.delete('api/prostor/'+id).then(()=>{
                            Fire.$emit('AfterCreate');
                            swal.fire(
                                'Obrisano!',
                                'Prostor je uspješno obrisan.',
                                'success'
                            )
                        }).catch(()=> {
                            swal.fire("Neuspješno!", "Nešto je pošlo po zlu.", "warning");
                        });
                    }
                })
            },
            loadProstor(){
                    axios.get("api/prostor").then(({ data }) => (this.prostori = data));
            },
            deleteClassModal(){
                $('.is-invalid').removeClass("is-invalid");
                $(".invalid-feedback").removeClass("invalid-feedback");
                $(".help-block").text('');
            },
            createProstor(){
                this.$Progress.start();
                this.form.post('api/prostor')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide')
                        swal.fire(
                                'Spremljeno!',
                                'Prostor je uspješno spremljen.',
                                'success'
                            )
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                    })
            }
        },
        created() {
            this.loadProstor();
            Fire.$on('AfterCreate',() => {
                this.loadProstor();
            });
            //    setInterval(() => this.loadUsers(), 3000);
        }
    }
</script>
