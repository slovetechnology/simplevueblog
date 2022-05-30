
<template>
<div>

    <div class="mainheader d-flex align-items-center justify-content-between py-2 px-3">
        <router-link :to="{ name: 'home' }" class="h3 text-white no-text"> <i class="fas fa-blog fa-lg fa-fw"></i> Site<span class="text-warning">Bloggers</span>.com </router-link>
        <div class="w-50 formers">
            <form>
                <i class="fas fa-search fa-lg fa-fw my-3 text-muted"></i>
                <input type="text" placeholder="Search Here..." class="form-control rounded-0 px-4">
            </form>
        </div>
        <div class="w-50 formers2">
            <form>
                <i class="fas fa-search fa-lg fa-fw my-3 text-muted"></i>
                <input type="text" placeholder="Search Here..." class="form-control rounded-0 px-4">
            </form>
        </div>
        <div class="d-flex align-items-center">
            <router-link :to="{ name: 'profile' }" class="links"> <i class="fas fa-user fa-lg fa-fw"></i> </router-link>
            <div class="links" @click="openextrahd"> <i class="fas fa-ellipsis-v fa-lg fa-fw"></i> </div>
        </div>
    </div>
  <div class="extrahd shadow">
      <div v-if="!authuser">
      <router-link :to="{ name: 'register' }" class="extrahdlink">create account</router-link>
      <router-link :to="{ name: 'login' }" class="extrahdlink">login account</router-link>
      </div>
      <div v-else>
          <router-link class="extrahdlink" :to="{ name: 'home' }">home</router-link>
          <router-link class="extrahdlink" :to="{ name: 'profile' }">profile</router-link>
        <div class="extrahdlink cursor-pointer" @click="openoverall">logout</div>
      </div>
  </div>
  <div class="overlay">
      <div class="bg-white w-350px rounded">
          <div class="d-flex bg-light border-bottom rounded-top py-2 px-3">
          <div class="">Hi!. {{ user.name }}, Are you sure you want to logout?.. </div>
          <div class="cursor-pointer" @click="closeoverall"> <i class="fas fa-times fa-lg fa-fw"></i> </div>
          </div>
          <form class="mt-3 px-3 py-3" @submit.prevent="logoutUser">
              <button class="btn btn-sm w-100 btn-danger py-2">Proceed Logout</button>
          </form>
      </div>
  </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            authuser: false,
            user: {},
        }
    },
    methods: {
        closeoverall() {
            document.querySelector('.overlay').style.display = 'none';
        },
        openoverall() {
            document.querySelector('.overlay').style.display = 'flex';
        },
        openextrahd(e) {
            if(!e.target.classList.contains('extractive')) {
                document.querySelector('.extrahd').style.display = 'block';
                e.target.classList.add('extractive');
            }else{
                document.querySelector('.extrahd').style.display = 'none';
                e.target.classList.remove('extractive');
            }
        },
        logoutUser() {
            axios.post('/api/logoutuser')
            .then(() => {
                document.querySelector('.overlay').style.display = 'none';
                this.$router.push({ name: 'login' });
            })
        },
        getUser() {
            axios.get('/api/user').then((response) => {this.user = response.data}).catch(() => {console.log('No user Found')})
        }
    },
    beforeCreate() {
        axios('/api/authenticated')
        .then(() => {
            this.authuser = true;
        })
        .catch(() => {
            this.authuser = false;
        })
    },
    created() {
        this.getUser();
    }
}
</script>

<style>

</style>

