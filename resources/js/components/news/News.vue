<template>
    <div class="news" v-show="loading || articles.length > 0">
        <div class="row">
            <div class="col">
                <h2>Recent News</h2>
            </div>
            <div class="col-auto">
                <a :href="'/news?symbols=' + joinedSymbols" class="see-more">See More</a>
            </div>
        </div>

        <div class="row" v-if="loading">
            <div class="col-md-4 article-column" v-for="i in this.limit">
                <div class="card article article-loading">
                    <div class="image">
                        <div class="loader"></div>
                    </div>
                    <div class="card-body">
                        <h5 class="loading-text-animation"></h5>
                        <h4 class="loading-text-animation"></h4>
                        <div class="summary loading-text-animation"></div>
                        <div class="summary loading-text-animation"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="!loading">
            <news-article
                :headline="article.headline"
                :datetime="article.datetime"
                :url="article.url"
                :summary="article.summary"
                :image="article.image"
                :key="index"
                v-for="(article, index) in articles">
            </news-article>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            symbols: {
                type: [Array, String],
            },
            limit: {
                type: Number,
                default: 6,
            },
        },

        data() {
            return {
                loading: true,
                articles: [],
            }
        },

        mounted() {

            /**
             * Load Data
             */
            axios({
                method: 'get',
                url: '/api/news',
                params: {
                    symbols: this.joinedSymbols,
                    limit: this.limit,
                }
            })
            .then(response => {

                /**
                 * get articles
                 */
                this.articles = response.data.data;

                /**
                 * Stop loading
                 */
                this.loading = false;

            })
            .catch(error => {

                new Noty({
                    type: 'error',
                    layout: 'topRight',
                    text: 'Something went wrong while loading the recent news.',
                    progressBar: true,
                    timeout: 3000,
                }).show();

            });

        },

        computed: {

            joinedSymbols() {

                if(Array.isArray(this.symbols)){

                    return this.symbols.join(',');

                } else {

                    return this.symbols;

                }

            }

        }

    }
</script>
