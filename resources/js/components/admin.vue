<template>
    <div class="container">

        <section>
            <div class="mb-3">
                <label for="naslov" class="form-label">Naslov</label>
                <input v-model="naslov" type="text" class="form-control" id="naslov" :class="{ 'is-invalid': errors.naslov }">
                <p v-if="errors.naslov" class="invalid-feedback">Niste Uneli naslov.</p>
            </div>
            <div class="mb-3">
                <label for="opis" class="form-label">Opis</label>
                <input v-model="opis" type="text" class="form-control" id="opis" :class="{ 'is-invalid': errors.opis }">
                <p v-if="errors.opis" class="invalid-feedback">Niste Uneli opis.</p>
            </div>

            <div class="mb-3">
                <label for="tekst" class="form-label">Tekst</label>
                <vue-editor v-model="tekst" :class="{ 'is-invalid': errors.tekst }"></vue-editor>
                <p v-if="errors.tekst" class="invalid-feedback">Niste Uneli tekst.</p>
            </div>
            <!--Fotografijaaa-->
            <div class="mb-3">
                <label for="fotografija" class="form-label">Izaberite Fotografiju</label>
                <input class="form-control" type="file" id="fotografija" @change="handleFotografijaChange" accept=".jpg, .jpeg, .png"
                    :class="{ 'is-invalid': errors.fotografija }">
                <p v-if="errors.fotografija" class="invalid-feedback">Niste izabrali fotografiju.</p>
            </div>

            <label for="tipObjave" class="form-label">Tip Objave</label>
            <select v-model="tipObjave" id="tipObjave" name="tipObjave" class="form-select"
                :class="{ 'is-invalid': errors.tipObjave }">
                <option disabled value="">-----Izaberite Tip Objave-----</option>
                <option value="blog">Blog</option>
                <option value="vest">Vest</option>
            </select><br>
            <p v-if="errors.tipObjave" class="invalid-feedback">Niste Uneli tip.</p>

            <div class="mb-3">
                <label for="datumKreiranja" class="form-label">Datum Kreiranja</label><br>
                <date-picker v-model="datumKreiranja" :format="'DD. MM. YYYY.'" :disabled-date="disabledDate"></date-picker>
            </div>


            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input v-model="autor" type="text" class="form-control" id="autor" :class="{ 'is-invalid': errors.autor }">
                <p v-if="errors.autor" class="invalid-feedback">Niste Uneli autora.</p>
            </div>

            <div class="mb-3">
                <label for="statusBloga" class="form-label">Status Bloga</label>
                <input v-model="statusBloga" type="text" class="form-control" id="statusBloga" disabled>
            </div>

            <input type="submit" class="btn btn-info" value="Sacuvaj" @click="sacuvajBlog">
        </section>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import Swal from 'sweetalert2';
import axios from 'axios'
import { format } from "path";

export default {
    components: { VueEditor, DatePicker },
    data() {
        return {

            tekst: '',
            datumKreiranja: new Date(),
            naslov: '',
            opis: '',
            tipObjave: '',
            statusBloga: 'uPripremi',
            datumObjavljivanja: '',
            datumArhiviranja: '',
            autor: '',
            fotografija: null,
            selectedFotografija: null,

            errors: {
                naslov: false,
                opis: false,
                tekst: false,
                fotografija: false,
                tipObjave: false,
                autor: false
            }
        };
    },
    methods: {

        disabledDate(date) {
            const datumOdmora = new Date();
            return date < datumOdmora;
        },

        handleFotografijaChange(event) {
            this.selectedFotografija = event.target.files[0];
        },

        sacuvajBlog() {

            this.errors = {};

            if (this.naslov === '') {
                this.errors.naslov = true;
            }
            if (this.opis === '') {
                this.errors.opis = true;
            }
            if (this.tekst === '') {
                this.errors.tekst = true
            }
            if (this.fotografija === '') {
                this.errors.fotografija = true;
            }
            
            if (this.tipObjave === '') {
                this.errors.tipObjave = true
            }
            if (this.autor === '') {
                this.errors.autor = true;
            }

            if (
                this.naslov === '' ||
                this.opis === '' ||
                this.tekst === '' ||
                this.tipObjave === '' ||
                this.datumKreiranja === '' ||
                this.autor === '' ||
                this.statusBloga === ''
            ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sva polja su obavezna'
                });
                return;
            }

            const formData = new FormData();
            formData.append('naslov', this.naslov);
            formData.append('opis', this.opis);
            formData.append('tekst', this.tekst);
            formData.append('fotografija', this.selectedFotografija);
            formData.append('tipObjave', this.tipObjave);
            formData.append('datumKreiranja', this.datumKreiranja.toISOString());
            formData.append('autor', this.autor);
            formData.append('statusBloga', this.statusBloga);


            axios.post('/sacuvajBlog', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    console.log(response.data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Uspesno ste sacuvali vas blog.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                })
                .catch(error => {
                    console.log(error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Greska'
                    });
                });

            this.naslov = '';
            this.opis = '';
            this.tekst = '';
            this.tipObjave = '';
            this.datumKreiranja = new Date();
            this.autor = '';
            this.statusBloga = 'uPripremi';
        },

    },
};
</script>
