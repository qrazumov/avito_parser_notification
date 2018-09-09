<template>
    <v-app id="inspire">
        <v-navigation-drawer
                v-model="drawer"
                fixed
                app
        >
            <v-list dense>
                <router-link :to="{ name: 'index' }">
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon>home</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Главная</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </router-link>


                <router-link :to="{ name: 'filters' }">
                    <v-list-tile @click="">
                        <v-list-tile-action>
                            <v-icon>save</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title>Сохраненные фильтры</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </router-link>



                <v-list-tile @click="">
                    <v-list-tile-action>
                        <v-icon>settings</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>Настройки</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-toolbar color="primary" fixed app dark>
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>Avito Price Notification v0.1</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-toolbar-items class="hidden-sm-and-down">
                <v-menu offset-y light>

                    <v-btn flat
                           slot="activator"
                           style="color:white"
                    >
                        {{ username }}
                        <v-icon>expand_more</v-icon>
                    </v-btn>

                    <v-list>
                        <v-list-tile
                                v-for="(item, index) in items"
                                :key="index"
                                @click=""
                        >
                            <v-list-tile-title v-on:click="greet">{{ item.title }}</v-list-tile-title>
                        </v-list-tile>
                    </v-list>

                </v-menu>

            </v-toolbar-items>
        </v-toolbar>
        <v-content>
            <transition name="fade"><router-view></router-view></transition>

        </v-content>
        <v-footer color="indigo" app>
            <span class="white--text">&copy; 2017</span>
        </v-footer>
        <form id="logout-form" :action="routelogout" method="POST" style="display: none;">
            <input type="hidden" :value="scrf" name="_token">
        </form>
    </v-app>
</template>

<script>


    export default {
        data: () => ({
            drawer: null,
            items: [
                {title: 'Выход'}
            ],

        }),
        props: {
            source: String,
            username: String,
            routelogout: String,
            scrf: String,
        },
        methods: {
            greet: function (event) {
                document.getElementById('logout-form').submit()
            }
        }
    }
</script>


<style scoped>

</style>