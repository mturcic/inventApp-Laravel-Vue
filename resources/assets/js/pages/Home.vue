<template>
    <div>
        <b-carousel
          id="carousel-fade"
          style="text-shadow: 0px 0px 2px #000"
          fade
          indicators
          img-width="auto"
          img-height="100%"
        >
        <b-carousel-slide
          img-src="/images/inventory.jpg">
        <h4 v-if="this.app.user">Dobrodošli u InventApp - Pregled i unos stavki inventara</h4>
        <router-link v-else to="/login" class="nav-link">
            <b-button size="lg" variant="info">Prijava</b-button>
        </router-link>
        <h5><b-badge variant="dark">Želite napraviti novi korisnički račun?</b-badge></h5>
        <router-link to="/register" class="nav-link">
            <b-button size="lg" variant="info">Registracija</b-button>
        </router-link>
        </b-carousel-slide>
        <b-carousel-slide
          img-src="/images/qr-code.jpg">
        <h4 v-if="this.app.user">Dobrodošli u InventApp - Pregled i ispis QR-koda</h4>
        <router-link v-else to="/login" class="nav-link">
            <b-button size="lg" variant="info">Prijava</b-button>
        </router-link>
        <h5><b-badge variant="dark">Želite napraviti novi korisnički račun?</b-badge></h5>
        <router-link to="/register" class="nav-link">
            <b-button size="lg" variant="info">Registracija</b-button>
        </router-link> 
        </b-carousel-slide>
        <b-carousel-slide
          img-src="/images/classroom.png">
        <h4 v-if="this.app.user">Dobrodošli u InventApp - Pregled poslovnih prostora i prostorija</h4>
        <router-link v-else to="/login" class="nav-link">
            <b-button size="lg" variant="info">Prijava</b-button>
        </router-link>
        <h5><b-badge variant="dark">Želite napraviti novi korisnički račun?</b-badge></h5>
        <router-link to="/register" class="nav-link">
            <b-button size="lg" variant="info">Registracija</b-button>
        </router-link>
        </b-carousel-slide>
        </b-carousel>
      </div>   
</template>

<script>
     export default {
    user: {},
    name: 'home',
    props: ['app']
    }   
</script>

<style>
</style>