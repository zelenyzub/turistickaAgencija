<template>
    <div class="container">
        <div class="row">
            <h2>IZMENITE PODATKE U POLISI</h2>
            <div class="col-md-4">
                <label for="imeNosioca" class="form-label">Ime Nosioca Osiguranja:</label>
                <input v-model="imeNosioca" type="text" class="form-control" id="imeNosioca"
                    placeholder="Unesite ime nosioca osiguranja" required :class="{'is-invalid': errors.imeNosioca}">
                    <p v-if="errors.imeNosioca" class="invalid-feedback">Niste Uneli ime nosioca.</p>


                <label for="prezimeNosioca" class="form-label">Prezime Nosioca: </label>
                <input v-model="prezimeNosioca" type="text" class="form-control" id="prezimeNosioca"
                    placeholder="Unesite prezime nosioca osiguranja" :class="{'is-invalid': errors.prezimeNosioca}">
                    <p v-if="errors.prezimeNosioca" class="invalid-feedback">Niste Uneli prezime nosioca.</p>


                <label for="telefon" class="form-label">Telefon Nosioca: </label>
                <input v-model="telefon" type="text" class="form-control" id="telefon"
                    placeholder="Unesite telefon nosioca osiguranja" :class="{'is-invalid': errors.telefon}">
                    <p v-if="errors.telefon" class="invalid-feedback">Niste Uneli telefon.</p>


                <label for="stariDatumi">Stari datumi:</label>
                <input type="text" class="form-control" id="stariDatumi" name="stariDatumi" v-model="stariDatumi" disabled>
                <label for="datumPutovanja" class="form-label">Izaberite datum pocetka putovanja: </label>
                <date-picker name="datumOdmora" v-model="datumOdmora" range :format="'DD. MM. YYYY.'"
                    @input="izracunajBrojDana" :class="{'is-invalid': errors.datumOdmora}"></date-picker>
                    <p v-if="errors.datumOdmora" class="invalid-feedback">Niste Uneli datum odmora.</p>

                <label for="brojDana">Ukupan broj dana:</label>
                <input type="text" class="form-control" id="brojDana" name="brojDana" :value="brojDana" disabled><br><br>
                <hr>

                <input hidden type="text" class="form-control" id="idPolise" name="idPolise" v-model="idPolise"><br><br>

                <input type="submit" class="btn btn-outline-success form-control" name="btnIzmeni" id="btnIzmeni"
                    value="Izmeni Polisu" @click="izmeniPolisu">
            </div>
            <div class="col-md-8">

            </div>
        </div>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment';
import axios from 'axios'
import path from 'path';
import Swal from 'sweetalert2';

export default {
    components: { DatePicker },
    data() {
        return {
            idPolise:'',
            datumOdmora: null,
            brojDana: 0,
            imeNosioca: '',
            prezimeNosioca: '',
            telefon: '',
            stariDatumi: '',

            errors:{
                imeNosioca: false,
                prezimeNosioca: false,
                telefon: false,
                datumOdmora: false
            }
        };
    },
    methods: {
        izracunajBrojDana() {
            if (this.datumOdmora && this.datumOdmora.length === 2) {
                const pocetak = moment(this.datumOdmora[0]);
                const kraj = moment(this.datumOdmora[1]);
                if (pocetak.isValid() && kraj.isValid()) {
                    this.brojDana = kraj.diff(pocetak, 'days') + 1;
                }
                else {
                    this.brojDana = 0;
                }
            }
            else {
                this.brojDana = 0;
            }
        },

        izmeniPolisu() {

            this.errors = {};

            if(this.imeNosioca === ''){
                this.errors.imeNosioca = true;
            }
            if(this.prezimeNosioca === ''){
                this.errors.prezimeNosioca = true;
            }
            if(this.telefon === ''){
                this.errors.telefon = true;
            }
            if(this.datumOdmora === null){
                this.errors.datumOdmora = true;
            }

            if (
                this.imeNosioca === '' ||
                this.prezimeNosioca === '' ||
                this.telefon === '' ||
                this.datumOdmora === null
            ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sva polja su obavezna'
                });
                return;
            }
            const polisa = {
                idPolise: localStorage.getItem('idPolise'),
                imeNosioca: this.imeNosioca,
                prezimeNosioca: this.prezimeNosioca,
                vrstaOsiguranja: this.vrstaOsiguranja,
                telefon: this.telefon,
                datumOdmora: this.datumOdmora
            };

            axios.post('/izmeniPolisu', polisa)
                .then(response => {
                    
                    console.log(response.data);
                    //alert(this.datumOdmora)
                    window.location.href = '/tabelaOsiguranja';

                })
                .catch(error => {
                    console.error(error);
                });

            Swal.fire({
                icon: 'success',
                title: 'Uspesno ste izmenili polisu osiguranja',
                timer: 1500,
                showConfirmButton: false
            });

        },
        polisaIzmeni(idPolise) {
            axios.get(`/popuniPodPolise?idPolise=${idPolise}`)
            
                .then(response => { 
                    const data = response.data;
                    this.imeNosioca = data[0].imeNosiocaOsiguranja;
                    this.prezimeNosioca = data[0].prezimeNosiocaOsiguranja;
                    this.telefon = data[0].telefon;
                    this.stariDatumi = moment(data[0].datumPutovanjaOd).format('DD.MM.YYYY') + ' - ' + moment(data[0].datumPutovanjaDo).format('DD.MM.YYYY')
                    
                    
                })
                .catch(error => {
                    console.error(error);
                });
                
        },

    },
    mounted() {
        const idPolise = localStorage.getItem('idPolise');
        if (idPolise) {
            this.polisaIzmeni(idPolise);
        }
    },
}
</script>