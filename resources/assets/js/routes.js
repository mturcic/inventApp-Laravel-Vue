import VueRouter from 'vue-router'

import Home from './pages/Home';
import Register from './pages/Register';
import Korisnik from './pages/Korisnik.vue';
import Login from './pages/Login';
import Kategorije from './pages/Kategorija/Kategorije.vue';
import KategorijaPrikaz from './pages/Kategorija/PrikazKategorija.vue'
import Prostori from './pages/Prostor/Prostori.vue';
import ProstorPrikaz from './pages/Prostor/PrikazProstora.vue';
import Prostorije from './pages/Prostorija/Prostorije.vue';
import ProstorijaPrikaz from './pages/Prostorija/PrikazProstorija.vue';
import Inventar from './pages/Inventar/Inventar.vue';
import Vrste from './pages/Vrsta/Vrste.vue';
import VrstaPrikaz from './pages/Vrsta/PrikazVrsti.vue';
import Tvrtke from './pages/Tvrtka/Tvrtke.vue';
import TvrtkaPrikaz from './pages/Tvrtka/PrikazTvrtki.vue'
import Qr from './pages/Qr/Qr.vue';
import notFound from './pages/404.vue';

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home',
        meta: {
            auth: undefined
        }
    },
    {   path: '*',
        name: '404', 
        component: notFound,
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
    },
    {
        path: '/korisnik',
        name: 'korisnik',
        component: Korisnik,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/kategorija',
        component: Kategorije,
        name: 'indexKategorija',
        meta: {
            title: 'Inventapp - Kategorija'
        }
    },
    {
        path: '/kategorija/:id',
        component: KategorijaPrikaz,
        name: 'showKategorija'
    },
    {
        path: '/prostor',
        component: Prostori,
        name: 'indexProstori'
    },
    {
        path: '/prostor/:id',
        component: ProstorPrikaz,
        name: 'showProstor'
    },
    {
        path: '/prostorija',
        component: Prostorije,
        name: 'indexProstorija'
    },
    {
        path: '/prostorija/:id',
        component: ProstorijaPrikaz,
        name: 'showProstorija'
    },
    {
        path: '/inventar',
        component: Inventar,
        name: 'indexInventar'
    },
    {
        path: '/vrsta',
        component: Vrste,
        name: 'indexVrsta'
    },
    {
        path: '/vrsta/:id',
        component: VrstaPrikaz,
        name: 'showVrsta'
    },
    {
        path: '/tvrtka',
        component: Tvrtke,
        name: 'indexTvrtka'
    },
    {
        path: '/tvrtka/:id',
        component: TvrtkaPrikaz,
        name: 'showTvrtka'
    },
    {
        path: '/qr',
        component: Qr,
        name: 'indexQr',
        meta: {
            title: 'Inventapp - Qr'
        }
    }
]

    const router = new VueRouter({
        history: true,
        //mode: 'history',
        routes,
      })
      export default router