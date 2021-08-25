<template>
  <q-layout v-if="!appLoading">
    <q-header elevated>
      <q-toolbar class="bg-pink-8">
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title>
          97eats App
        </q-toolbar-title>

        <q-btn flat label="Logout" @click="logout()"/>

      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-1"
    >
      <q-list>
        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from 'components/EssentialLink.vue'

const linksData = [
  {
    title: 'Dashboard',
    icon: 'home',
    link: '/'
  },
  {
    title: 'Restaurants',
    icon: 'restaurant',
    link: '/restaurants'
  }
];
import { mapState } from 'vuex'
export default {
  name: 'MainLayout',
  components: { EssentialLink },
  data () {
    return {
      leftDrawerOpen: false,
      essentialLinks: linksData,
      appLoading: true
    }
  },
  computed: {
  },
  mounted () {
    this.initFn()
  },
  methods: {
     initFn () {
      this.$store.dispatch('init').then((msg) => {
        console.log('msg')
        this.appLoading = false
      }).catch((err) => {
        if (err === 'unauthenticated') {
          this.$router.push('/login')
        }
        if (err === 'ROUTE_MISSING') {
          this.$q.dialog({
            title: 'Select Backend',
            options: {
              type: 'radio',
              model: 'laravel',
              items: [
                { label: 'Laravel', value: 'laravel' },
                { label: 'Codeigniter', value: 'codeigniter' },
                { label: 'Core PHP', value: 'corephp', disable: true }
              ]
            },
            cancel: false,
            persistent: true
          }).onOk((data) => {
            this.$store.dispatch('setRoute',data)
            this.initFn()
          })
        }
      })
    },
    logout () {
      this.$q.dialog({
        title: 'Confirm',
        message: 'Do you want to logout?'
      }).onOk(() => {
        localStorage.removeItem('token')
        this.$router.go()
      })
    }
  }
}
</script>
