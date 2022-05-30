
<template>
  <div>
      <header-vue></header-vue>
      <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4 centerdiv bg-white pb-5">
              <div class="d-flex justify-content-between py-2 px-3">
                  <div class=""></div>
                  <router-link :to="{name: 'home'}" class="btn btn-sm btn-primary shadow">Back</router-link>
              </div>
            <div class="text-center py-2">
                <img :src="'assets/profiles/'+user.profile" alt="" class="myimg shadow">
                <div class="font-size-18px text-capitalize"> {{ user.name }} </div>
                <div class="text-capitalize"> {{ user.email }} </div>
                <div class="text-primary text-capitalize"> <i class="fas fa-circle fa-xs fa-fw"></i> {{ user.status }} </div>
                <div class="text-muted">Joined: {{ moment(user.created_at).fromNow() }} </div>
            </div>
            <div class="h3 text-muted border-bottom px-3 pb-2"><i class="fas fa-user fa-sm fa-fw"></i> Update Profile</div>
            <form>
                <div class="d-flex px-2 mb-2">
                    <div class="text-muted w-25">Usename</div>
                    <input type="text" name="" id="" class="form-control" v-model="user.name">
                </div>
                <div class="d-flex px-2 mb-2">
                    <div class="text-muted w-25">Profile</div>
                    <input type="file" name="" id="myfilep" class="form-control" @change="uploadFile">
                </div>
                <div class="text-center" v-if="image">
                    <img :src="image" alt="" class="viewimg">
                    <div class="text-danger cursor-pointer p-2 mt-2" @click="cancenupdate">cancel upldate</div>
                </div>
                <div class="d-flex justify-content-between px-2">
                    <div class=""></div>
                    <button class="btn-success btn btn-sm py-2 px-3" @click.prevent="updateProifle"> Update Profile</button>
                </div>
            </form>
            <div class="h3 text-danger border-bottom px-3 pb-2"> <i class="fas fa-power-off fa-sm fa-fw"></i> Logout Account</div>
          <form class="mt-3 px-5 py-3" @submit.prevent="logoutUser">
              <button class="btn btn-sm w-100 btn-danger py-2">Proceed Logout</button>
          </form>
            <div class="h3 text-danger border-bottom px-3 pb-2"> <i class="fas fa-trash-alt fa-sm fa-fw"></i> Delete Account</div>
            <div class="">Hi! {{ user.name }},  Ensure you are fully aware of the action you are about to take. This will automatically erase your account and every contributions you have made within the platform</div>
            <div class="px-5 mt-3">
                <button class="btn btn-sm w-100 py-2 btn-danger" @click="deleteaccount">Yes i can deal with that!.</button>
            </div>
          </div>
          <div class="col-md-4"></div>
      </div>
  </div>
</template>

<script>
var moment = require('moment');
import HeaderVue from './Header';
export default {
    data() {
        return {
            moment: moment,
            user: {},
            image: null,
            photo: null,
        }
    },
    components: {
        HeaderVue,
    },
    methods: {
        uploadFile(e) {
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = file => {
                this.photo = e.target.files[0];
            }
            reader.readAsDataURL(file);
            reader.onload = e => {
                this.image = e.target.result;
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
        updateProifle(){
            const formdata = new FormData();
            formdata.append('photo', this.photo);
            formdata.append('name', this.user.name);
            axios.post('/api/updateprofile', formdata)
            .then(() => {
                this.getUser();
                this.image = null;
                document.querySelector('#myfilep').value = '';
            })
        },
        logoutUser() {
            axios.post('/api/logoutuser')
            .then(() => {
                document.querySelector('.overlay').style.display = 'none';
                this.$router.push({ name: 'login' });
            })
        },
        cancenupdate() {
            this.image = null;
            document.querySelector('#myfilep').value = '';
        },
        deleteaccount() {
            axios.get('/api/deleteaccount')
            .then(() => {
                this.$router.push({ name: 'login' });
            })
        }
    },
    created() {
        this.getUser();
    }
}
</script>

<style scoped>
.myimg {
    width: 150px;
    height: 150px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 50%;
}
.viewimg {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
}
</style>
