
<template>

    <div class="">
        <form class="p-2">
            <div class="d-flex align-items-center">
                <input type="text" placeholder="Comment on this post" class="form-control rounded-0" @keyup="checktext" v-model="reply">
                <button class="btn-sm btn-primary btn rounded-0 p-2" @click.prevent="submitReply" v-if="textbox"> <i class="fas fa-paper-plane fa-lg fa-fw"></i> </button>
                <div class="btn-sm btn-secondary btn rounded-0 p-2" v-else> <i class="fas fa-user fa-lg fa-fw"></i> </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['post'],
    data() {
        return {
            textbox: false,
            reply: '',
        }
    },
    methods: {
        checktext(e) {
            if(e.target.value.length < 1) {
                this.textbox = false;
            }else{
                this.textbox = true;
            }
        },
        submitReply() {
            let formdata = new FormData();
            formdata.append('reply', this.reply);
            axios.post('/api/submitReply/'+this.post, formdata)
            .then(response => {
                this.reply = '';
                this.textbox = false;
                this.$emit('showreply');
            })
            .catch(error => {
                console.log(error);
            })
        },
    }
}
</script>

<style>

</style>

