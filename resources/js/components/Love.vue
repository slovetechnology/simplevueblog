

<template>
    <button class="bg-white text-danger rounded-0 px-5 py-2 cardftbtn" @click="deleteLove" v-if="loved"> <i class="fas fa-heart fa-lg fa-fw"></i>: {{ loves }} </button>
    <button class="btn btn-outline-secondary rounded-0 px-5 py-2 cardftbtn" @click="lovePost" v-else> <i class="fas fa-heart fa-lg fa-fw"></i>: {{ loves }} </button>
</template>

<script>
export default {
    props: ['item'],
    data() {
        return {
            loves: 0,
            loved: false,
        }
    },
    methods: {
        lovePost() {
            axios.post('/api/postlove/'+this.item)
            .then(() => {
                this.getLoves();
                this.loveByUser();
            })
        },
        deleteLove() {
            axios.post('/api/deletelove/'+this.item)
            .then(() => {
                this.getLoves();
                this.loveByUser();
            })
        },
        getLoves() {
            axios.get('/api/getloves/'+this.item)
            .then(response => {
                this.loves = response.data;
            })
        },
        loveByUser() {
            axios.get('/api/lovebyuser/'+this.item)
            .then((response) => {
                if(response.status == 200){
                    this.loved = true;
                }else{
                    this.loved = false;
                }
            })
        }
    },
    created() {
        this.getLoves();
        this.loveByUser();
    }
}
</script>

<style>

</style>
