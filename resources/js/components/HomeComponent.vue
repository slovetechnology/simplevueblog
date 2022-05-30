
<template>
<!-- ==================================== -->
  <div>
      <header-vue></header-vue>
    <div class="maindiv">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 centerdiv border bg-white">
              <div class="d-flex align-items-center justify-content-between p-2">
                  <div class="d-flex align-items-center">
                      <router-link :to="{ name: 'profile' }"><img :src="'assets/profiles/'+user.profile" alt="" class="myimg"></router-link>
                      <div class="mx-2">
                        <div class=""> {{ user.name }} </div>
                        <div class="text-capitalize"> {{ user.status }}</div>
                      </div>
                  </div>
                  <div class="">
                      <i class="fas fa-ellipsis-v fa-lg fa-fw cursor-pointer"></i>
                  </div>
              </div>
              <!-- contains the post form field -->
              <div class="border-bottom pb-2 px-2 d-flex align-items-center">
                  <input type="text" name="" placeholder="Add post here...." id="" class="form-control rounded-0" v-model="postText" @keyup="enterPost">
                  <button class="btn btn-secondary rounded-0 py-2 border-0" v-if="!showpostbtn"> <label><i class="fas fa-paperclip fa-lg fa-fw"></i> <input type="file" id="preimgInput" hidden @change="showPreimg"></label>  </button>
                  <button class="btn btn-primary rounded-0 py-2 border-0" @click="postTextOnly" v-else> <i class="fas fa-paper-plane fa-lg fa-fw"></i> </button>
              </div>
              <div class="p-2 border-bottom" v-if="addprev">
                  <div class="row px-2">
                      <div class="col-6">
                          <div class="text-center" v-if="preimg">
                                <div v-if="mediaType == 'video/mp4'">
                                    <video :src="preimg" class="preimg"></video>
                                </div>
                                <div v-else-if="mediaType == 'image/jpg' || mediaType == 'image/png' || mediaType == 'image/jpeg' || mediaType == 'image/gif'">
                                    <img :src="preimg" alt="" class="preimg">
                                </div>
                            <div class="text-center text-danger cursor-pointer mt-3" @click="canUpload">cancel upload</div>
                          </div>
                      </div>
                      <div class="col-6">
                          <textarea placeholder="Add Comment to post" v-model="textpost" class="form-control"></textarea>
                          <div class="d-flex justify-content-between mt-3">
                              <div></div>
                          <div class="btn btn-primary btn-sm py-2 shadow" @click="addPostwithImage">Create Post</div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- shows images and names of friends on a straight line -->
              <div class="allimgs mb-3">
                    <div class="d-flex align-items-center py-1">
                        <div class="text-center px-3" v-for="users in allusers" :key="users.id">
                            <img :src="'assets/profiles/'+users.profile" alt="" class="myimg">
                            <div class="d-block"> {{ users.name }} </div>
                        </div>
                        <div class="align-self-start"> <router-link to="" class="no-text">More...</router-link> </div>
                    </div>
              </div>
              <!-- begins the blog areas -->
              <div class="">
                  <!-- ======================= -->
                  <div v-if="allposts">
                        <div class="card mb-2 shadow" v-for="post in allposts" :key="post.id">
                            <div class="d-flex align-items-center justify-content-between border-bottom py-1 px-3">
                                <div class="d-flex align-items-center">
                                    <router-link :to="{ name: 'singleuser', params: { id: post.user.id } }"><img :src="`/assets/profiles/${post.user.profile}`" alt="" class="myimg"></router-link>
                                    <div class="mx-2">
                                        <div> {{ post.user.name }} </div>
                                        <div> <i class="fas fa-globe fa-sm fa-fw"></i> {{ moment(post.created_at).fromNow() }} </div>
                                    </div>
                                </div>
                                <div class="cursor-pointer"> <i class="fas fa-ellipsis-v fa-lg fa-fw"></i> </div>
                            </div>
                            <div v-if="post.media">
                                <div v-if="post.ext == 'mp4'" class="">
                                    <div class="cardvid" @click="playvideo"> <i class="fas fa-play fa-3x text-white fa-fw"></i> </div>
                                    <video :src="`/assets/posts/${post.media}`" loop class="card-img-top-vid"></video>
                                </div>
                                <div v-else-if="post.ext == 'jpg' || post.ext == 'gif' || post.ext == 'png' || post.ext == 'jpeg'">
                                    <img :src="`/assets/posts/${post.media}`" class="card-img-top" alt="...">
                                </div>

                            </div>
                            <div class="card-body">
                                <p class="card-text"> {{ post.content }} <router-link :to="{ name: 'post', params: { id: post.id } }" class="text-primary cursor-pointer no-text">Read more...</router-link> </p>
                            </div>
                            <div class="border-top border-bottom d-flex align-items-center justify-content-center cardft">
                                <like-vue :item="post.id"></like-vue>
                                <love-vue :item="post.id"></love-vue>
                                <postbtn-vue :item="post.id"></postbtn-vue>
                            </div>
                        </div>
                    </div>
                  <div v-else class="text-center text-muted mt-5">There is no Post available yet!..</div>
                  </div>
              <!-- =================================== -->
          </div>
          <div class="col-md-4"></div>
      </div>
  </div>
  </div>
