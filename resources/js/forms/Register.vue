
<template>
  <div>
      <header-vue></header-vue>
      <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">
            <div class="formdiv">
                <form class="border p-3 rounded shadow" @submit.prevent="submitForm">
                    <div class="h3 text-muted">Create User Account</div>
                    <div class="form-group mb-2">
                        <div class="w-100 text-muted">Enter Username</div>
                        <input type="text" placeholder="Enter Username" id="" class="form-control" v-model="form.name">
                    </div>
                    <div class="form-group mb-2">
                        <div class="w-100 text-muted">Enter Email Address</div>
                        <input type="email" placeholder="Enter Email Address" id="" class="form-control" v-model="form.email">
                    </div>
                    <div class="form-group mb-2">
                        <div class="w-100 text-muted">Enter Password</div>
                        <input type="password" placeholder="Enter Password" id="" class="form-control" v-model="form.password">
                    </div>
                    <div class="form-group mb-2">
                        <div class="w-100 text-muted">Confirm Password</div>
                        <input type="password" placeholder="Confirm Password" id="" class="form-control" v-model="form.password_confirmation">
                    </div>
                    <div class="form-group mb-2">
                        <input type="file" name="" id="" class="form-control" @change="uploadFile">
                    </div>
                    <button class="btn btn-sm w-100 btn-success py-2">Create Account</button>
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
            photo: null,
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
        }
    },
    components: {
        HeaderVue,
    },
    methods: {
        uploadFile(e) {
            this.photo = e.target.files[0];
        },
        submitForm() {
            if(this.form.name === ''){
                console.log('Name field is required');
            }else{
                if(this.form.email === '') {
                    console.log('Email address feild is required');
                }else{
                    const formdata = new FormData();
                    formdata.append('photo', this.photo, this.photo.name);
                    formdata.append('name', this.form.name);
                    formdata.append('email', this.form.email);
                    formdata.append('password', this.form.password);
                    formdata.append('password_confirmation', this.form.password_confirmation);
                    axios.post('/api/user/register', formdata)
                    .then( response => {
                        this.$router.push({ name: 'login' });
                    })
                    .catch( error => {
                        console.log(error);
                    })
                }
            }
        },
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
