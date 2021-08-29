<template>
  <q-layout view="lHh Lpr lFf" v-if="!appLoading">
    <q-page-container>
      <q-page class="row justify-center items-center">
        <div class="col-12 col-md-4 bg-white">
          <q-card class="q-mt-sm" flat>
            <q-card-section>
              <div class="row">
                <div class="col-12">
                  <q-input
                    name="email"
                    outlined
                    v-model="model.email"
                    label="Email"
                    id="email"
                  />
                </div>
              </div>
              <div class="row q-mt-md">
                <div class="col-12">
                  <q-input
                    name="password"
                    outlined
                    v-model="model.password"
                    label="Password"
                    type="password"
                    id="password"
                  />
                </div>
              </div>
              <div class="row q-mt-md">
                <div class="col-12">
                  <q-checkbox v-model="model.remember" label="Remember Me?" color="lime-7"/>
                </div>
              </div>
            </q-card-section>
            
            <q-separator />
            <q-card-section>
              <q-btn color="pink-7" no-caps class="full-width" label="Login" @click="login()" />
            </q-card-section>
            <q-separator />
            <q-card-section class="text-center">
              <div class="text-subtitle2">Don't have account?</div>
              <q-btn no-caps label="Register" class="full-width" color="pink-8" @click="$router.push({name: 'RegisterPage'})"/>
            </q-card-section>
          </q-card>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { mapState } from 'vuex'
export default {
  data () {
    return {
      model: {
        email: '',
        password: '',
        remember: false
      },
      appLoading: true
    }
  },
  mounted () {
    this.initFn()
  },
  computed: {
  },
  methods: {
    initFn () {
      this.$store.dispatch('init').then((msg) => {
        if (msg === 'authenticated') {
          this.$router.push('/')
        }
      }).catch((err) => {
       console.log(err)
      }).finally(() => {
        this.appLoading = false
      })
    },
    login () {
      this.$q.loading.show()
      this.$axios.post('login', this.model).then((res) => {
        if (res.data.message === 'authenticated') {
          localStorage.setItem('token',res.data.token)
          this.$router.push('/')
        }
      }).catch((err) => {
        // console.log(err)
        if (err.response.status === 422 || err.response.status === 400) {
          this.$q.notify({
            type: 'negative',
            message: 'Incorrect credentials'
          })
        } else {
          this.$q.notify({
            type: 'negative',
            message: 'Something went wrong.'
          })
        }
      }).finally(() => {
        this.$q.loading.hide()
      })
    }
  }
}
</script>