<template>
    <div>
    <navbar :app="this" class="mb-2"></navbar>  

    <spinner v-if="loading"></spinner>

    </div >  
  
</template>

<script>
import Navbar from './components/Navbar';
import Spinner from 'vue-simple-spinner'
import Home from './pages/Home';
export default {
    name: 'app',
    components: {
        Navbar,
        Spinner, Home
    },
    data() {
        return {
            user: null,
            loading: false,
            initiated: false,
            req: axios.create({
                baseUrl: BASE_URL
            })
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        init()
        {
            this.loading = true;

            this.req.get("auth/init")
            .then(response => {
                this.user = response.data.user;
                this.loading = false;
                this.initiated = true;
            })
        }
    },
};
</script>

<style>
</style>