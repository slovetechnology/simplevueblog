
<template>
    <router-link :to="{ name: 'post', params: {id: item} }" class="btn btn-outline-secondary rounded-0 px-5 py-2 cardftbtn"> <i class="fas fa-commenting fa-lg fa-fw"></i>: {{ postcount }} </router-link>
</template>

<script>
export default {
    props: ['item'],
    data() {
        return {
            postcount: 0,
        }
    },
    methods: {
        getpostCount() {
            axios.get('/api/getpostcount/'+this.item).then(response => this.postcount = response.data);
        }
    },
    created() {
        this.getpostCount();
    }
}
</script>

<style>

</style>
