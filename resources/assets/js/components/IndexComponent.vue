<template>
    <v-app>
        <v-container fill-height grid-list-md grid-list-xs text-xs-center>
            <v-layout row wrap
                      justify-space-between
                      align-top
            >
                <v-flex text-md-center md11 xs12 sm12>
                    <v-card>
                        <v-toolbar>

                            <v-toolbar-title>
                                <v-flex xs12 sm12 d-flex style="margin:10px;">
                                    <v-select
                                            :items="filters"
                                            label="Выберите фильтр"
                                            v-model="select"
                                            return-object
                                            v-on:change="changeFilter"
                                    ></v-select>
                                </v-flex>
                            </v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                                <v-btn flat>Обновить
                                    <v-icon color="indigo">refresh</v-icon>
                                </v-btn>
                                <v-btn flat>Link Two</v-btn>
                                <v-btn flat>Link Three</v-btn>
                            </v-toolbar-items>
                        </v-toolbar>

                        <v-data-table
                                :headers="headers"
                                :items="resultData"
                                v-if="resultData.length > 0"
                                :rows-per-page-items="rowperpage"
                        >
                            <template slot="items" slot-scope="props">
                                <td>
                                    <v-card flat tile style="padding: 2px;">
                                        <a :href="props.item.src" target="_blank"><v-img
                                                :src="props.item.link"
                                                :lazy-src="props.item.link"
                                                width="200"
                                        >
                                            <v-layout
                                                    slot="placeholder"
                                                    align-center
                                                    justify-center
                                                    ma-0
                                            >
                                                <v-progress-circular indeterminate
                                                                     color="grey lighten-5"></v-progress-circular>
                                            </v-layout>
                                        </v-img></a>
                                    </v-card>
                                </td>
                                <td>{{ props.item.title }}</td>
                                <td>{{ props.item.desc }}</td>
                                <td>{{ props.item.phone }}</td>
                                <td>{{ props.item.price }}</td>
                                <td><a :href="props.item.src" target="_blank">На Авито</a></td>
                                <td v-if="props.item.status == 'yes'">
                                    <v-chip color="green" text-color="white">Новая</v-chip>
                                </td>
                            </template>
                        </v-data-table>
                        <v-alert
                                :value="true"
                                type="warning"
                                v-else
                        >
                            Элементов пока нет! Включите задачу или подождите результата
                            </v-alert>
                    </v-card>

                </v-flex>
            </v-layout>
        </v-container>
    </v-app>
</template>

<script>

    export default {
        data: () => ({
            drawer: null,
            filters: null,
            headers: [
                {
                    text: 'Изображение',
                    align: 'left',
                    sortable: false,
                    value: 'name'
                },
                {text: 'Модель', value: 'calories'},
                {text: 'Описание', value: 'fat'},
                {text: 'Телефон', value: 'carbs'},
                {text: 'Цена', value: 'price'},,
                {text: 'Ссылка на Авито', value: 'protein'},
                {text: 'Статус', value: 'protein'},

            ],
            select: {},
            resultData: [],
            rowperpage: [30,60,90,{"text":"$vuetify.dataIterator.rowsPerPageAll","value":-1}]

        }),
        props: {
            source: String,
            username: String,
            routelogout: String,
            scrf: String,
        },
        methods: {
            fetchData: function () {
                axios.get('/filters')
                    .then(({data}) => {
                        this.filters = data.data
                        this.select = data.data[0]



                    })
            },
            greet: function (event) {
                document.getElementById('logout-form').submit()
            },
            changeFilter: function (event) {
                console.log('/results/' + this.select.id)
                axios.get('/results/' + this.select.id)
                    .then((({data}) => {
                        this.resultData = data.data.reverse()
                    }))
            },
        },
        created() {
            this.fetchData();
        },

    }
</script>