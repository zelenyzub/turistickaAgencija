<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-6" v-for="item in data" :key="item.id">
                <div class="card">
                    <img :src="item.fotografija" class="card-img-top" alt="..." style="height: 500px">
                    <div class="card-body">
                        <h2 class="card-title">{{ item.naslov }}</h2>
                        <h4 class="card-text">{{ item.opis }}</h4>
                    </div>
                    <div class="card-body">
                        <p class="card-title"  v-html="item.tekst"></p>
                        <p class="card-text">Autor: {{ item.autor }}</p>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Tip Objave: {{ item.tipObjave }}</h5>
                        <h5 class="card-text">Status: {{ item.statusBloga }}</h5>
                    </div>

                    <div class="card-footer">
                        <p class="card-title">Datum Kreiranja: {{ item.datumKreiranja}}</p>
                        <p class="card-title">Datum Objavljivanja: {{item.datumObjavljivanja}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';

export default {
    data() {
        return {
            data: [],
        };
    },
    mounted() {
        this.blogovi();
    },

    methods: {
        blogovi() {
            axios.get('/blogovi')
                .then(response => {
                    this.data = response.data.map(item =>{
                        item.datumObjavljivanja = moment(item.datumObjavljivanja).add(2,'hours').format('DD.MM.YYYY. - HH:mm');
                        item.datumKreiranja = moment(item.datumKreiranja).format('DD.MM.YYYY.');
                        return item
                    });
                    
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>
