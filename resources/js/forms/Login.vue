
<template>
  <div>
      <header-vue></header-vue>
      <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="formdiv">
                <form class="border p-3 rounded shadow bg-white" v-if="firstform" @submit.prevent="submitForm">
                    <div class="h3 text-muted">Login User Account</div>
                    <div class="form-group mb-2">
                        <div class="w-100 text-muted">Enter Email Address</div>
                        <input type="email" placeholder="Enter Email Address" id="" class="form-control" v-model="form.email">
                    </div>
                    <div class="form-group mb-2">
                        <div class="w-100 text-muted">Enter Password</div>
                        <input type="password" placeholder="Enter Password" id="" class="form-control" v-model="form.password">
                    </div>
                    <div class="d-flex justify-content-between my-3">
                        <div class=""></div>
                        <div class="cursor-pointer text-primary" @click="forgotform">Forgot Password?</div>
                    </div>
                    <button class="btn btn-sm w-100 btn-success py-2">Login Account</button>
                </form>
                <form class="border p-3 rounded shadow bg-white" @submit.prevent="findAccount" v-else>
                    <div class="mb-2 border-bottom pb-2">Let's help you find your account. What's your Username/Email address
                        <span class="cursor-pointer btn btn-sm px-3 btn-primary" @click="closefirst">Back</span> </div>
                    <div class="form-group mb-2">
                        <input type="text   " placeholder="Username/Email Address" class="form-control" v-model="usermail">
                    </div>
                    <div class="my-2"> <button class="btn btn-sm py-2 w-100 btn-success">Find my Account</button> </div>
                </form>
            </div>
      </div>
          <div class="col-md-4"></div>
      </div>
  </div>
</template>

<script>
import HeaderVue from '../components/Header';
export default {
    data() {
        return {
            firstform: true,
            usermail: '',
            form: {
                name: '',
                password: ''
            }
        }
    },
    components: {
        HeaderVue,
    },
    methods: {
        submitForm() {
            const formdata = new FormData();
            formdata.append('email', this.form.email);
            formdata.append('password', this.form.password);
            axios.post('api/user/login', formdata)
            .then((response) => {
                if(response.status === 200) {
                    this.$router.push({ name: 'home' });
                }
            })
            .catch((error) => {
                console.log(error);
            })
        },
        forgotform() {
            this.firstform = false;
        },
        closefirst(){
            this.firstform = true;
        },
        findAccount() {
            let formdata = new FormData();
            formdata.append('user_mail', this.usermail);
            axios.post('api/usermail', formdata)
            .then(response => {
                console.log(response.data);
            }).catch(error => {console.log(error)});
        }
    },
}
</script>

<style scoped>
    .formdiv {
        width: 100%;
        height: 90vh;
        align-items: center;
        justify-content: center;
        display: flex;
    }
    form {
        width: 80%;
    }
</style>
