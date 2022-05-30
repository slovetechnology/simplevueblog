
<template>
    <button :class="'bg-white text-primary btn rounded-0 px-5 py-2 cardftbtn'" v-if="liked" @click="unlikepost"> <i class="fas fa-thumbs-down fa-lg fa-fw"></i>: {{ likes }} </button>
    <button :class="'btn btn-outline-secondary rounded-0 px-5 py-2 cardftbtn'" v-else @click="likepost"> <i class="fas fa-thumbs-up fa-lg fa-fw"></i>: {{ likes }} </button>
</template>

<script>
import axios from 'axios'


export default {
    props: ['item'],
    data() {
        return {
            likes: 0,
            likeclass: '',
            liked: false,
        }
    },
    methods: {
        likepost() {
            axios.post('/api/likepost/'+this.item)
            .then((response) => {
                if(response.status === 200) {
                    this.likeByUser();
                    this.checkLike();
                }
            })
        },
        unlikepost() {
            axios.post('/api/unlikepost/'+this.item)
            .then((response) => {
                if(response.status === 200) {
                    console.log(response.data);
                    this.likeByUser();
                    this.checkLike();
                }
            })
        },
        checkLike() {
            axios.get('/api/checklike/'+this.item)
            .then((response) => {
                this.likes = response.data;
            })
        },
        likeByUser() {
            axios.get('/api/likebyuser/'+this.item)
            .then((response) => {
                if(response.status == 200){
                    this.liked = true;
                }else{
                    this.liked = false;
                }
            })
        }
    },
    created() {
        this.checkLike();
        this.likeByUser();
    }
}
</script>

<style>

</style>

