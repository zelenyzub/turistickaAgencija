<template>
    <section class="vh-100 bg-image modal-overlay"
        style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <a href="/osiguranje"><button type="button" class="btn-close"
                                        aria-label="Close"></button></a>
                                <h2 class="text-uppercase text-center mb-5">Uloguj se</h2>

                                <div class="form-outline mb-4">
                                    <input v-model="korisnickoIme" type="text" id="korisnickoIme" class="form-control form-control-lg" />
                                    <label class="form-label" for="korisnickoIme">Korisnicko Ime</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input v-model="lozinkaKorisnika" type="password" id="lozinkaKorisnika" class="form-control form-control-lg" />
                                    <input hidden v-model="role" type="text" id="role" value="admin"/>
                                    <label class="form-label" for="lozinkaKorisnika">Lozinku</label>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-success btn-block btn-lg gradient-custom-4 text-body"
                                        @click="login">Uloguj
                                        se</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

//import DatePicker from 'vue2-datepicker';
//import 'vue2-datepicker/index.css';
//import moment from 'moment';
//import path from 'path';
import axios from 'axios';
import Swal from 'sweetalert2';


export default {
    components: {},
    data() {
        return {
            korisnickoIme: '',
            lozinkaKorisnika: '',
            role: 'admin',
        };
    },
    methods: {
        login() {
            const podaciAdmin = {
                korisnickoIme: this.korisnickoIme,
                lozinkaKorisnika: this.lozinkaKorisnika,
                role: this.role
            };
                axios.post('/login', podaciAdmin)
                .then(response => {
                    if (response.data.success) {
                        this.$router.push('/admin');
                    }
                    else {
                        console.log(response.data.error);
                        new Swal({
                            icon: 'error',
                            title: 'Neispravni podaci za admina.'
                        });
                    }
                })
            
 
        },
    },
};
</script>
<style>
.gradient-custom-3 {
    /* fallback for old browsers */
    background: #84fab0;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(132, 250, 176, 0.5), rgba(143, 211, 244, 0.5))
}

.gradient-custom-4 {
    /* fallback for old browsers */
    background: #84fab0;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right, rgba(132, 250, 176, 1), rgba(143, 211, 244, 1))
}
</style>