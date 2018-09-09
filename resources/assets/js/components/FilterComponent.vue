<template>
    <v-app>
        <v-container fill-height grid-list-md  grid-list-xs text-xs-center>
            <v-layout row wrap justify-space-between align-top>
                <v-flex text-md-center md8 xs12 sm12 >
                    <v-card>

                        <v-toolbar>
                            <v-toolbar-title><v-icon>filter_list</v-icon> Список фильтров</v-toolbar-title>



                        </v-toolbar>

                        <v-list>
                            <v-list-tile
                                    v-for="item in rightItems"
                                    :key="item.text"
                                    @click="act"
                            >
                                <v-list-tile-action>
                                    <v-icon>list</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>{{ item.text }}</v-list-tile-title>
                                </v-list-tile-content>
                                <v-chip color="green" text-color="white" v-if="item.news">
                                    <v-avatar class="green darken-4">7</v-avatar>
                                    новое
                                </v-chip>
                                <v-list-tile-action>
                                    <v-btn icon ripple>
                                        <v-icon color="warning">play_circle_outline</v-icon>
                                    </v-btn>
                                </v-list-tile-action>

                                <v-list-tile-action v-show="false" isSelect>
                                    <v-btn icon ripple>
                                        <v-icon color="error">remove_circle_outline</v-icon>
                                    </v-btn>
                                </v-list-tile-action>
                            </v-list-tile>

                        </v-list>
                        <v-card-text style="height: 50px;" class="grey lighten-5"></v-card-text>
                        <v-card-text style="height: 50px; position: relative">
                            <v-btn  color="success" @click="dialog = true"
                                    absolute
                                    dark
                                    fab
                                    top
                                    right

                            >
                                <v-icon>add</v-icon>
                            </v-btn>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
        <div class="text-xs-center">
            <v-dialog
                    v-model="dialog"
                    width="500"
            >

                <v-card>
                    <v-card-title
                            class="headline grey lighten-2"
                            primary-title
                    >
                        Добавить новый фильтр
                    </v-card-title>

                    <v-card-text>
                        <v-layout
                                row
                                wrap
                                justify-center
                        >
                            <v-flex xs8 sm8 md8>
                                <v-text-field
                                        label="Ключевая фраза поиска"
                                        placeholder="Например: BMW 5 2017"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                        <v-layout
                                row
                                wrap
                                justify-space-around
                        >
                            <v-flex xs7 md7>
                                <v-slider

                                        v-model="price"
                                        :max="10000000"
                                        label="Цена"
                                ></v-slider>
                            </v-flex>

                            <v-flex xs3 md3>
                                <v-text-field
                                        v-model="price"
                                        class="mt-0"
                                        type="number"
                                ></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                flat
                                @click="dialog = false"
                        >
                            Добавить
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>
    </v-app>
</template>

<script>
    export default {

        data() {
            return {
                drawer: null,
                dialog: false,
                rightItems: null,
                price: 290000,
            }
        },
        props: {
            source: String
        },
        methods: {
            act: function (event) {
                //console.log($(event.target).parent().parent().parent().find('[isSelect]').toggle());
            },
            fetchData: function (){
                axios.get('/filters')
                    .then(({data}) => this.rightItems = data.data);;
            }
        },
        created() {
            this.fetchData();
        }
    }
</script>