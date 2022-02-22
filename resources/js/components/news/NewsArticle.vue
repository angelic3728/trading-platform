<template>
    <div class="col-md-4 article-column">
        <a :href="url" class="card article" target="_blank">
            <div class="image" :style="'background-image: url(' + image + ')'"></div>
            <div class="card-body">
                <h5>{{ date }}</h5>
                <h4>{{ headline }}</h4>
                <div class="summary">{{ intro }}</div>
            </div>
        </a>
    </div>
</template>

<script>
    export default {

        props: {
            headline: {
                type: String,
            },
            datetime: {
                type: Number,
            },
            url: {
                type: String,
            },
            summary: {
                type: String,
            },
            image: {
                type: String,
            }
        },

        computed: {

            date(){

                return moment(this.datetime).format('DD MMMM YYYY');

            },

            intro(){

                if (this.summary.length > 150) {

                    return this.summary.substring(0, 150 - 3) + '...';

                } else {

                    return this.summary;

                }

            }

        }

    }
</script>
