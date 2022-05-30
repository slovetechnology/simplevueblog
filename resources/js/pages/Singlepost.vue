
<template>
  <div>
      <header-vue></header-vue>
    <div class="maindiv">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 centerdiv border bg-white">
                <div class="d-flex align-items-center justify-content-between border-bottom py-2 px-3">
                    <div class="d-flex align-items-center">
                    <router-link :to="{ name: 'home' }" class="cursor-pointer text-muted"> <i class="fas fa-arrow-left fa-lg fa-fw"></i> </router-link>
                        <img :src="`/assets/profiles/${post.user.profile}`" alt="" class="myimg mx-2">
                        <div class="">
                            <div> {{ post.user.name }} </div>
                            <div> <i class="fas fa-globe fa-sm fa-fw"></i> {{ moment(post.created_at).fromNow() }} </div>
                        </div>
                    </div>
                    <div class="cursor-pointer"> <i class="fas fa-ellipsis-v fa-lg fa-fw"></i> </div>
                </div>
                <div v-if="post.media !== null"><img :src="`/assets/posts/${post.media}`" class="card-img-top" alt="..."></div>
                <div class="card-body">
                    <p class="card-text"> {{ post.content }} </p>
                </div>
                <div class="border-top border-bottom d-flex align-items-center justify-content-center cardft">
                    <like-vue :item="this.$route.params.id"></like-vue>
                    <love-vue :item="this.$route.params.id"></love-vue>
                    <postbtn-vue :item="this.$route.params.id"></postbtn-vue>
                </div>
                <chatbox-vue @showreply="sendReply" :post="this.$route.params.id"></chatbox-vue>
                <div class="py-3 px-2">
                    <div class="h3 text-muted pb-3">Recent Comments</div>
                    <div class="singlediv d-flex mb-2" v-for="item in reply" :key="item.id">
                        <img :src="`/assets/profiles/${item.user.profile}`" alt="" class="myimg shadow">
                        <div class="mx-2 bg-light p-2 shadow-sm">
                            <div> {{ item.user.name }} ({{ item.user.status }}) </div>
                            <div class="text-justify">{{ item.msg }}</div>
                            <div class="d-flex justify-content-between">
                                <div class=""></div>
                                <div class="text-muted"> <i class="fas fa-clock fa-sm fa-fw"></i> {{ moment(item.created_at).fromNow() }} </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
  </div>
</template>

<script>
var moment = require('moment');
import HeaderVue from '../components/Header';
import ChatboxVue from '../components/Chatbox';
import LikeVue from '../components/Like';
import LoveVue from '../components/Love';
import PostbtnVue from './Postbtn';
export default {
    name: "singlepost",
    data () {
        return {
            moment: moment,
            postid: null,
            post: {},
            reply: {},
        }
    },
    components: {
        HeaderVue,
        LikeVue,
        ChatboxVue,
        LoveVue,
        PostbtnVue,
    },
    methods: {
        getPost() {
            axios.get(`/api/getsingles/${this.$route.params.id}`)
            .then(response => {this.post = response.data; console.log(this.post.media);});
        },
        getReply() {
            axios.get(`/api/getreplys/${this.$route.params.id}`).then(response => {this.reply = response.data});
        },
        updatereply() {
            this.getReply();
        },
        sendReply() {
            this.getReply();
        }
    },
    created() {
        this.getPost();
        this.getReply();
    }
}
</script>

<style scoped>

.myimg{
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    cursor: pointer;
}
.card {
    position: relative;
}
.card-img-top{
    height: 200px;
    object-fit: cover;
    /* background: #222; */
    border-radius: 0%;
}
.card>div:nth-child(1)>div>div>div:nth-child(2) {
    font-size: 12px;
}
.cardftbtn {
    border: none;
    border-right: 1px solid rgb(151, 150, 150);
}
.cardftbtn:last-child {
    border-right: none;
}
.cardvid {
    position: absolute;
    top: 40%;
    left: 45%;
    z-index: 3;
}
.text-justify {
    text-align: justify;
}
</style>

