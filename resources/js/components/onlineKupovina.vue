<template>
    <div class="container" style="padding-bottom: 200px;">
        <h2>
            OSIGURANJE SAVO
            <small class="text-muted">Sigurnost koja prati vaše putovanje.</small>
        </h2>
        <div class="row">
            <div class="col-md-4">

                <label for="imeNosioca" class="form-label">Ime Nosioca Osiguranja:</label>
                <input v-model="imeNosioca" type="text" class="form-control" id="imeNosioca"
                    :class="{ 'is-invalid': errors.imeNosioca }" placeholder="Unesite ime nosioca osiguranja" required>
                <p v-if="errors.imeNosioca" class="invalid-feedback">
                    Niste uneli ime nosioca.
                </p>


                <label for="prezimeNosioca" class="form-label">Prezime Nosioca: </label>
                <input v-model="prezimeNosioca" type="text" class="form-control" id="prezimeNosioca"
                    placeholder="Unesite prezime nosioca osiguranja" :class="{ 'is-invalid': errors.prezimeNosioca }">
                <p v-if="errors.prezimeNosioca" class="invalid-feedback">Niste Uneli prezime nosioca.</p>


                <label for="vrstaOsiguranja" class="form-label">Vrsta Osiguranja</label>
                <select v-model="vrstaOsiguranja" id="vrstaOsiguranja" name="vrstaOsiguranja" class="form-select"
                    :class="{ 'is-invalid': errors.vrstaOsiguranja }">
                    <option disabled value="">-----Izaberite Vrstu Osiguranja-----</option>
                    <option value="individualna">Individualna</option>
                    <option value="grupna">Grupna</option>
                </select>
                <p v-if="errors.vrstaOsiguranja" class="invalid-feedback">Niste Uneli vrstu osiguranja.</p>


                <label for="telefon" class="form-label">Telefon Nosioca: </label>
                <input v-model="telefon" type="text" class="form-control" id="telefon"
                    placeholder="Unesite telefon nosioca osiguranja" :class="{ 'is-invalid': errors.telefon }">
                <p v-if="errors.telefon" class="invalid-feedback">Niste Uneli telefon.</p>

                <label for="datumPutovanja" class="form-label">Izaberite datum pocetka putovanja: </label>
                <date-picker name="datumOdmora" v-model="datumOdmora" range :format="'DD. MM. YYYY.'"
                    @input="izracunajBrojDana" :class="{ 'is-invalid': errors.datumOdmora }"></date-picker><br>
                <p v-if="errors.datumOdmora" class="invalid-feedback">Niste Uneli datum odmora.</p>

                <label for="brojDana">Ukupan broj dana:</label>
                <input type="text" class="form-control" id="brojDana" name="brojDana" :value="brojDana" disabled><br><br>
                <hr>


                <div v-if="vrstaOsiguranja === 'grupna'">

                    <h4>UNOS DODATNIH OSIGURANIKA</h4>

                    <label for="ime" class="form-label">Ime Osiguranika:</label>
                    <input type="text" class="form-control" id="imeOsiguranika" placeholder="Unesite ime osiguranika"
                        v-model="imeOsiguranika" :class="{ 'is-invalid': errors.imeOsiguranika }">
                    <p v-if="errors.imeOsiguranika" class="invalid-feedback">Niste Uneli prezime osiguranika.</p>


                    <label for="prezime" class="form-label">Prezime Osiguranika: </label>
                    <input type="text" class="form-control" id="prezimeOsiguranika"
                        placeholder="Unesite prezime osiguranika" v-model="prezimeOsiguranika"
                        :class="{ 'is-invalid': errors.prezimeOsiguranika }">
                    <p v-if="errors.prezimeOsiguranika" class="invalid-feedback">Niste Uneli prezime osiguranika.</p>

                    <label for="datRodjenja" class="form-label">Datum rodjenja: </label><br>
                    <date-picker v-model="datumRodjenja" :format="'DD. MM. YYYY.'"
                        :class="{ 'is-invalid': errors.datumRodjenja }"></date-picker>
                    <p v-if="errors.datumRodjenja" class="invalid-feedback">Niste Uneli datum rodjenja.</p><br><br>

                    <input type="submit" class="btn btn-outline-primary" name="btnDodajOsiguranika" id="btnDodajOsiguranika"
                        @click="dodajOsiguranika"><br><br>
                    <hr>
                </div>
                <input type="submit" class="btn btn-outline-success form-control" name="btnDodajPolisu" id="btnDodajPolisu"
                    value="Dodaj polisu" @click="dodajPolisu">



            </div>



            <div class="col-md-8">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec
                    malesuada nisl id elit faucibus luctus. Proin sit amet bibendum
                    leo. Aliquam erat volutpat. Sed pulvinar dui nec nulla sagittis,
                    eu fringilla massa fermentum. Nullam ac cursus ligula. Sed ullamcorper,
                    turpis id tristique eleifend, ex mi sagittis mi, non venenatis
                    purus nisl vitae magna. Sed dapibus, tortor ac efficitur
                    dignissim, massa ipsum cursus arcu, ac scelerisque mi velit
                    eu orci. Phasellus at mauris id velit sollicitudin tempus.
                    Nunc consequat tortor id lectus iaculis finibus. Nullam vitae lacinia lorem.
                    Etiam non massa ut nulla ullamcorper suscipit non vel odio. Nulla
                    facilisi. Aenean interdum tellus urna, sed hendrerit libero
                    interdum vel. Proin et ligula ut sem pharetra euismod in ac
                    enim. Aliquam commodo scelerisque ipsum ac euismod. Aliquam
                    erat volutpat. Aliquam id rhoncus neque, a fringilla ipsum.
                    Donec hendrerit libero sapien, ut malesuada odio imperdiet a.
                    Fusce gravida venenatis tellus ut scelerisque. Cras pharetra
                    sem non leo scelerisque, et rhoncus odio gravida. Mauris
                    pharetra augue eu interdum feugiat. In venenatis dolor ut interdum vulputate.</p>

                <h3 v-if="naslovListe && vrstaOsiguranja === 'grupna'">Uneti osiguranici:</h3>
                <ul v-if="vrstaOsiguranja === 'grupna'">
                    <li v-for="(osiguranik, index) in osiguranici" :key="index">
                        Ime: {{ osiguranik.ime }}<br>
                        Prezime: {{ osiguranik.prezime }}<br>
                        Datum rođenja: {{ formatirajDatum(osiguranik.datumRodjenja) }}
                        <button v-on:click="obrisiOsiguranikaIzListe(index)" class="btn btn-outline-danger">Obriši</button>
                        <hr>
                    </li>
                </ul>
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
            datumOdmora: null,
            brojDana: 0,
            vrstaOsiguranja: '',
            osiguranici: [],
            imeOsiguranika: '',
            prezimeOsiguranika: '',
            datumRodjenja: '',
            naslovListe: false,
            imeNosioca: '',
            prezimeNosioca: '',
            telefon: '',

            errors: {
                imeNosioca: false,
                prezimeNosioca: false,
                vrstaOsiguranja: false,
                telefon: false,
                datumOdmora: false,
                imeOsiguranika: false,
                prezimeOsiguranika: false,
                datumRodjenja: false
            }
        };
    },

    methods: {
        dodajPolisu() {

            this.errors = {};

            if (this.imeNosioca === '') {
                this.errors.imeNosioca = true;
            }
            if (this.prezimeNosioca === '') {
                this.errors.prezimeNosioca = true;
            }
            if (this.vrstaOsiguranja === '') {
                this.errors.vrstaOsiguranja = true;
            }
            if (this.telefon === '') {
                this.errors.telefon = true;
            }
            if (this.datumOdmora === null) {
                this.errors.datumOdmora = true;
            }

            if (
                this.imeNosioca === '' ||
                this.prezimeNosioca === '' ||
                this.vrstaOsiguranja === '' ||
                this.telefon === '' ||
                this.datumOdmora === null
            ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sva polja su obavezna'
                });
                return;
            }
            if (this.vrstaOsiguranja === 'grupna' && this.osiguranici.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Morate imati bar jednog dodatnog osiguranika u okviru grupne polise.'
                });
                return;

            }
            const polisa = {
                imeNosioca: this.imeNosioca,
                prezimeNosioca: this.prezimeNosioca,
                vrstaOsiguranja: this.vrstaOsiguranja,
                telefon: this.telefon,
                datumOdmora: this.datumOdmora
            };

            if (this.vrstaOsiguranja === 'grupna') {
                polisa.osiguranici = this.osiguranici;
            }

            axios.post('/dodajPolisu', polisa)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });

            Swal.fire({
                icon: 'success',
                title: 'Uspesno ste kupili polisu osiguranja',
                timer: 1500,
                showConfirmButton: false
            });

            this.imeNosioca = '';
            this.prezimeNosioca = '';
            this.vrstaOsiguranja = '';
            this.telefon = '';
            this.datumOdmora = null;
            this.brojDana = 0;
            this.naslovListe = false;
            this.osiguranici = [];
        },

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

        dodajOsiguranika() {
            if (this.vrstaOsiguranja === 'grupna') {

                this.errors = {};

                if (this.imeOsiguranika === '') {
                    this.errors.imeOsiguranika = true;
                }
                if (this.prezimeOsiguranika === '') {
                    this.errors.prezimeOsiguranika = true;
                }
                if (this.datumRodjenja === '') {
                    this.errors.datumRodjenja = true;
                }

                else {

                    const osiguranik = {
                        ime: this.imeOsiguranika,
                        prezime: this.prezimeOsiguranika,
                        datumRodjenja: this.datumRodjenja
                    };
                    this.osiguranici.push(osiguranik);
                    this.naslovListe = true;

                    this.imeOsiguranika = '';
                    this.prezimeOsiguranika = '';
                    this.datumRodjenja = null;
                }
            }
        },


        formatirajDatum(datumRodjenja) {
            return moment(datumRodjenja).format('DD. MM. YYYY.');
        },

        obrisiOsiguranikaIzListe(index) {
            this.osiguranici.splice(index, 1);
        },
    },
};
</script>