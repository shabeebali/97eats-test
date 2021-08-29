<template>
  <q-layout view="lHh Lpr lFf" v-if="!appLoading">
    <q-page-container>
      <q-page class="row justify-center items-center">
        <div class="col-12 col-md-4">
          <q-card class="">
            <q-card-section class="bg-pink-7 text-white q-my-0 q-py-sm" dense>
              <div class="text-center text-h6 text-bold">Registration</div>
            </q-card-section>
            <q-separator/> 
            <q-card-section>
              <q-form ref="form">
                <div class="row q-col-gutter-sm">
                  <div class="col-12">
                    <q-input
                      name="name"
                      outlined
                      v-model="model.name"
                      label="Name"
                      id="name"
                      lazy-rules="ondemand"
                      :error="errors.name && errors.name.length > 0"
                      @input="errors.name = null"
                      :error-message="errors.name"
                      :rules="[v => !!v || 'Required']"
                    />
                  </div>
                </div>
                <div class="row q-mt-md">
                  <div class="col-12">
                    <q-input
                      name="email"
                      outlined
                      v-model="model.email"
                      label="Email"
                      id="email"
                      :error="errors.email && errors.email.length > 0"
                      @input="errors.email = null"
                      :error-message="errors.email"
                      lazy-rules="ondemand"
                      :rules="[v => !!v || 'Required', v => validateEmail(v)]"
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
                      :error="errors.password && errors.password.length > 0"
                      @input="errors.password = null"
                      :error-message="errors.password"
                      lazy-rules="ondemand"
                      :rules="[v => !!v || 'Required']"
                    >
                    </q-input>
                  </div>
                  <div class="col-12">
                    <q-input
                      name="password_confirmation"
                      outlined
                      v-model="model.password_confirmation"
                      label="Confirm Password"
                      type="password"
                      id="password_confirmation"
                      :error="errors.password_confirmation && errors.password_confirmation.length > 0"
                      @input="errors.password_confirmation = null"
                      :error-message="errors.password_confirmation"
                      lazy-rules="ondemand"
                      :rules="[v => !!v || 'Required']"
                    >
                    </q-input>
                  </div>
                </div>
              </q-form>
            </q-card-section>
            <q-separator />
            <q-card-actions>
              <q-btn color="pink-8" outline  label="Register"  class="full-width q-mt-sm" @click="register()"/>
            </q-card-actions>
          </q-card>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import { axiosInstance } from 'boot/axios'
import { mapState } from 'vuex'
export default {
  data () {
    return {
      model: {
        name: null,
        email: null,
        password: null,
        password_confirmation: null
      },
      errors: {
        name: null,
        password_confirmation: null,
        password: null,
        email: null
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
    register () {
      this.$refs.form.validate().then((success) => {
        if (success) {
          this.$q.loading.show()
          Object.keys(this.errors).forEach((key) => {
            this.errors[key] = null
          })
          this.$axios.post('register', this.model).then((res) => {
            if (res.data.message === 'success') {
              this.$q.notify('Registration is success. Login using your credentials')
              this.$router.push('/login')
            }
          }).catch((err) => {
            if (err.response.status === 422 || err.response.status === 400) {
              this.$q.notify({
                type: 'negative',
                message: 'There are errors in data submitted'
              })
              if('errors' in err.response.data) {
                Object.keys(err.response.data.errors).forEach((key) => {
                  this.errors[key] = err.response.data.errors[key][0]
                })
              } else if ('messages' in err.response.data) {
                Object.keys(err.response.data.messages).forEach((key) => {
                  this.errors[key] = err.response.data.messages[key]
                })
              }
            }
          }).finally(() => this.$q.loading.hide())
        }
      })
    },
    validateEmail (mail) {
      if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)) {
        return true
      }
      return 'Invalid Email'
    }
  }
}
</script>