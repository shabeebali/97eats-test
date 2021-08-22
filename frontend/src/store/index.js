import Vue from 'vue'
import Vuex from 'vuex'
import { axiosInstance } from 'boot/axios'
import { LocalStorage } from 'quasar'
// import example from './module-example'

Vue.use(Vuex)

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation;
 *
 * The function below can be async too; either use
 * async/await or return a Promise which resolves
 * with the Store instance.
 */

export default function (/* { ssrContext } */) {
  const Store = new Vuex.Store({
    modules: {
      // example
    },

    state: {
    },
    mutations: {
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    actions: {
      init ({ state, commit }) {
        return new Promise(function(resolve,reject) {
          if (localStorage.token) {
            axiosInstance.defaults.headers.common['Authorization'] = 'Bearer '+ localStorage.token
            axiosInstance.get('user').then((res) => {
              if (res.status === 200) {
                resolve('authenticated')
              } else {
                reject('unauthenticated')
              }
            }).catch((e) => {
              reject('unauthenticated')
            })
          } else {
            reject('unauthenticated')
          }
        })
      }
    },
    strict: process.env.DEBUGGING
  })

  return Store
}