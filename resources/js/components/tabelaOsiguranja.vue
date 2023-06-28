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


        </section>

    </div>
</template>

<script>
import axios from 'axios';
import $ from 'jquery';
import DataTable from 'datatables.net';
import moment from 'moment';
import Swal from 'sweetalert2';

function detalji(imena, prezimena, datumiRodjenja) {
    var tableHTML = `
        <table class="table table-striped" cellpadding="5" cellspacing="0" border="1" style="padding-left:50px;">
          <tr>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Datum</th>
          </tr>`;

    for (var i = 0; i < imena.length; i++) {
        tableHTML += `
          <tr>
            <td>${imena[i]}</td>
            <td>${prezimena[i]}</td>
            <td>${datumiRodjenja[i]}</td>
          </tr>`;
    }

    tableHTML += `</table>`;

    return tableHTML;
}
export default {
    components: { DataTable },
    data() {
        return {
            table: null,
        };
    },
    methods: {


        prikaziOsiguranike() {


            var table = $('#tabelaOsiguranja').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/prikaziOsiguranja',
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
                        render: function (data, type, row) {
                            if (type === 'display') {
                                if (data === 'grupna') {
                                    return `<button class="btn btn-outline-success btnDetalji" data-id-polise="${row.idPolise}">${data}</button>`;
                                }
                            }
                            return data;
                        },
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
                        <li><a class="dropdown-item btnIzmeni" data-polisa-id="${data.idPolise}" href="#">Izmeni</a></li>
                        <li><a class="dropdown-item btnObrisi" data-polisa-id="${data.idPolise}" href="#">Obrisi</a></li>
                    </ul>
                </div>`;

                                return dropdownHtml;
                            }
                            return '';
                        }
                    }
                ],
            });

            $(document).on('click', '.btnDetalji', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var idPolise = row.data().idPolise;

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    //alert(1)
                    var imena = [];
                    var prezimena = [];
                    var datumiRodjenja = [];

                    //alert(idPolise);
                    axios.post('/prikaziOsiguranike')
                        .then(function (response) {
                            var data = response.data.data;
                            console.log('Podaci:', data);
                            //alert(idPolise)
                            data.forEach(function (item) {
                                if (item.idPolise === idPolise) {
                                    imena.push(item.ime);
                                    prezimena.push(item.prezime);
                                    var date = new Date(item.datumRodjenja);
                                    var day = (date.getDate() + 1).toString().padStart(2, '0');
                                    var month = (date.getMonth() + 1).toString().padStart(2, '0');
                                    var year = date.getFullYear();
                                    var formattedDate = `${day}.${month}.${year}`;
                                    datumiRodjenja.push(formattedDate);
                                    //alert(imena)
                                    row.child(detalji(imena, prezimena, datumiRodjenja)).show();
                                    tr.addClass('shown');
                                }
                            });
                        })
                        .catch(function (error) {

                            console.log('Greška:', error);
                        });
                }
            });

        },

        obrisiPolisu() {
            var table = $('#tabelaOsiguranja').DataTable();
            $(document).on('click', '.btnObrisi', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var idPolise = row.data().idPolise;
                //alert(idPolise)
                Swal.fire({
                    title: 'Potvrda',
                    text: 'Da li ste sigurni da želite da obrišete polisu?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Obrisi',
                    cancelButtonText: 'Odustani'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/obrisiPolisu',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                idPolise: idPolise,
                            },
                            success: function (data) {
                                $('#tabelaOsiguranja').DataTable().ajax.reload();
                            }
                        });

                        Swal.fire({
                            title: 'Uspesno ste obrisali polisu.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            });
        },
        redirectToIzmeni(idPolise) {
            localStorage.setItem('idPolise', idPolise);
            window.location.href = '/izmeni';
        },


    },
    mounted() {
        $(document).on('click', '.dropdown-toggle', function () {
            $(this).siblings('.dropdown-menu').toggle();
        });
        $(document).on('click', '.btnIzmeni', (event) => {
            event.preventDefault();
            const idPolise = $(event.currentTarget).data('polisa-id');
            //alert(idPolise)
            this.redirectToIzmeni(idPolise);
        });

        this.prikaziOsiguranike();
        this.obrisiPolisu();

    }
}
</script>