<template>
  <app>
    <v-container>
      <v-row align="center" justify="center">
        <v-select
          v-model="department"
          :items="Departments"
          @change="showOffices(department)"
          label="القسم"
          required
          item-text="name"
          item-value="id"
        ></v-select>
      </v-row>
      <v-row>
        <v-col cols="4">
          <v-text-field v-model="office" label="اسم مكان التواجد"></v-text-field>
        </v-col>
        <v-col cols="4">
          <div class="my-2">
            <v-btn depressed @click="addoffice" large color="primary">اضافة مكان التواجد</v-btn>
          </div>
        </v-col>
      </v-row>
    </v-container>
    <v-container>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-data-table :headers="headers" :items="Offices" :search="search" class="elevation-1">
            <template v-slot:item.id="{ item }">
              <inertia-link :href="'/office/'+item.id+'/delete'">
                <v-btn color="red">حذف</v-btn>
              </inertia-link>
              <inertia-link :href="'/office/'+item.id+'/edit'">
                <v-btn color="info">تعديل</v-btn>
              </inertia-link>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
  </app>
</template>

<script>
import app from "../../layout";
import axios from "axios";
import auth from "../../utils/Auth";

export default {
  name: "Office",
  props: ["Departments", "Offices"],
  components: {
    app
  },
  data() {
    return {
      department: "",
      office: "",
      search: "",
      oldoffices: "",
      headers: [
        {
          align: "end",
          sortable: true
        },
        { text: "تحكم", value: "id" },
        { text: "القسم", value: "department.name" },
        { text: "مكان التواجد", value: "name" }
      ]
    };
  },
  methods: {
    addoffice: function() {
      axios
        .post("/office/store", {
          department: this.department,
          office: this.office
        })
        .then(res => {
          if (res.data.status)
            this.$swal({
              icon: "success",
              title: "تم",
              text: "تمت العملية بنجاح"
            });
          this.Offices = res.data.offices;
          this.office = "";
        });
    },
    showOffices: function(department) {
      this.oldOffices = this.Offices;
      axios.get(`/department/${department}/offices`).then(res => {
        if (res.data.status) {
          this.Offices = res.data.offices;
        }
      });
    }
  },
  created() {
    if (this.$page.flash != false) {
      this.$swal({
        icon: this.$page.flash[0],
        title: this.$page.flash[1],
        text: this.$page.flash[2]
      });
    }
  }
};
</script>

<style>
</style>
