<template>
    <div v-if="this.app.user">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Inventar</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm">
                                <div class="col-md-6">
                                    <a href="#" @click="newModal"><font-awesome-icon icon="plus-square" /> Nova stavka</a>
                                </div>
                                <div class="col-md-6">
                                    <div class="right">
                                       <b-form-input size="sm"  @keyup="searchit" v-model="search" type="search" placeholder="Pretraživanje inventara" aria-label="Search"></b-form-input>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <b-table
                        id="InventarTable" 
                        hover 
                        :items="inventar.data" 
                        :fields="fieldsInventar" 
                        striped 
                        responsive="sm">
                            
                        <template v-slot:cell(naziv_inventara)="row">
                            <b-button
                                pill variant="info"
                                @click="row.toggleDetails">
                                {{row.item.naziv_inventara}}
                            </b-button>  
                        </template>

                        <template v-slot:row-details="row">
                            <b-card>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Prostor:</b></b-col>
                                    <b-col v-for="col in row.item.prostorija" :key="col.id">{{ col.prostor.opis_prostora }}</b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Prostorija:</b></b-col>
                                    <b-col v-for="col in row.item.prostorija" :key="col.id">{{ col.naziv_prostorije }}</b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Tvrtka:</b></b-col>
                                    <b-col>{{ row.item.tvrtka.naziv_tvrtke }}</b-col>
                                </b-row>
                                
                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Napomena:</b></b-col>
                                    <b-col>{{ row.item.napomena }}</b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Stopa amortizacije:</b></b-col>
                                    <b-col>{{ row.item.stopa_amortizacije }}</b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Nabavna vrijednost:</b></b-col>
                                    <b-col>{{ row.item.nabavna_vrijednost }}</b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Otpis inventara:</b></b-col>
                                    <b-col>{{ row.item.otpis_inventara }}</b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Ulazna faktura:</b></b-col>
                                    <b-col>{{ row.item.ulazna_faktura }}</b-col>
                                    <b-col>
                                        <b-button 
                                            variant="info"
                                        	a :href="'documents/'+row.item.ulazna_faktura" 
                                            target="blank">Faktura
                                        </b-button>
                                    </b-col>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Slika inventara:</b></b-col>
                                        <b-img center 
                                        :src="'images/'+row.item.slika_inventara" 
                                        width="150" 
                                        alt="Slika inventara">
                                        </b-img>
                                </b-row>

                                <b-row class="mb-2">
                                    <b-col sm="3" class="text-sm-right"><b>Godina nabave</b></b-col>
                                    <b-col>{{ row.item.godina_nabave }}</b-col>
                                </b-row>
                            </b-card>
                        </template>


                        <template  v-slot:cell(qr_code)="row">
                            <qr-code :id="row.item.id" error-level="H" :size="120" :text="qr_code(row)"></qr-code>
                        </template>

                        <template v-slot:cell(prostorija)="data" >
                            <tr v-for="item in data.item.prostorija" :key="item.id">
                                {{item.naziv_prostorije }}
                            </tr>
                        </template>

                        <template v-slot:cell(prostor)="data" >
                            <tr v-for="item in data.item.prostorija" :key="item.id">
                                {{item.prostor.opis_prostora }}
                            </tr>
                        </template>

                        <template v-slot:cell(action)="data">
                                
                            <a href="#" @click="editModal(data.item)">
                                <font-awesome-icon icon="edit" />
                            </a>
                                
                            <a href="#" @click="deleteInventar(data.item.id)">
                                <font-awesome-icon icon="trash-alt" style="color: red;"/>
                            </a>
                            <br>
                            <b-button variant="link" v-print="'#'+data.item.id">
                                <font-awesome-icon icon="print"/>
                            </b-button>

                        </template>
                        </b-table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="inventar" @pagination-change-page="getResults"></pagination>
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
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Dodaj novu stavku</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Ažuriraj</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateInventar() : createInventar()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.naziv_inventara" type="text" name="naziv_inventara"
                                       placeholder="Naziv inventara"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('naziv_inventara') }">
                                <has-error :form="form" field="naziv_inventara"></has-error>
                                <br>
                                <div>
                                <strong>Slika:</strong>
                                <b-container fluid class="p-3 bg-dark">
                                    <b-img center
                                        :src="getPhoto()" 
                                        width="150" 
                                        alt="Slika inventara">
                                    </b-img>
                                </b-container>
                                <br>
                                <b-form-file
                                    :class="{ 'is-invalid': form.errors.has('slika_inventara') }"
                                    name="slika_inventara"
                                    @change='uploadPhoto'
                                    ref="uploadfile"
                                    :file-name-formatter="formatNames"
                                    v-model="attachments"
                                    placeholder="Nije odabrana niti jedna datoteka"
                                    browse-text="Odaberi"
                                    drop-placeholder="Ovdje ispusti datoteku/e">
                                </b-form-file> 
                                 <has-error :form="form" field="slika_inventara"></has-error>

                                </div>  
                                <br>
                                <b-form-group
                                    id="ctkDTP"
                                    link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/vue-ctk-date-time-picker@1.4.1/dist/vue-ctk-date-time-picker.css">
                                    <vue-ctk-date-time-picker only-date input-size="lg" color="black" auto-close format="YYYY-MM-DD" formatted="ll" label="Datum nabave" v-model="form.datum_nabave"></vue-ctk-date-time-picker>
                                </b-form-group>
                                <br>
                                <input v-model="form.godina_nabave" type="number" name="godina_nabave"
                                       placeholder="Godina nabave"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('godina_nabave') }">
                                <has-error :form="form" field="godina_nabave"></has-error>
                                <br>
                                <input v-model="form.nabavna_vrijednost" type="text" name="nabavna_vrijednost"
                                       placeholder="Nabavna vrijednost"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('nabavna_vrijednost') }">
                                <has-error :form="form" field="nabavna_vrijednost"></has-error>
                                <br>
                                <input v-model="form.stopa_amortizacije" type="text" name="stopa_amortizacije"
                                       placeholder="Stopa amortizacije" step="any"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('stopa_amortizacije') }">
                                <has-error :form="form" field="stopa_amortizacije"></has-error>
                                <br>
                                <input v-model="form.kolicina" type="text" name="kolicina"
                                       placeholder="Količina"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('kolicina') }">
                                <has-error :form="form" field="kolicina"></has-error>
                                <br>
                                <input v-model="form.jedinica_mjere" type="text" name="jedinica_mjere"
                                       placeholder="Jedinica mjere"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('jedinica_mjere') }">
                                <has-error :form="form" field="jedinica_mjere"></has-error>
                                <br>
                                <input v-model="form.napomena" type="text" name="napomena"
                                       placeholder="Napomena"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('napomena') }">
                                <has-error :form="form" field="napomena"></has-error>
                                <br>
                                <div>
                                <strong>Faktura:</strong>
                                <br>
                                <b-form-file
                                    :class="{ 'is-invalid': form.errors.has('ulazna_faktura') }"
                                    name="ulazna_faktura"
                                    @change='uploadPdf'
                                    ref="uploadPdf"
                                    :file-name-formatter="formatNames"
                                    v-model="documents"
                                    placeholder="Nije odabrana niti jedna datoteka"
                                    browse-text="Odaberi"
                                    drop-placeholder="Ovdje ispusti datoteku/e">
                                </b-form-file> 
                                 <has-error :form="form" field="ulazna_faktura"></has-error>
                                </div>  
                                <br>
                                <input v-model="form.otpis_inventara" type="text" name="otpis_inventara"
                                       placeholder="Otpis inventara"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('otpis_inventara') }">
                                <has-error :form="form" field="otpis_inventara"></has-error>
                                <br>
                                <input v-model="form.generirani_kod" type="text" name="generirani_kod"
                                       placeholder="Generirani kod"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('generirani_kod') }">
                                <has-error :form="form" field="generirani_kod"></has-error>
                                <br>
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
                                <div class="form-group" v-if="form.kategorija_id !=0">
                                    <select class="form-control"  v-model="form.vrsta_id" name="vrsta_id"  :class="{ 'is-invalid': form.errors.has('vrsta_id') }">
                                        <option disabled   value="0">--Odaberite vrstu--</option>
                                        <option
                                            v-for="col in vrste"
                                            :value="col.id"
                                            :key="col.id"
                                        >{{ col.naziv_vrste }}</option>
                                    </select>
                                    <has-error :form="form" field="vrsta_id"></has-error>
                                </div>
                                <div class="form-group">
                                    <select class="form-control"  v-model="form.tvrtka_id" name="tvrtka_id"  :class="{ 'is-invalid': form.errors.has('tvrtka_id') }">
                                        <option disabled   value="0">--Odaberite tvrtku--</option>
                                        <option
                                            v-for="col in tvrtke"
                                            :value="col.id"
                                            :key="col.id"
                                        >{{ col.naziv_tvrtke }}</option>
                                    </select>
                                    <has-error :form="form" field="tvrtka_id"></has-error>
                                </div>
                                <div class="form-group">
                                    <b-form-select v-model="form.prostorija_id" :options="options" multiple :select-size="4">
                                        <option disabled   value="0">--Odaberite prostoriju--</option>
                                        <option
                                            v-for="col in prostorije"
                                            :value="col.id"
                                            :key="col.id"
                                        >{{col.naziv_prostorije}}</option>
                                    </b-form-select>
                                    <div class="mt-3">Selected: <strong>{{ form.prostorija_id }}</strong></div>
                                </div>
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
    import _ from 'lodash'
    import notFound from '../404';
    import moment from 'moment';
    export default {
        props: ['app'],
        components: {
            notFound
        },
        data() {
            return {
                printObj: {
                    id: "printMe",
                    popTitle: 'print'
                },
                editmode: false,
                inventar : {}, 
                kategorije:{},
                vrste: {},
                tvrtke: {},
                prostorije: {},
                options: [],
                image: '',
                success: '',
                attachments: [],
                documents: [],
                search : '',
                fieldsInventar: [
                    {
                        label: '#',
                        key: 'id',
                    },
                    {
                        label: 'Naziv inventara',
                        key: 'naziv_inventara',
                        sortable: true,
                    },
                    {
                        label: 'Kategorija',
                        key: 'vrsta.kategorija.naziv_kategorije',
                        sortable: true,
                    },
                    {
                        label: 'Vrsta',
                        key: 'vrsta.naziv_vrste',
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
                    {
                        label: 'Akcije',
                        key:'action',
                    },
                ],
                form: new Form({
                    id:'',
                    naziv_inventara : '',
                    slika_inventara : '',
                    datum_nabave : '',
                    godina_nabave : '',
                    nabavna_vrijednost : '',
                    stopa_amortizacije : '',
                    kolicina : '',
                    jedinica_mjere : '',
                    napomena : '',
                    ulazna_faktura : '',
                    otpis_inventara : '',
                    generirani_kod : '',
                    kategorija_id: 0,
                    vrsta_id: 0,
                    tvrtka_id: 0,
                    prostorija_id: [],
                }),
                formFile: new FormData,
            }
        },
        methods: {

            qr_code(row){


                let qr_code=row.item.naziv_inventara+ '\nKolicina: '+ row.item.kolicina+ '\nUF: '+  row.item.ulazna_faktura + '\nKategorija: ' + row.item.vrsta.kategorija.naziv_kategorije + '\nVrsta: '+ row.item.vrsta.naziv_vrste+ '\nProstorije: ';

                 for (let i = 0; i < row.item.prostorija.length; i++) {
                    //console.log(qr_code);
                    qr_code= qr_code.concat('\n'+ row.item.prostorija[i].naziv_prostorije + ' - '+  row.item.prostorija[i].prostor.opis_prostora)
                   
                }

                return qr_code

                //"row.item.naziv_inventara + ' \nKoličina: '+row.item.kolicina + ' \nProstor: '+row.item.prostorija[0].prostor.opis_prostora + ' \nProstorija: '+row.item.prostorija[0].naziv_prostorije + ' \nKategorija: '+row.item.kategorija[0].naziv_kategorije + ' \nProstorija: '+row.item.prostorija[0].naziv_prostorije"


            },
            formatNames(files) {
                if (files.length === 1) {
                    return files[0].name
                } else if (files.length === 2 || files.length === 3 || files.length === 4) {
                    return `${files.length} odabrane datoteke`
                } else {
                    return `${files.length} odabranih datoteka`
                }
            },
            getResults(page = 1) {
                axios.get('api/inventar?page=' + page)
                    .then(response => {
                        this.inventar = response.data;
                    });
            },
            updateInventar(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/inventar/'+this.form.id)
                    .then(() => {
                        Fire.$emit('AfterCreate');
                        // success
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Ažurirano!',
                            'Informacije o stavki inventara uspješno ažurirane.',
                            'success'
                        )
                      
                        this.$Progress.finish();
                        
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });

            },
            editModal(inventar){
                this.$refs.uploadfile.reset();
                this.editmode = true;
                this.deleteClassModal();
                this.form.reset();
                $('#addNew').modal('show');
                
                this.form.fill(inventar);

                this.form.prostorija_id=[];
                for (let i = 0; i < inventar.prostorija.length; i++) {
                    this.form.prostorija_id.push(inventar.prostorija[i].id);
                }

                this.form.kategorija_id=inventar.vrsta.kategorija.id
            },
            newModal(){
                this.deleteClassModal();
                this.editmode = false;
                this.form.reset();
                this.$refs.uploadfile.reset();
                $('#addNew').modal('show');
            },
    
            deleteInventar(id){
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
                        this.form.delete('api/inventar/'+id).then(()=>{
                            Fire.$emit('AfterCreate');
                            swal.fire(
                                'Obrisano!',
                                'Stavka inventara je uspješno obrisana.',
                                'success'
                            )
                        }).catch(()=> {
                            swal.fire("Neuspješno!", "Nešto je pošlo po zlu.", "warning");
                        });
                    }
                })
            },
            loadInventar(){
                    axios.get("api/inventar").then(({ data }) => (this.inventar = data));
            },
            loadKategoprije(){
                    axios.get("api/kategorije").then(({ data }) => (this.kategorije = data));
            },
            loadVrste(){
                    axios.get("api/vrste").then(({ data }) => (this.vrste = data));
            },
            loadTvrtke(){
                    axios.get("api/tvrtke").then(({ data }) => (this.tvrtke = data));
            },
            loadProstorije(){
                    axios.get("api/prostorije").then(({ data }) => (this.prostorije = data));
            },
            loadProstori(){
                    axios.get("api/prostori").then(({ data }) => (this.prostori = data));
            },
            deleteClassModal(){
                $('.is-invalid').removeClass("is-invalid");
                $(".invalid-feedback").removeClass("invalid-feedback");
                $(".help-block").text('');
            },

            createInventar(){
                this.$Progress.start();

                  for (let i = 0; i < this.attachments.length; i++) {
                      console.log(this.attachments.length);
                    this.formFile.append('slika_inventara[]', this.attachments[i]);
                }

                 for (let i = 0; i < this.documents.length; i++) {
                     console.log('Dokument: '+this.documents.length);
                    this.formFile.append('ulazna_faktura[]', this.documents[i]);
                }
                this.formFile.append('ulazna_faktura', this.documents);
                this.formFile.append('slika_inventara', this.attachments);
                this.formFile.append('naziv_inventara', this.form.naziv_inventara);
                this.formFile.append('datum_nabave', this.form.datum_nabave);
                this.formFile.append('godina_nabave', this.form.godina_nabave);
                this.formFile.append('nabavna_vrijednost', this.form.nabavna_vrijednost);
                this.formFile.append('stopa_amortizacije', this.form.stopa_amortizacije);
                this.formFile.append('kolicina', this.form.kolicina);
                this.formFile.append('jedinica_mjere', this.form.jedinica_mjere);
                this.formFile.append('napomena', this.form.napomena);;
                this.formFile.append('otpis_inventara', this.form.otpis_inventara);
                this.formFile.append('generirani_kod', this.form.generirani_kod);
                this.formFile.append('kategorija_id', this.form.kategorija_id);
                this.formFile.append('vrsta_id', this.form.vrsta_id);
                this.formFile.append('tvrtka_id', this.form.tvrtka_id);
                for (var i = 0; i < this.form.prostorija_id.length; i++) {
                    this.formFile.append("prostorija_id[" + i + "]", this.form.prostorija_id[i])
                }
               
                const config = {headers: {'Content-Type': 'multipart/form-data'}};

                axios.post('api/inventar', this.formFile, config).then(response => {
                    if (response.data.error) {
                        console.log(response.data.error)
                        $('#addNew').modal('hide');
                        swal.fire("Neuspješno!", response.data.error, "error");
                        this.$refs.uploadfile.reset();
                        this.attachments=[];
                        this.formFile= new FormData;
                        this.$Progress.finish();

                    } else {
                         Fire.$emit('AfterCreate');
                        $('#addNew').modal('hide')
                        //document.getElementById('upload-file').value=[];
                        this.attachments = [];
                        this.form.reset();
                        this.formFile= new FormData;
                        this.documents=[];
                        this.$refs.uploadfile.reset();

                        toast.fire({
                            type: 'success',
                            title: 'Stavka je spremljena'
                        });
                        this.$Progress.finish();
                    }
                })
                    .catch(response => {
                        //error
                    });
            },

            uploadPhoto(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                if(file['size'] < 5111775)
                {
                    reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.form.slika_inventara = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    alert('Veličina slike ne može biti preko 5MB')
                }
            },

            uploadPdf(e){
                let file = e.target.files[0];
                let reader = new FileReader();

                if(file['size'] < 5111775)
                {
                    reader.onloadend = (file) => {
                    //console.log('RESULT', reader.result)
                    this.form.ulazna_faktura = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    alert('Veličina dokumenta ne može biti preko 5MB')
                }
            },

            getPhoto(){
            
                let photo = this.form.slika_inventara.length >100  ? this.form.slika_inventara : "/images/"+ this.form.slika_inventara;
                return photo;
            },
           searchit: _.debounce(() => {
            Fire.$emit('searching');
            },1000),
        },
        created() {
            this.loadInventar();
            this.loadKategoprije();
            this.loadVrste();
            this.loadTvrtke();
            this.loadProstorije();
            
            Fire.$on('searching',() => {
                let query = this.search;
                axios.get('api/findInventar?q=' + query)
                    .then((data) => {
                        this.inventar = data.data
                    })
                    .catch(() => {
                    })
            })
            this.loadInventar();
            Fire.$on('AfterCreate',() => {
                this.loadInventar();
            });
            //    setInterval(() => this.loadUsers(), 3000);
        },
    }
</script>
<style scoped>
.right {
  position: absolute;
  right: 0px;
  top: -25px;
}
.col-md-6 {
    padding-left: 1px;
}
</style>