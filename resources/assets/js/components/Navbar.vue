<template>
  <div class="wrapper">
    <!-- Main Header -->
    <header class="main-header" v-if="this.app.user">
      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>i</b>APP</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><router-link class="white" to="/"><b>invent</b>APP</router-link></span>
      </a>

      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" data-toggle="push-menu" role="button"><font-awesome-icon icon="bars" />
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                <img src="/img/user.png" class="user-image" alt="User Image">{{app.user.name}} {{app.user.lastname}}
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <!-- <span class="hidden-xs">{{this.user.name}}</span> -->
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  <img src="/img/user.png" class="img-circle" alt="User Image" >
                  <span class="logo-lg">
                    {{app.user.name}} {{app.user.lastname}}
                  </span>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                  <div class="pull-left">
                    <a><router-link to="/korisnik" class="nav-link"><font-awesome-icon icon="edit" /> Izmjena podataka</router-link></a>
                  </div>
                  <div class="pull-right">
                    <li><a href="#" @click.prevent="logout" class="nav-link"><font-awesome-icon icon="sign-out-alt" /> Odjava</a></li>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar" v-if="this.app.user">

      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel" v-if="this.app.user">
          <div class="pull-left image">
            <img src="/img/user.png" class="img-circle" alt="User Image">
            <span style="color:Orange" class="logo-lg"> {{app.user.name}} {{app.user.lastname}}</span>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">IZBORNIK</li>
          <!-- Optionally, you can add icons to the links -->
          <li><router-link to="/inventar" class="nav-link"><font-awesome-icon icon="boxes" /> <span>Inventar</span></router-link></li>
          
          <li><router-link to="/tvrtka" class="nav-link"><font-awesome-icon icon="building" /> <span>Tvrtke</span></router-link></li>

          <li><router-link to="/qr" class="nav-link"><font-awesome-icon icon="qrcode" /> <span>Qr čitač</span></router-link></li>

          <li class="treeview">
            <a href="#"><font-awesome-icon icon="link" /> <span>Prostori i prostorije</span>
            </a>
            <ul class="treeview-menu">
              <li><router-link to="/prostor" class="nav-link">Prostori</router-link></li>
              <li><router-link to="/prostorija" class="nav-link">Prostorije</router-link></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#"><font-awesome-icon icon="link" /> <span>Kategorije i vrste</span>
            </a>
            <ul class="treeview-menu">
              <li><router-link to="/kategorija" class="nav-link">Kategorije</router-link></li>
              <li><router-link to="/vrsta" class="nav-link">Vrste</router-link></li>
            </ul>
          </li>
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header" v-if="this.app.user">
        <ol class="breadcrumb">
        </ol>
      </section>
  <!--main content-->
      <section class="content container-fluid">

        <router-view :app="this.app"></router-view>   
      </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- Default to the left -->
      <strong>&copy; 2020 <a href="#">InventApp</a>.</strong>
    </footer>
  </div>


</template>

<script>
export default {
    user: {},
    name: 'navbar',
    props: ['app'],
    data() {
        return {
          component:'inventar',
        }
    },
    methods: {
      
        logout() {
            this.app.req.post('auth/logout').then(() => {
                this.app.user = null;
                this.$router.push('/login');
            });
        },
        prev() {
        this.$refs.myCarousel.prev()
        },
        next() {
        this.$refs.myCarousel.next()
        },

        loadUsers(){

          axios.get("auth/init").then(({ data }) => (

            console.log(data)
          ));
        },
        created() {
          this.loadUsers();
          
          Fire.$on('AfterCreate',() => {
                    this.loadUsers();
                });
        },
    }
}
</script>
  
<style>
.mrg-left{
  margin-left: 0 !important;
}
.white{
  color: aliceblue;
}
</style>