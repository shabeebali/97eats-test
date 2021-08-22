<template>
  <div>
    <q-page class="q-px-md">
      <q-table
      class="q-mt-md"
      :data="items"
      :columns="columns"
      title="Restaurants"
      >
      <template v-slot:top-right>
        <q-btn color="pink-9" label="Create" to="/restaurants/create"/>
      </template>
      <template v-slot:body-cell-actions="props">
        <q-td :props="props">
          <q-btn  icon="edit" label="Edit" flat :to="'/restaurants/edit/' + props.row.id"/>
          <q-btn class="q-ml-md" icon="delete" color="red" label="delete" flat @click="deleteFn(props.row.id)"/>
        </q-td>
      </template>
      </q-table>
    </q-page>
  </div>
</template>
<script>
export default {
  data () {
    return {
      items: [],
      columns: [
        {
          name: 'id',
          field: 'id',
          label: 'ID',
          align: 'left',
          sortable: true
        },
        {
          name: 'name',
          field: 'name',
          label: 'Name',
          align: 'left',
          sortable: true
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
  mounted () {
    this.$q.loading.show()
    this.$axios.get('restaurants').then((res) => {
      this.items = res.data
    }).finally(() => {
      this.$q.loading.hide()
    })
  },
  methods: {
    deleteFn (id) {
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
        this.$axios.post('restaurants/' + id, { _method: 'DELETE' }).then((res) => {
          if (res.data.message === 'success') {
            this.$q.notify({
              message: 'Record Deleted from database',
              type: 'info'
            })
          }
        })
      })
    }
  }
}
</script>