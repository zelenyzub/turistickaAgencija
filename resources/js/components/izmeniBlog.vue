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
                <input class="form-control" type="file" id="fotografija" @change="handleFotografijaChange"
                    :class="{ 'is-invalid': errors.fotografija }" accept=".jpg, .jpeg, .png">
                <p v-if="errors.fotografija" class="invalid-feedback">Niste izabrali fotografiju.</p>
            </div>

            <label for="tipObjave" class="form-label">Tip Objave</label>
            <select v-model="tipObjave" id="tipObjave" name="tipObjave" class="form-select"
                :class="{ 'is-invalid': errors.tipObjave }">
                <option disabled value="">-----Izaberite Tip Objave-----</option>
                <option value="blog">Blog</option>
                <option value="vest">Vest</option>
            </select><br>
            <p v-if="errors.tipObjave" class="invalid-feedback">Niste Uneli tip objave.</p>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input v-model="autor" type="text" class="form-control" id="autor" :class="{ 'is-invalid': errors.autor }">
                <p v-if="errors.autor" class="invalid-feedback">Niste Uneli autora.</p>
            </div>

            <input type="submit" class="btn btn-info" value="Izmeni Blog" @click="izmeniBlog">
        </section>
    </div>
</template>
<script>
import { VueEditor } from "vue2-editor";
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import Swal from 'sweetalert2';
import axios from 'axios'

export default {
    components: { VueEditor, DatePicker },
    data() {
        return {
            idPolise: '',
            tekst: '',
            naslov: '',
            opis: '',
            tipObjave: '',
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

        handleFotografijaChange(event) {
            this.selectedFotografija = event.target.files[0];
        },

        izmeniBlog() {

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
            if (this.fotografija === null) {
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
                this.autor === ''
            ) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sva polja su obavezna'
                });
                return;
            }
            const formData = new FormData();
            formData.append('idBloga', localStorage.getItem('idBloga'));
            formData.append('naslov', this.naslov);
            formData.append('opis', this.opis);
            formData.append('tekst', this.tekst);
            formData.append('fotografija', this.selectedFotografija);
            formData.append('tipObjave', this.tipObjave);
            formData.append('autor', this.autor);


            axios.post('/izmeniBlog', formData)
                .then(response => {

                    console.log(response.data);
                    //alert(this.datumOdmora)
                    window.location.href = '/tabelaBlog';

                })
                .catch(error => {
                    console.error(error);
                });

            Swal.fire({
                icon: 'success',
                title: 'Uspesno ste izmenili blog',
                timer: 1500,
                showConfirmButton: false
            });
        },

},

}
</script>