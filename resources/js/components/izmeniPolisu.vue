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


                <div v-if="vrstaOsiguranja === 'grupna'">

                    <h4>UNOS DODATNIH OSIGURANIKA</h4>

                    <label for="ime" class="form-label">Ime Osiguranika:</label>
                    <input type="text" class="form-control" id="imeOsiguranika" placeholder="Unesite ime osiguranika"
                        v-model="imeOsiguranika">


                    <label for="prezime" class="form-label">Prezime Osiguranika: </label>
                    <input type="text" class="form-control" id="prezimeOsiguranika"
                        placeholder="Unesite prezime osiguranika" v-model="prezimeOsiguranika">

                    <label for="datRodjenja" class="form-label">Datum rodjenja: </label><br>
                    <date-picker v-model="datumRodjenja" :format="'DD. MM. YYYY.'"></date-picker><br><br>

                    <input type="submit" class="btn btn-outline-primary" name="btnDodajOsiguranika" id="btnDodajOsiguranika"
                        @click="dodajOsiguranika"><br><br>
                    <hr>
                </div>
                <input type="submit" class="btn btn-outline-success form-control" name="btnDodajPolisu" id="btnDodajPolisu"
                    value="Dodaj polisu" @click="dodajPolisu">
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

export default{
    components:{DatePicker},
    data(){
        return{
            datumOdmora: null,
            brojDana: 0,
            imeNosioca: '',
            prezimeNosioca: '',
            telefon: '',
        };
    },
    methods:{
        
    },
}
</script>