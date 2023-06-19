<template>
    <div class="container">
        <header>
            <nav class="py-2 bg-light border-bottom">
                <div class="container d-flex flex-wrap">
                    <ul class="nav me-auto">
                        <li class="nav-item"><a href="/osiguranje" class="nav-link link-dark px-2 active"
                                aria-current="page">Pocetna</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Blog</a></li>
                        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">O nama</a></li>
                    </ul>
                    <ul class="nav">
                        <li class="nav-item"><a href="#" class="btn btn-outline-success">Uloguj se</a></li>
                        <li class="nav-item"><a href="#" class="btn btn-outline-info">Registruj se</a></li>
                    </ul>
                </div>
            </nav>
            <header class="py-3 mb-4 border-bottom">
                <div class="container d-flex flex-wrap justify-content-center">
                    <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                        <svg class="bi me-2" width="40" height="32">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <span class="fs-4">Double header</span>
                    </a>
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0">
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>
                </div>
            </header>
        </header>
        <h2>
            OSIGURANJE SAVO
            <small class="text-muted">Sigurnost koja prati vaše putovanje.</small>
        </h2>

        <div class="row">
            <div class="col-md-4">
                <label for="imeNosioca" class="form-label">Ime Nosioca Osiguranja:</label>
                <input type="text" class="form-control" id="imeNosioca" placeholder="Unesite ime nosioca osiguranja"><br>


                <label for="prezimeNosioca" class="form-label">Prezime Nosioca: </label>
                <input type="text" class="form-control" id="prezimeNosioca"
                    placeholder="Unesite prezime nosioca osiguranja"><br>


                <label for="vrstaOsiguranja" class="form-label">Vrsta Osiguranja</label>
                <select v-model="vrstaOsiguranja" id="vrstaOsiguranja" class="form-select">
                    <option disabled value="">-----Izaberite Vrstu Osiguranja-----</option>
                    <option value="individualno">Individualno</option>
                    <option value="grupno">Grupno</option>
                </select><br>


                <label for="telefon" class="form-label">Telefon Nosioca: </label>
                <input type="text" class="form-control" id="telefon" placeholder="Unesite telefon nosioca osiguranja"><br>

                <label for="datumPutovanja" class="form-label">Izaberite datum pocetka putovanja: </label>
                <date-picker v-model="datumOdmora" range :format="'DD. MM. YYYY.'"
                    @input="izracunajBrojDana"></date-picker><br>

                <label for="brojDana">Ukupan broj dana:</label>
                <input type="text" class="form-control" id="brojDana" name="brojDana" :value="brojDana" disabled><br><br>
                <hr>


                <div v-if="vrstaOsiguranja === 'grupno'">

                    <h4>UNOS DODATNIH OSIGURANIKA</h4>

                    <label for="ime" class="form-label">Ime Osiguranika:</label>
                    <input type="text" class="form-control" id="imeOsiguranika" placeholder="Unesite ime osiguranika"
                        v-model="imeOsiguranika">


                    <label for="prezime" class="form-label">Prezime Osiguranika: </label>
                    <input type="text" class="form-control" id="prezimeOsiguranika"
                        placeholder="Unesite prezime osiguranika" v-model="prezimeOsiguranika">

                    <label for="datRodjenja" class="form-label">Datum rodjenja: </label><br>
                    <date-picker v-model="datumRodjenja" :format="'DD. MM. YYYY.'"></date-picker><br>

                    <input type="submit" class="btn btn-outline-primary" name="btnDodajOsiguranika" id="btnDodajOsiguranika"
                        @click="dodajOsiguranika"><br><br>
                    <hr>
                </div>


                <input type="submit" class="btn btn-outline-success form-control" name="btnDodajOsiguranika"
                    id="btnDodajOsiguranika">
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

                <h3 v-if="naslovListe">Uneti osiguranici:</h3>
                <ul>
                    <li v-for="(osiguranik, index) in osiguranici" :key="index">
                        Ime: {{ osiguranik.ime }}<br>
                        Prezime: {{ osiguranik.prezime }}<br>
                        Datum rođenja: {{ formatirajDatum(osiguranik.datumRodjenja) }}
                        <hr>
                    </li>
                </ul>
            </div>
        </div>



        <footer>
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>
            </ul>
            <p class="text-center text-muted">© 2021 Company, Inc</p>
        </footer>
    </div>
</template>


<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment';


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

        dodajOsiguranika() {
            if (this.vrstaOsiguranja === 'grupno') {
                const osiguranik = {
                    ime: this.imeOsiguranika,
                    prezime: this.prezimeOsiguranika,
                    datumRodjenja: this.datumRodjenja
                };
                this.osiguranici.push(osiguranik);
                this.naslovListe = true;

                // Clear the form fields after adding an insured person
                this.imeOsiguranika = '';
                this.prezimeOsiguranika = '';
                this.datumRodjenja = null;
            }
        },
        formatirajDatum(datumRodjenja) {
            return moment(datumRodjenja).format('DD. MM. YYYY.');
        },
    },
};


</script>