</template>

<script>
var moment = require('moment');
import HeaderVue from './Header';
import LikeVue from './Like';
import LoveVue from './Love';
import PostbtnVue from '../pages/Postbtn';

export default {
    data() {
        return {
            moment: moment,
            user: {},
            allusers: {},
            allposts: {},
            postText: '',
            showpostbtn: false,
            preimg: null,
            preimage: null,
            textpost: '',
            addprev: false,
            mediaType: '',
        }
    },
    components: {
        HeaderVue,
        LikeVue,
        LoveVue,
        PostbtnVue,
    },
    methods: {
        showPreimg(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = file => {
                this.preimage = e.target.files[0];
                this.mediaType = e.target.files[0].type;
            }
            reader.readAsDataURL(file);
            reader.onload = e => {
                this.preimg = e.target.result;
                this.addprev = true;
            }
        },
        canUpload() {
            this.preimg = null;
            this.addprev = false;
            document.querySelector('#preimgInput').value = '';
        },
        enterPost() {
            if(this.postText.length < 1) {
                this.showpostbtn = false;
            }else{
                this.showpostbtn = true;
                this.addprev = false;
            }
        },
        addPostwithImage() {
            let formdata = new FormData();
            formdata.append('media', this.preimage);
            formdata.append('post', this.textpost);
            axios.post('/api/addPostwithImage', formdata)
            .then((response) => {
                this.getAllPosts();
                this.addprev = false;
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            })
        },
        postTextOnly() {
            const formdata = new FormData();
            formdata.append('content', this.postText);
            axios.post('/api/posttextonly', formdata)
            .then(() => {
                this.postText = '';
                this.getAllPosts();
            })
            .catch((error) => {
                console.log(error);
            })
        },
        playvideo() {
            let vid = document.querySelector('.card-img-top-vid');
            let cardvid = document.querySelector('.cardvid>i');
            if(!cardvid.classList.contains('fa-play')) {
                vid.pause();
                cardvid.classList.remove('fa-pause');
                cardvid.classList.add('fa-play');
            }else{
                vid.play();
                cardvid.classList.add('fa-pause');
                cardvid.classList.remove('fa-play');
            }
        },
        getUser() {
            axios.get('/api/user')
            .then((response) => {
                this.user = response.data;
            })
            .catch((error) => {
                console.log('error');
            })
        },
        getallusers() {
            axios.get('/api/allusers')
            .then(response => {
                this.allusers = response.data;
            })
        },
        getAllPosts() {
            axios.get('/api/allposts')
            .then((response) => {
                this.allposts = response.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
    },
    created() {
        this.getUser();
        this.getallusers();
        this.getAllPosts();
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
.allimgs{
    position: relative;
    overflow-x: auto;
}
.allimgs::-webkit-scrollbar{
    height: 0px;
}
.preimg {
    width: 100%;
    height: 200px;
    object-fit: contain;
}
.allimgs::-webkit-scrollbar-thumb{
    height: 0px;
    background: grey;
}
.allimgs>div>div>div{
    font-size: 12px;
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
.card-img-top-vid {
    height: 250px;
    object-fit: cover;
    /* background: #222; */
    border-radius: 0%;
    width: 100%;
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
.viddiv {
    position: relative;
}
.cardvid {
    position: absolute;
    top: 25%;
    left: 45%;
    z-index: 3;
}
</style>

