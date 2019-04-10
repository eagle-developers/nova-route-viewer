<template>
    <div>
        <heading class="mb-6">Route Viewer</heading>

        <div class="flex justify-between">
            <div class="relative h-9 flex items-center mb-6">
                <icon type="search" class="absolute ml-3 text-70" />

                <input v-model="search"
                       class="appearance-none form-control form-input w-search pl-search"
                       placeholder="Search"
                       type="search"
                >
            </div>

            <div class="flex items-center mb-6 ml-6">
                <checkbox :checked="showHidden"
                          @input="toggleHidden"
                />
                <label class="cursor-pointer pl-2"
                       @click="toggleHidden"
                >
                    Show hidden paths
                </label>
            </div>

            <span class="ml-auto mb-6">
                <button @click="getRoutes()"
                        class="btn btn-default btn-primary"
                >
                    Refresh
                </button>
            </span>
        </div>

        <card>
            <route-table :routes="filteredRoutes"
                         :sort="sortBy"
            ></route-table>
        </card>
    </div>
</template>

<script>
import RouteTable from './RouteTable';

export default {
    components: { RouteTable },

    data() {
        return {
            routes: [],
            hidden: [],
            search: '',
            sort: {
                field: '',
                order: -1,
            },
            showHidden: false,
        }
    },

    mounted() {
        this.getRoutes();
    },

    methods: {
        getRoutes() {
            Nova.request().get('/nova-vendor/eagle-developers/nova-route-viewer/routes').then(response => {
                this.routes = response.data.routes;
                this.hidden = response.data.hidden;
            });
        },

        sortBy(field) {
            this.sort.field = field;
            this.sort.order *= -1;

            this.routes.sort((route1, route2) => {
                let comparison = 0;

                if (route1[this.sort.field] < route2[this.sort.field]) {
                    comparison = -1;
                }

                if (route1[this.sort.field] > route2[this.sort.field]) {
                    comparison = 1;
                }

                return comparison * this.sort.order;
            });
        },

        toggleHidden() {
            this.showHidden = ! this.showHidden;
        }
    },

    computed: {
        filteredRoutes() {
            if (! this.search.length) {
                return this.visibleRoutes;
            }

            const regex = this.searchRegex;
            // User input is not a valid regular expression, show no results
            if (! regex) {
                return {};
            }

            return this.visibleRoutes.filter(route => {
                let matchesSearch = false;

                for (let key in route) {
                    if (Array.isArray(route[key])) {
                        route[key].forEach(property => {
                            if (regex.test(property)) {
                                matchesSearch = true;
                            }
                        });
                    }
                    else if (regex.test(route[key])) {
                        matchesSearch = true;
                    }
                }

                return matchesSearch;
            });
        },

        visibleRoutes() {
            if (this.showHidden) {
                return this.routes;
            }

            return this.routes.filter(route => {
                let keep = true;

                for (let i in this.hidden) {
                    if (route.uri.indexOf(this.hidden[i]) === 0) {
                        keep = false;
                    }
                }

                return keep
            });
        },

        searchRegex() {
            try {
                return new RegExp('(' + this.search + ')', 'i');
            } catch (e) {
                return false;
            }
        }
    }
}
</script>

<style>
</style>
