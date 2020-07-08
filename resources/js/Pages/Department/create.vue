<template>
  <app>
    <v-container>
      <v-row>
        <v-col cols="8">
          <v-text-field v-model="department" label="اسم القسم"></v-text-field>
        </v-col>
        <v-col cols="4">
          <div class="my-2">
            <v-btn depressed @click="addDepartment" large color="primary">اضافة قسم</v-btn>
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
            @keyup="SearchDepartment"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-data-table :headers="headers" :items="Departments" class="elevation-1">
            <template v-slot:item.id="{ item }">
              <inertia-link :href="'/department/'+item.id+'/delete'">
                <v-btn color="red">حذف</v-btn>
              </inertia-link>
              <inertia-link :href="'/department/'+item.id+'/edit'">
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
  name: "Department",
  props: ["Departments"],
  components: {
    app
  },
  data() {
    return {
      department: "",
      search: "",
      oldDepartments: "",
      headers: [
        {
          align: "end",
          sortable: true
        },
        { text: "تحكم", value: "id" },
        { text: "الاسم", value: "name" }
      ]
    };
  },
  methods: {
    addDepartment: function() {
      axios.post("/department/store", { name: this.department }).then(res => {
        if (res.data.status)this.$swal({
                icon: "success",
                title: "تم",
                text: "تمت العملية بنجاح"
              });
              this.Departments = res.data.departments
              this.department='';
      });
    },
    SearchDepartment: function() {
      if (!this.search) {
          this.Departments = this.oldDepartments;
      } else {
        axios
          .post("/department/search", {
            Search: this.search
          })
          .then(res => {
            if (res.data.status) {
              this.Departments = res.data.Department;
            }
          });
      }
    }
  },
  created() {
    this.oldDepartments = this.Departments;
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
