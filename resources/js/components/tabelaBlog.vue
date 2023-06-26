<template>
    <div class="container">
        <section>
            <h1>Blogovi</h1>
            <hr>

            <table class="table" id="tabelaBlog">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Datum Kreiranja</th>
                        <th scope="col">Naslov</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Tip Objave</th>
                        <th scope="col">Status</th>
                        <th scope="col">Datum Objavljivanja</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Akcije</th>
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
        prikaziBlogove() {
            $('#tabelaBlog').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/prikazBlog',
                },
                'columnDefs': [
                    {
                        'targets': 0,
                        'orderable': true,
                    },
                    {
                        'targets': 1,
                        'orderable': false,
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
                        'orderable': true,
                    },
                    {
                        'targets': 5,
                        'orderable': true,
                    },
                    {
                        'targets': 6,
                        'orderable': true,
                    },
                    {
                        'targets': 7,
                        'orderable': false,
                    },
                    {
                        'targets': 8,
                        'orderable': false,
                    },
                ],

                'columns': [
                    { 'data': 'idBloga' },
                    {
                        data: 'datumKreiranja',
                        render: function (data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                var formattedDateTime = moment(data).format('DD. MM. YYYY.');
                                return formattedDateTime;
                            }
                            return data;
                        }
                    },
                    { 'data': 'naslov' },
                    { 'data': 'opis' },
                    {'data': 'tipObjave'},
                    { 'data': 'statusBloga' },
                    {
                        data: 'datumObjavljivanja',
                        render: function (data, type, row) {
                            if (type === 'display' || type === 'filter') {
                                var formattedDateTime = moment(data).format('DD. MM. YYYY.');
                                return formattedDateTime;
                            }
                            return data;
                        }
                    },
                    { 'data': 'autor' },
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
                        <li><a class="dropdown-item btnPregled" data-korisnik-id="${data.idBloga}" href="#">Pregled</a></li>
                        <li><a class="dropdown-item btnIzmeni" data-korisnik-id="${data.idBloga}" href="#">Izmeni</a></li>
                        <li><a class="dropdown-item btnObrisi" data-korisnik-id="${data.idBloga}" href="#">Obrisi</a></li>
                        <li><a class="dropdown-item btnObjavi" data-korisnik-id="${data.idBloga}" href="#">Objavi</a></li>
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


        obrisiBlog(idBloga) {
            $(document).on('click', '.btnObrisi', function () {
                $.ajax({
                    url: '/obrisiBlog',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        idBloga: idBloga,
                    },

                    success: function (data) {
                        $('#tabelaKorisnici').DataTable().ajax.reload();
                    }
                });
            });
        },

    },

    mounted() {
        $(document).on('click', '.dropdown-toggle', function () {
            $(this).siblings('.dropdown-menu').toggle();
        });
        this.prikaziBlogove();

        this.obrisiBlog();
    }


}
</script>
