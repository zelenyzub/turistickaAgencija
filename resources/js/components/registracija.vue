<template>
    <section class="vh-100 bg-image modal-overlay"
        style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
        <div class="mask d-flex align-items-center h-100 gradient-custom-3">
            <div class="container h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                        <div class="card" style="border-radius: 15px;">
                            <div class="card-body p-5">
                                <h2 class="text-uppercase text-center mb-5">Registrujte se</h2>

                                <div class="form-outline mb-4">
                                    <input type="text" id="imeKorisnika" class="form-control form-control-lg" />
                                    <label class="form-label" for="imeKorisnika">Vase Ime</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="text" id="prezimeKorisnika" class="form-control form-control-lg" />
                                    <label class="form-label" for="prezimeKorisnika">Vase Prezime</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="text" id="korisnickoIme" class="form-control form-control-lg" />
                                    <label class="form-label" for="korisnickoIme">Korisnicko Ime</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="lozinkaKorisnika" class="form-control form-control-lg" />
                                    <label class="form-label" for="lozinkaKorisnika">Lozinku</label>
                                </div>

                                <div class="form-outline mb-4">
                                    <input type="password" id="lozinkaKorisnika1" class="form-control form-control-lg" />
                                    <label class="form-label" for="lozinkaKorisnika1">Ponovite Lozinku</label>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <button type="button"
                                        class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Registrujte se</button>
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
export default {
    components: {},
    data() {
        return {

        };
    },
    methods: {

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