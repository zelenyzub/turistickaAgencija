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
                        <th scope="col">Fotografija</th>
                        <th scope="col">Tip Objave</th>
                        <th scope="col">Status</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Akcije</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <section>
                <div class="modal fade" id="pregledBloga" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Pregled Bloga</h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </section>
    </div>
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
import DataTable from 'datatables.net';
import moment from 'moment';
import Swal from 'sweetalert2';


export default {
    components: { DataTable },
    data() {
        return {
            pregled: true,
        };
    },
    methods: {
        prikaziBlogove() {
            var table = $('#tabelaBlog').DataTable({
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
                        'orderable': false,
                    },
                    {
                        'targets': 5,
                        'orderable': true,
                    },
                    {
                        'targets': 6,
                        'orderable': false,
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
                    {
                        data: 'fotografija',
                        render: function (data, type, row) {
                            if (type === 'display') {
                                var fotografijaHtml = `<img src="${data}" alt="Fotografija" width="100" style="height:100px">`;
                                return fotografijaHtml;
                            }
                            return '';
                        }
                    },
                    { 'data': 'tipObjave' },
                    { 'data': 'statusBloga' },
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
                        <li><a class="dropdown-item btnPregled" data-bs-toggle="modal" data-korisnik-id="${data.idBloga}" href="#pregledBloga">Pregled</a></li>
                        <li><a class="dropdown-item btnIzmeni" data-korisnik-id="${data.idBloga}" href="#">Izmeni</a></li>
                        <li><a class="dropdown-item btnObrisi" data-korisnik-id="${data.idBloga}" href="#">Obrisi</a></li>
                        <li><a class="dropdown-item btnObjavi" data-korisnik-id="${data.idBloga}" href="#">Objavi</a></li>
                        <li><a class="dropdown-item btnArhiviraj" data-korisnik-id="${data.idBloga}" href="#">Arhiviraj</a></li>
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


        obrisiBlog() {
            var table = $('#tabelaBlog').DataTable();
            $(document).on('click', '.btnObrisi', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var idBloga = row.data().idBloga;
                //alert(idBloga)

                Swal.fire({
                    title: 'Potvrda',
                    text: 'Da li ste sigurni da želite da obrišete blog?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Obrisi',
                    cancelButtonText: 'Odustani'
                })
                    .then((result) => {
                        if (result.isConfirmed) {
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
                                    $('#tabelaBlog').DataTable().ajax.reload();
                                }
                            });

                            Swal.fire({
                                title: 'Uspesno ste obrisali blog.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });


            });
        },

        objavi() {
            $(document).on('click', '.btnObjavi', function () {
                var table = $('#tabelaBlog').DataTable();
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var idBloga = row.data().idBloga;
                var statusBloga = row.data().statusBloga;

                if (statusBloga === 'objavljeno') {
                    Swal.fire({
                        title: 'Već objavljeno',
                        text: 'Blog je već objavljen.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                Swal.fire({
                    title: 'Potvrda',
                    text: 'Da li ste sigurni da želite da objavite blog?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Objavi',
                    cancelButtonText: 'Odustani'
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/objavi',
                                method: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    idBloga: idBloga,
                                    statusBloga: 'objavljeno',
                                    datumObjavljivanja: new Date().toISOString().slice(0, 19).replace('T', ' ')
                                },

                                success: function () {
                                    $('#tabelaBlog').DataTable().ajax.reload();
                                }
                            });

                            Swal.fire({
                                title: 'Blog je uspešno objavljen.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
            });
        },

        arhiviraj() {
            $(document).on('click', '.btnArhiviraj', function () {
                var table = $('#tabelaBlog').DataTable();
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var idBloga = row.data().idBloga;
                var statusBloga = row.data().statusBloga;

                if (statusBloga === 'arhivirano') {
                    Swal.fire({
                        title: 'Već arhivirano',
                        text: 'Blog je već arhiviran.',
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                Swal.fire({
                    title: 'Potvrda',
                    text: 'Da li ste sigurni da želite da arhivirate blog?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Arhiviraj',
                    cancelButtonText: 'Odustani'
                })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '/arhiviraj',
                                method: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    idBloga: idBloga,
                                    statusBloga: 'arhivirano',
                                    datumArhiviranja: new Date().toISOString().slice(0, 19).replace('T', ' ')
                                },

                                success: function () {
                                    $('#tabelaBlog').DataTable().ajax.reload();
                                }
                            });

                            Swal.fire({
                                title: 'Blog je uspešno arhiviran.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
            });
        },
        pregledBloga() {
            $(document).on('click', '.btnPregled', function () {
                var table = $('#tabelaBlog').DataTable();
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var blogData = row.data();

                console.log(blogData);

                var modalBodyHtml = `
                    <h2>${blogData.naslov}</h2>
                    <hr>
                    <h4>${blogData.opis}</h4>
                    <img src="${blogData.fotografija}" alt="Fotografija" width="500"><br><br><br><br>
                    <p>${blogData.tekst}</p>
                    <h5>Tip objave: ${blogData.tipObjave}</h5>
                    <h5>Status Objave: ${blogData.statusBloga}</h5><br><br><br>
                    <h4>Autor: ${blogData.autor}</h4>
        `;
                var formatDatumObjavljivanja = moment(blogData.datumObjavljivanja).add(2, 'hours').format('DD.MM.YYYY. - HH:mm');
                var modalFooterHtml = `<p>Datum Objavljivanja: ${formatDatumObjavljivanja}</p>`;
                $('#pregledBloga .modal-body').html(modalBodyHtml);
                $('#pregledBloga .modal-footer').html(modalFooterHtml);
            });
        },

    },

    mounted() {
        $(document).on('click', '.dropdown-toggle', function () {
            $(this).siblings('.dropdown-menu').toggle();
        });
        this.prikaziBlogove();
        this.obrisiBlog();
        this.objavi();
        this.arhiviraj();
        this.pregledBloga();
    }


}
</script>
