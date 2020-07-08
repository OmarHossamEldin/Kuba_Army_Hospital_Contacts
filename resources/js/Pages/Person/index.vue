<template>
  <app>
    <v-container>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            @keyup="SearchPerson"
          ></v-text-field>
        </v-col>
        <v-col cols="12">
          <v-data-table :headers="headers" :items="Persons" class="elevation-1">
            <template v-slot:item.id="{ item }">
              <inertia-link :href="'/person/'+item.id+'/delete'">
                <v-btn color="red">حذف</v-btn>
              </inertia-link>
              <inertia-link :href="'/person/'+item.id+'/edit'">
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
import app from "../../layout/index";
import axios from "axios";
export default {
  name: "Persons",
  props: ["Persons"],
  components: {
    app
  },
  data() {
    return {
      department: "",
      office: "",
      search: "",
      oldPerson: "",
      headers: [
        {
          align: "end",
          sortable: true
        },
        { text: "تحكم", value: "id" },
        { text: "الارقام", value: "numbers" },
        { text: "الاسم", value: "name" },
        { text: "مكان التواجد", value: "office" },
        { text: "القسم", value: "department" },
      ]
    };
  },
  methods: {
    SearchPerson: function() {
      if (!this.search) {
        this.Persons = this.oldPerson;
      } else {
        axios
          .post("/person/search", {
            Search: this.search
          })
          .then(res => {
            if (res.data.status) {
              this.Persons = res.data.data;
            }
          });
      }
    }
  },
  created() {
    this.oldPerson = this.Persons;

  }
};
</script>

<style>
</style>
