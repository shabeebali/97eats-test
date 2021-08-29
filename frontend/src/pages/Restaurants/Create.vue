<template>
  <q-page class="q-px-md">
    <q-card class="q-mt-md">
      <q-toolbar>
        <q-toolbar-title>{{pageTitle}}</q-toolbar-title>
        <q-btn label="Save" color="green" @click="saveFn"/>
      </q-toolbar>
      <q-separator/>
      <q-form ref="form">
        <q-card-section>
          <div class="row q-col-gutter-md">
            <div class="col-12 col-md-6">
              <q-input label="Name" filled v-model="model.name" :rules="[v => !!v || 'Required']"/>
            </div>
            <div class="col-12 col-md-6">
              <q-input label="Category" filled v-model="model.category" :rules="[v => !!v || 'Required']"/>
            </div>
          </div>
          <div class="row q-mt-md">
            <div class="col-12">
              <div class="text-subtitle2">Description</div>
              <q-editor v-model="model.description" rows="2"/>
            </div>
          </div>
          <div class="row q-col-gutter-md q-mt-md">
            <div class="col-12 col-md-6">
              <q-uploader
                style="width:100%"
                :url="$axios.defaults.baseURL + '/image'"
                accept=".jpg, image/*"
                :max-files="1"
                label="Upload Thumbnail Image"
                :headers="imgUploadHeaders"
                field-name="file"
                @uploaded="thumbnailUploaded"
                ref="thumbnailUploaderRef"
              />
            </div>
            <div class="col-12 col-md-6">
              <q-uploader
                style="width:100%"
                :url="$axios.defaults.baseURL + '/image'"
                :max-files="1"
                accept=".jpg, image/*"
                label="Upload Cover Image"
                :headers="imgUploadHeaders"
                field-name="file"
                @uploaded="coverImageUploaded"
                ref="coverUploaderRef"
              />
            </div>
          </div>
          <div class="row q-mt-md justify-center q-col-gutter-md">
            <div class="col-6 col-md-3" v-if="model.thumbnail_image">
              <q-card>
                <q-img :src="getImgSrc(model.thumbnail_image)" @click="imgSrc = getImgSrc(model.thumbnail_image); imageDialog = true; "/>
                <q-card-actions class="justify-center flex">
                  <q-btn flat label="Delete Thumbnail Image" no-caps @click="model.thumbnail_image = null"/>
                </q-card-actions>
              </q-card>
            </div>
            <div class="col-6 col-md-3" v-if="model.cover_image">
              <q-card>
                <q-img :src="getImgSrc(model.cover_image)" @click="imgSrc = getImgSrc(model.cover_image); imageDialog = true; "/>
                <q-card-actions class="justify-center flex">
                  <q-btn flat label="Delete Cover Image" no-caps @click="model.cover_image = null"/>
                </q-card-actions>
              </q-card>
            </div>
          </div>
          <div class="row q-mt-md q-col-gutter-md">
            <div class="col-12 col-md-4">
              <q-input v-model="model.location" label="Location" filled :rules="[v => !!v || 'Required']"/>
            </div>
            <div class="col-12 col-md-4">
              <q-select v-model="model.delivery_method" label="Delivery Method" :options="['Take Away','Home Delivery']" filled @input="changedDeliveryMethod" :rules="[v => !!v || 'Required']"/>
            </div>
            <div class="col-12 col-md-4">
              <q-input v-model.number="model.delivery_charge" :disable="model.delivery_method === 'Take Away'" label="Delivery Charge" class="input-right" filled :rules="[deliveryChargeValidation]"/>
            </div>
          </div>
        </q-card-section>
      </q-form>
      <q-separator/>
      <q-card-section>
        <q-table
        title="Items"
        :data="model.items"
        :columns="columns"
        :rows-per-page-options="[0]"
        >
        <template v-slot:top-right>
          <q-btn color="pink-8" label="Add Item" no-caps @click="addItem"/>
        </template>
        <template v-slot:body-cell-addons="props">
          <q-td :props="props">
            <ul>
              <li v-for="(addon,i) in props.row.addons" :key="i">
                {{addon.name}}
                <ul v-if="addon.options.length > 0">
                  <li v-for="(option) in addon.options" :key="option.name">
                    {{option.name}}: {{option.price}} AED
                  </li>
                </ul>
              </li>
            </ul>
          </q-td>
        </template>
        <template v-slot:body-cell-actions="props">
          <q-td :props="props">
            <q-btn flat label="Edit" icon="edit" @click="editItem(props.row)"/>
            <q-btn flat label="Delete" icon="delete" color="red" @click="deleteItem(props.row)"/>
          </q-td>
        </template>
        <template v-slot:body-cell-thumbnail_image="props">
          <q-td :props="props">
            <q-img :src="getImgSrc(props.row.thumbnail_image)" width="75px" height="75px" @click="imgSrc = getImgSrc(props.row.thumbnail_image); imageDialog = true"/>
          </q-td>
        </template>
        <template v-slot:body-cell-cover_image="props">
          <q-td :props="props">
            <q-img :src="getImgSrc(props.row.cover_image)" width="75px" height="75px" @click="imgSrc = getImgSrc(props.row.cover_image); imageDialog = true"/>
          </q-td>
        </template>
        </q-table>
      </q-card-section>
    </q-card>
    <q-dialog v-model="itemDialog" maximized>
      <q-card>
        <q-toolbar class="bg-pink-9 text-white" dark>
          <q-toolbar-title>Add Item</q-toolbar-title>
          <q-btn flat label="Save Item" no-caps @click="saveItem"/>
          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>
        <q-form ref="itemFormRef">
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div class="col-12 col-md-6">
                <q-input v-model="item.name" filled label="Name" :rules="[v => !!v || 'Required']"/>
              </div>
              <div class="col-6 col-md-3">
                <q-input v-model="item.category" filled label="Category" :rules="[v => !!v || 'Required']"/>
              </div>
              <div class="col-6 col-md-3">
                <q-input v-model.number="item.price" filled label="Price" class="input-right" :rules="[priceValidation]"/>
              </div>
            </div>
            <div class="row q-mt-md col-col-gutter-md">
              <div class="col-12">
                <div class="text-subtitle2">Description</div>
                <q-editor v-model="item.description" rows="2"/>
              </div>
            </div>
            <div class="row q-col-gutter-md q-mt-md">
              <div class="col-12 col-md-6">
                <q-uploader
                  style="width:100%"
                  :url="$axios.defaults.baseURL + '/image'"
                  accept=".jpg, image/*"
                  :max-files="1"
                  label="Upload Thumbnail Image"
                  :headers="imgUploadHeaders"
                  field-name="file"
                  @uploaded="itemThumbnailUploaded"
                  ref="itemThumbnailUploaderRef"
                />
              </div>
              <div class="col-12 col-md-6">
                <q-uploader
                  style="width:100%"
                  :url="$axios.defaults.baseURL + '/image'"
                  :max-files="1"
                  accept=".jpg, image/*"
                  label="Upload Cover Image"
                  :headers="imgUploadHeaders"
                  field-name="file"
                  @uploaded="itemCoverImageUploaded"
                  ref="itemCoverUploaderRef"
                />
              </div>
            </div>
            <div class="row q-mt-md justify-center q-col-gutter-md">
              <div class="col-6 col-md-3" v-if="item.thumbnail_image">
                <q-card>
                  <q-img :src="getImgSrc(item.thumbnail_image)" @click="imgSrc = getImgSrc(item.thumbnail_image); imageDialog = true; "/>
                  <q-card-actions class="justify-center flex">
                    <q-btn flat label="Delete Thumbnail Image" no-caps @click="item.thumbnail_image = null"/>
                  </q-card-actions>
                </q-card>
              </div>
              <div class="col-6 col-md-3" v-if="item.cover_image">
                <q-card>
                  <q-img :src="getImgSrc(item.cover_image)" @click="imgSrc = getImgSrc(item.cover_image); imageDialog = true; "/>
                  <q-card-actions class="justify-center flex">
                    <q-btn flat label="Delete Cover Image" no-caps @click="item.cover_image = null"/>
                  </q-card-actions>
                </q-card>
              </div>
            </div>
          </q-card-section>
          <q-separator/>
          <q-card-section>
            <q-table
            title="Addons"
            :data="item.addons"
            :columns="addonColumns"
            >
            <template v-slot:top-right>
              <q-btn label="Add Addon" no-caps color="pink-9" @click="addAddon"/>
            </template>
            <template v-slot:body-cell-actions="props">
              <q-td :props="props">
                <q-btn label="Edit" flat icon="edit" no-caps @click="editAddon(props.row)"/>
                <q-btn flat label="Delete" icon="delete" color="red" @click="deleteAddon(props.row)"/>
              </q-td>
            </template>
            <template v-slot:body-cell-options="props">
              <q-td :props="props">
                <ul>
                  <li v-for="(option,i) in props.row.options" :key="i">{{option.name}}: {{option.price}} AED</li>
                </ul>
              </q-td>
            </template>
            </q-table>
          </q-card-section>
        </q-form>
        <q-card-actions>
          <q-btn color="green" label="Save Item" no-caps @click="saveItem"/>
          <q-btn flat label="Cancel" no-caps v-close-popup/>
        </q-card-actions>
      </q-card>
    </q-dialog>
    <q-dialog v-model="imageDialog" full-width>
      <q-card>
        <q-toolbar>
          <q-toolbar-title>Image Preview</q-toolbar-title>
          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>
        <q-img :src="imgSrc"/>
      </q-card>
    </q-dialog>
    <q-dialog v-model="addonDialog">
      <q-card style="width:500px; max-width:100%;">
        <q-toolbar class="bg-pink-7 text-white">
          <q-toolbar-title>Add Addon</q-toolbar-title>
          <q-btn flat round dense icon="close" v-close-popup />
        </q-toolbar>
        <q-form ref="addonFormRef">
          <q-card-section>
            <q-input v-model="addon.name" filled label="Addon Title" :rules="[v => !!v || 'Required']"/>
          </q-card-section>
          <q-separator/>
          <q-card-section>
            <div class="text-subtitle2">Options</div>
            <div class="row q-col-gutter-md" v-for="(option,i) in addon.options" :key="i">
              <div class="col-6">
                <q-input v-model="addon.options[i].name" label="Name" filled dense :rules="[v => !!v || 'Required']"/>
              </div>
              <div class="col-5">
                <q-input v-model.number="addon.options[i].price" label="Price" class="input-right" filled dense :rules="[priceValidation]"/>
              </div>
              <div class="col-1">
                <q-btn v-if="addon.options.length > 1" flat round icon="delete" color="red" @click="deleteOption(option,i)"/>
              </div>
            </div>
            <div class="row q-mt-sm">
              <q-btn color="pink-9" label="Add Option" no-caps @click="addOption"/>
            </div>
          </q-card-section>
        </q-form>
        <q-card-actions>
          <q-btn label="Save" no-caps color="green" @click="saveAddon"/>
          <q-btn label="Cancel" flat no-caps v-close-popup/>
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>
<script>
export default {
  data () {
    return {
      imageDialog: false,
      imgSrc: null,
      addonDialog: false,
      addonEdit: false,
      addon: {
        name: null,
        options: []
      },
      itemDialog: false,
      itemEdit: false,
      item: {
        name: null,
        category: null,
        description: '',
        thumbnail_image: null,
        cover_image: null,
        addons: [],
        price: 0.00
      },
      model: {
        name: null,
        category: null,
        thumbnail_image: null,
        cover_image: null,
        description: '',
        location: null,
        delivery_method: null,
        delivery_charge: 0.00,
        items: []
      },
      addonColumns: [
        {
          name: 'name',
          field: 'name',
          label: 'Name',
          align: 'left',
          sortable: true
        },
        {
          name: 'options',
          field: 'options',
          label: 'Options',
          align: 'left',
          sortable: false
        },
        {
          name: 'actions',
          field: 'actions',
          label: 'Actions',
          align: 'right',
          sortable: false
        }
      ],
      columns: [
        {
          name: 'name',
          field: 'name',
          label: 'Name',
          align: 'left',
          sortable: true
        },
        {
          name: 'price',
          field: 'price',
          label: 'Price',
          align: 'right',
          sortable: true
        },
        {
          name: 'thumbnail_image',
          field: 'thumbnail_image',
          label: 'Thumbnail',
          align: 'center',
          sortable: false
        },
        {
          name: 'cover_image',
          field: 'cover_image',
          label: 'Cover',
          align: 'center',
          sortable: false
        },
        {
          name: 'addons',
          field: 'addons',
          label: 'Addons',
          align: 'left',
          sortable: false
        },
        {
          name: 'actions',
          field: 'actions',
          label: 'Actions',
          align: 'right',
          sortable: false
        }
      ]
    }
  },
  computed: {
    pageTitle () {
      if (this.$route.params.id) {
        return 'Edit: ' + this.model.name
      }
      return 'Create New Restaurant'
    },
    imgUploadHeaders () {
      const token = localStorage.getItem('token')
      return [
        {
          name: 'Authorization',
          value: 'Bearer ' + token 
        }
      ]
    }
  },
  mounted () {
    if (this.$route.params.id) {
      this.$q.loading.show()
      this.$axios.get('restaurants/' + this.$route.params.id).then((res) => {
        this.model = res.data
        if (!this.model.description) this.model.description = ''
        this.model.items.forEach((item,i) => {
          if(!this.item.description) this.model.items[i].description = ''
        })
      }).finally(() => {
        this.$q.loading.hide()
      })
    }
  },
  methods: {
    changedDeliveryMethod (val) {
      if (val === 'Take Away') {
        this.model.delivery_charge = 0.00
      }
    },
    imgSelected (val) {
      console.log(val)
    },
    getImgSrc(src) {
      if (src) {
        const baseUrl = this.$axios.defaults.baseURL.substr(0, this.$axios.defaults.baseURL.length - 4)
        return baseUrl + '/storage/' + src
      }
      return ''
    },
    thumbnailUploaded ({xhr}) {
      this.model.thumbnail_image = xhr.response
      this.$refs.thumbnailUploaderRef.removeUploadedFiles()
    },
    coverImageUploaded ({xhr}) {
      this.model.cover_image = xhr.response
      this.$refs.coverUploaderRef.removeUploadedFiles()
    },
    itemThumbnailUploaded ({xhr}) {
      this.item.thumbnail_image = xhr.response
      this.$refs.itemThumbnailUploaderRef.removeUploadedFiles()
    },
    itemCoverImageUploaded ({xhr}) {
      this.item.cover_image = xhr.response
      this.$refs.itemCoverUploaderRef.removeUploadedFiles()
    },
    addItem () {
      this.itemEdit = false
      this.item = {
        name: null,
        category: null,
        description: '',
        thumbnail_image: null,
        cover_image: null,
        addons: [],
        price: 0.00
      }
      this.itemDialog = true
    },
    editItem (row) {
      this.itemEdit = true
      this.item = row
      this.itemDialog = true
    },
    priceValidation (val) {
      if (!val) return 'Required'
      else if (isNaN(val)) return 'Invalid'
      else return true
    },
    addAddon () {
      this.addonEdit = false
      this.addon = {
        name: null,
        options: [
          { name: null, price: 0 }
        ]
      }
      this.addonDialog = true
    },
    addOption () {
      this.addon.options.push({
        name: null,
        price: 0
      })
    },
    saveAddon () {
      this.$refs.addonFormRef.validate().then((success) => {
        if (success) {
          if (!this.addonEdit){
            if (this.$_.findIndex(this.item.addons, v => v.name === this.addon.name) === -1) {
              this.item.addons.push(this.addon)
              this.addonDialog = false
            } else {
              this.$q.notify({
                message: 'Duplicate Entry',
                type: 'negative'
              })
            }
          } else {
            this.addonDialog = false
          }
        } else {
          this.$q.notify({
            message: 'There are errors in the data submitted.',
            type: 'negative'
          })
        }
      })
    },
    editAddon (row) {
      this.addonEdit = true
      this.addon = row
      this.addonDialog = true
    },
    saveItem () {
      this.$refs.itemFormRef.validate().then((success) => {
        if (success) {
          if (!this.itemEdit){
            if (this.$_.findIndex(this.model.items, v => v.name === this.item.name) === -1) {
              this.model.items.push(this.item)
              this.itemDialog = false
            } else {
              this.$q.notify({
                message: 'Duplicate Entry',
                type: 'negative'
              })
            }
          } else {
            this.itemDialog = false
          }
        } else {
          this.$q.notify({
            message: 'There are errors in the data submitted.',
            type: 'negative'
          })
        }
      })
    },
    saveFn () {
      this.$refs.form.validate().then((success) => {
        if (success) {
          this.$q.loading.show()
          let route = 'restaurants'
          if (this.$route.params.id) {
            route = 'restaurants/' + this.$route.params.id
            this.model._method = 'PUT'
            this.$axios.put(route,this.model).then((res) => {
              if (res.data.message === 'success') {
                this.$q.notify({
                  message: 'Data Saved Successfully',
                  type: 'positive'
                })
                this.$router.push('/restaurants')
              }
            }).finally(() => {
              this.$q.loading.hide()
            })
          } else {
            this.$axios.post(route,this.model).then((res) => {
              if (res.data.message === 'success') {
                this.$q.notify({
                  message: 'Data Saved Successfully',
                  type: 'positive'
                })
                this.$router.push('/restaurants')
              }
            }).finally(() => {
              this.$q.loading.hide()
            })
          }
        } else {
          this.$q.notify({
            message: 'There are errors in the data submitted.',
            type: 'negative'
          })
        }
      })
    },
    deliveryChargeValidation (val) {
      if (this.model.delivery_method !== 'Take Away') {
        return this.priceValidation(val)
      } else {
        return true
      }
    },
    deleteOption (model,i) {
      this.$q.dialog({
        title: 'Confirm',
        message: 'Do you want to delete this record?',
        ok: {
          label: 'Yes',
          color: 'red',
          flat: true
        },
        cancel: {
          label: 'No',
          color: 'green'
        }
      }).onOk(() => {
        if (model.id) {
          this.$q.loading.show()
          this.$axios.delete('options/' + model.id, { _method: 'DELETE' }).then((res) => {
            if (res.data.message === 'success') {
              this.addon.options.splice(i,1)
            }
          }).finally(() => {
            this.$q.loading.hide()
          })
        } else {
          this.addon.options.splice(i,1)
        }
      })
    },
    deleteAddon (model,i) {
      this.$q.dialog({
        title: 'Confirm',
        message: 'Do you want to delete this record?',
        ok: {
          label: 'Yes',
          color: 'red',
          flat: true
        },
        cancel: {
          label: 'No',
          color: 'green'
        }
      }).onOk(() => {
        if (model.id) {
          this.$q.loading.show()
          this.$axios.delete('addons/' + model.id, { _method: 'DELETE' }).then((res) => {
            if (res.data.message === 'success') {
              this.item.addons.splice(i,1)
            }
          }).finally(() => {
            this.$q.loading.hide()
          })
        } else {
          this.item.addons.splice(i,1)
        }
      })
    },
    deleteItem (model,i) {
      this.$q.dialog({
        title: 'Confirm',
        message: 'Do you want to delete this record?',
        ok: {
          label: 'Yes',
          color: 'red',
          flat: true
        },
        cancel: {
          label: 'No',
          color: 'green'
        }
      }).onOk(() => {
        if (model.id) {
          this.$q.loading.show()
          this.$axios.delete('items/' + model.id, { _method: 'DELETE' }).then((res) => {
            if (res.data.message === 'success') {
              this.model.items.splice(i,1)
            }
          }).finally(() => {
            this.$q.loading.hide()
          })
        } else {
          this.model.items.splice(i,1)
        }
      })
    }
  }
}
</script>