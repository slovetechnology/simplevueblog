
<template>
    <div>
        <header-vue></header-vue>
      <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4 centerdiv bg-white pb-5">
              <div class="d-flex justify-content-between py-2 px-4">
                  <div class=""></div>
                  <router-link :to="{ name: 'home' }" class="no-text btn btn-sm btn-primary shadow">Back</router-link>
              </div>
                <div class="text-center py-2">
                    <img :src="`/assets/profiles/${post.user.profile}`" alt="" class="myimg shadow">
                    <div class="font-size-18px text-capitalize"> {{ post.user.name }} </div>
                    <div class="text-capitalize"> {{ post.user.email }} </div>
                    <div class="text-primary text-capitalize"> <i class="fas fa-circle fa-xs fa-fw"></i> {{ post.user.status }} </div>
                </div>
                <div class="px-3 py-2">
                    <div class="d-flex align-items-center justify-content-between pb-2">
                        <div>Total Posts uploaded on the platform: </div>
                        <div class=""> {{ allposts }} posted </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pb-2">
                        <div>Total Replies made on the platform: </div>
                        <div class=""> {{ allreplies }} replied </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pb-2">
                        <div>Total posts Liked so far: </div>
                        <div class=""> {{ liked }} liked </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pb-2">
                        <div>Total Posts Loved so far: </div>
                        <div class=""> {{ loved }} loved </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between pb-2">
                        <div>Joined the platform on: </div>
                        <div class="">  <i class="fas fa-clock fa-sm fa-fw"></i> {{ moment(post.user.created_at).fromNow() }} </div>
                    </div>
                    <div class="h5 border rounded shadow my-2 bg-light p-2"> {{ post.user.name }} 's Posts</div>
                    <div v-for="item in userposts" :key="item.id" class="card mb-2 shadow">
                        <div class="d-flex align-items-center justify-content-between border-bottom py-1 px-3">
                            <div class="d-flex align-items-center">
                                <div class="mx-2">
                                    <div> {{ post.user.name }} </div>
                                    <div> <i class="fas fa-globe fa-sm fa-fw"></i>Posted: {{ moment(item.created_at).fromNow() }} </div>
                                </div>
                            </div>
                            <div class="cursor-pointer"> <i class="fas fa-ellipsis-v fa-lg fa-fw"></i> </div>
                        </div>
                        <div v-if="item.media !== null"><img :src="`/assets/posts/${item.media}`" class="card-img-top" alt="..."></div>
                        <div class="card-body">
                            <p class="card-text"> {{ item.content }} <router-link :to="{ name: 'post', params: { id: item.id } }" class="text-primary cursor-pointer no-text">Read more...</router-link> </p>
                        </div>
                        <div class="border-top border-bottom d-flex align-items-center justify-content-center cardft">
                            <like-vue :item="item.id"></like-vue>
                            <love-vue :item="item.id"></love-vue>
                            <postbtn-vue :item="item.id"></postbtn-vue>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
      </div>
    </div>
</template>

<script>
var moment = require('moment');
import HeaderVue from '../components/Header';
import LoveVue from '../components/Love';
import LikeVue from '../components/Like';
import PostbtnVue from './Postbtn';

export default {
    data() {
        return {
            moment: moment,
            post: {},
            allreplies: 0,
            allposts: 0,
            liked: 0,
            loved: 0,
            userposts: {},
        }
    },
    components: {
        HeaderVue,
        LikeVue,
        LoveVue,
        PostbtnVue,

    },
    methods: {
        getuser() {
            axios.get(`/api/singleuser/${this.$route.params.id}`)
            .then(response => {
                this.post = response.data;
            })
        },
        getuserreplies() {
            axios.get(`/api/getuserreplies/${this.$route.params.id}`)
            .then(response => {
                this.allreplies = response.data;
            })
        },
        getpostsbyuser() {
            axios.get(`/api/postsbyuser/${this.$route.params.id}`)
            .then(response => {
                this.allposts = response.data;
            })
        },
        userliked() {
            axios.get(`/api/userliked/${this.$route.params.id}`)
            .then(response => {
                this.liked = response.data;
            })
        },
        userloved() {
            axios.get(`/api/userloved/${this.$route.params.id}`)
            .then(response => {
                this.loved = response.data;
            })
        },
        getUserPosts() {
            axios.get(`/api/getUserPosts/${this.$route.params.id}`)
            .then(response => {
                this.userposts = response.data;
            })
        }
    },
    created() {
        this.getuser();
        this.getuserreplies();
        this.getpostsbyuser();
        this.userliked();
        this.userloved();
        this.getUserPosts();
    }
}
</script>

<style>

.myimg {
    width: 150px;
    height: 150px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 50%;
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

