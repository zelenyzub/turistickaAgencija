<template>
    <div class="container">
        <section>
            <h1>Osiguranja</h1>
            <hr>

            <table class="table" id="tabelaOsiguranja">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ime Nosioca</th>
                        <th scope="col">Prezime Nosioca</th>
                        <th scope="col">Vrsta Polise</th>
                        <th scope="col">Telefon</th>
                        <th scope="col">Datum Pocetka</th>
                        <th scope="col">Datum Kraja</th>
                        <th scope="col">Akcije</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <table class="table" id="tabelaOsiguranici" style="display: none;">
                <thead>
                    <tr>
                        <th scope="col">Ime</th>
                        <th scope="col">Prezime</th>
                        <th scope="col">Datum Rodjenja</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </section>
    </div>
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
import DataTable from 'datatables.net';
import moment from 'moment';

export default {
    components: { DataTable },

    methods: {
        prikaziOsiguranike() {


            $('#tabelaOsiguranja').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/prikaziOsiguranike',
                },
                'columnDefs': [
                    {
                        'targets': 0,
                        'orderable': true,
                    },
                    {
                        'targets': 1,
                        'orderable': true,
                    },
                    {
                        'targets': 2,
                        'orderable': true,
                    },
                    {
                        'targets': 3,
                        'orderable': true,
                    },
                    {
                        'targets': 4,
                        'orderable': false,
                    },
                    {
                        'targets': 5,
                        'orderable': false,
                    },
                    {
                        'targets': 6,
                        'orderable': false,
                    },
                    {
                        'targets': 7,
                        'orderable': false,
                    },
                ],

                'columns': [
                    { 'data': 'idPolise' },
                    { 'data': 'imeNosiocaOsiguranja' },
                    { 'data': 'prezimeNosiocaOsiguranja' },
                    { 'data': 'vrstaPolise' },
                    { 'data': 'telefon' },
                    {
                        data: 'datumPutovanjaOd',
                        render: function (data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                var formattedDateTime = moment(data).format('DD. MM. YYYY. ');
                                return formattedDateTime;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'datumPutovanjaDo',
                        render: function (data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                var formattedDateTime = moment(data).format('DD. MM. YYYY. ');
                                return formattedDateTime;
                            }
                            return data;
                        }
                    },
                    
                    {
                        data: null,
                        render: function (data, type, row) {
                            if (type === 'display') {

                                var dropdownHtml = `
                <div class="dropdown">
                    <button class="btn btn-outline-danger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Akcije
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item btnIzmeni" data-korisnik-id="${data.idBloga}" href="#">Izmeni</a></li>
                        <li><a class="dropdown-item btnObrisi" data-korisnik-id="${data.idBloga}" href="#">Obrisi</a></li>
                    </ul>
                </div>`;

                                return dropdownHtml;
                            }
                            return '';
                        }
                    }
                ],
            });

        },
    },
    mounted() {
        $(document).on('click', '.dropdown-toggle', function () {
            $(this).siblings('.dropdown-menu').toggle();
        });
        this.prikaziOsiguranike();

    }
}
</script>