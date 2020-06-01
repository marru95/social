<template>
    <div>
        <form @submit.prevent="submit" v-if="isAuthenticated">
            <div class="card-body border-0">
                <textarea v-model="body"

                          class="form-control border-0 bg-light"
                          name="body"
                          :placeholder="`¿Qué piensas ${currentUser.name}?`"></textarea>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="create-status">Publicar estado</button>
            </div>
        </form>
        <div v-else class="card-body border-0">
            <a href="/login">Debes de hacer login</a>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                body: "",
            }
        },
        methods:{
            submit(){
                axios.post('/statuses', {body: this.body})
                .then(res=>{
                    EventBus.$emit('status-created', res.data.data); // ['data'=> ['body'=>'el body']]
                    this.body='';
                })
                .catch(err=>{
                    console.log(err.response.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
