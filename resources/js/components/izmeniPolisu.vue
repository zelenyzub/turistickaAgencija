<template>
    <div class="container">
        <div class="row">
            <h2>IZMENITE PODATKE U POLISI</h2>
            <div class="col-md-4">
                <label for="imeNosioca" class="form-label">Ime Nosioca Osiguranja:</label>
                <input v-model="imeNosioca" type="text" class="form-control" id="imeNosioca"
                    placeholder="Unesite ime nosioca osiguranja" required><br>


                <label for="prezimeNosioca" class="form-label">Prezime Nosioca: </label>
                <input v-model="prezimeNosioca" type="text" class="form-control" id="prezimeNosioca"
                    placeholder="Unesite prezime nosioca osiguranja"><br>


                <label for="telefon" class="form-label">Telefon Nosioca: </label>
                <input v-model="telefon" type="text" class="form-control" id="telefon"
                    placeholder="Unesite telefon nosioca osiguranja"><br>

                <label for="datumPutovanja" class="form-label">Izaberite datum pocetka putovanja: </label>
                <date-picker name="datumOdmora" v-model="datumOdmora" range :format="'DD. MM. YYYY.'"
                    @input="izracunajBrojDana"></date-picker><br>

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

    },
}
</script>