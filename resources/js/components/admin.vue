<template>
    <div class="container">
        <header>
            <nav class="py-2 bg-light border-bottom">
                <div class="container d-flex flex-wrap">
                    <ul class="nav me-auto">
                        <li class="nav-item"><a href="/osiguranje" class="nav-link link-dark px-2 active"
                                aria-current="page">Osiguranja</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Blog</a></li>
                        <li class="nav-item"><a href="/tabelaBlog" class="nav-link link-dark px-2">Blog
                                Tabela</a></li>
                        <li class="nav-item"><a href="/tabelaOsiguranja" class="nav-link link-dark px-2">Osiguranja
                                Tabela</a></li>
                        <li class="nav-item"><a href="#" class="nav-link link-dark px-2" @click="napraviBlog = true">Napravi
                                Blog</a></li>
                    </ul>
                    <ul class="nav">

                    </ul>
                </div>
            </nav>
        </header>

        <section v-if="napraviBlog">
            <div class="mb-3">
                <label for="naslov" class="form-label">Naslov</label>
                <input v-model="naslov" type="text" class="form-control" id="naslov">
            </div>
            <div class="mb-3">
                <label for="opis" class="form-label">Opis</label>
                <input v-model="opis" type="text" class="form-control" id="opis">
            </div>

            <div class="mb-3">
                <label for="tekst" class="form-label">Tekst</label>
                <vue-editor v-model="tekst"></vue-editor>
            </div>
            <!--Fotografijaaa-->
            <div class="mb-3">
                <label for="fotografija" class="form-label">Izaberite Fotografiju</label>
                <input class="form-control" type="file" id="fotografija" @change="handleFotografijaChange">
            </div>

            <label for="tipObjave" class="form-label">Tip Objave</label>
            <select v-model="tipObjave" id="tipObjave" name="tipObjave" class="form-select">
                <option disabled value="">-----Izaberite Tip Objave-----</option>
                <option value="blog">Blog</option>
                <option value="vest">Vest</option>
            </select><br>

            <div class="mb-3">
                <label for="datumKreiranja" class="form-label">Datum Kreiranja</label><br>
                <date-picker v-model="datumKreiranja" :format="'DD. MM. YYYY.'"></date-picker>
            </div>


            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input v-model="autor" type="text" class="form-control" id="autor">
            </div>

            <!----<label for="statusBloga" class="form-label">StatusBloga</label>
            <select v-model="statusBloga" id="statusBloga" name="statusBloga" class="form-select">
                <option disabled value="">-----Izaberite Tip Objave-----</option>
                <option value="objavljeno">Objavljeno</option>
                <option value="uPripremi">U Pripremi</option>
                <option value="arhivirano">Arhivirano</option>
            </select><br>!-->

            <div class="mb-3">
                <label for="statusBloga" class="form-label">Status Bloga</label>
                <input v-model="statusBloga" type="text" class="form-control" id="statusBloga" disabled>
            </div>

            <!--<div class="mb-3">
                <label for="datumObjavljivanja" class="form-label">Datum Objavljivanja</label><br>
                <date-picker v-model="datumObjavljivanja" :format="'DD. MM. YYYY.'"></date-picker>
            </div>

            <div class="mb-3">
                <label for="datumArhiviranja" class="form-label">Datum Arhiviranja</label><br>
                <date-picker v-model="datumArhiviranja" :format="'DD. MM. YYYY.'"></date-picker>
            </div>!-->

            <input type="submit" class="btn btn-info" value="Sacuvaj" @click="sacuvajBlog">
        </section>

        <footer class="footer">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pocetna</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Blog</a></li>
                <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">O nama</a></li>
            </ul>
            <p class="text-center text-muted">© 2023 Osiguranje Savo</p>
        </footer>
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
            napraviBlog: false,
            naslov: '',
            opis: '',
            tipObjave: '',
            statusBloga: 'uPripremi',
            datumObjavljivanja: '',
            datumArhiviranja: '',
            autor: '',
            fotografija: null,
        };
    },
    methods: {

        handleFotografijaChange(event) {
            this.selectedFotografija = event.target.files[0];
        },

        sacuvajBlog() {

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
            /*const blog = {
                naslov: this.naslov,
                opis: this.opis,
                tekst: this.tekst,
                tipObjave: this.tipObjave,
                datumKreiranja: this.datumKreiranja,
                autor: this.autor,
                statusBloga: this.statusBloga,
                datumObjavljivanja: this.datumObjavljivanja,
                datumArhiviranja: this.datumArhiviranja,
                fotografija: this.fotografija,
            };*/



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

        tabelaBlog() {

        },


    },
};
</script>

<style>
@import "vue2-editor/dist/vue2-editor.css";

footer {
    position: relative;
    bottom: 0;
    width: 100%;
}

.mojNaslov {
    text-align: center;
}
</style>