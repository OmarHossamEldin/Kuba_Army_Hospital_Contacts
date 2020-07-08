<template>
  <div>
    <ul class="nav">
      <v-col class="Align-Center" cols="11">
        <h1>جهات الإتصال بالمجمع الطبي ق.م بك القبة</h1>
      </v-col>
      <v-col class="Align-Center" cols="1">
        <inertia-link href="/login">
          <v-icon dark>mdi mdi-login</v-icon>
        </inertia-link>
      </v-col>
    </ul>

    <v-row class="rowStyle" align="center" justify="center">
      <v-col cols='12'>
        <v-card>
          <v-row>
            <v-col cols="3"></v-col>
            <v-col col="6">
              <v-card-title>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="إبحث "
                  single-line
                  hide-details
                  @change="searchKeyword"
                ></v-text-field>
              </v-card-title>
            </v-col>
            <v-col cols="3"></v-col>
            <v-col cols="12">
              <v-data-table :headers="headers" :items="Persons" class="elevation-1" >
              </v-data-table>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: ["Persons"],
  data() {
    return {
      search: "",
      prev: this.Persons,
      headers: [
        {
          text: "الرقم",
          value: "numbers",
          align:'right'
        },
        {
          text: "الإسم",
          value: "name",
          align:'right'
        },
        {
          text: "مكان التواجد",
          value: "office",
          align:'right'
        },
        {
          text: "القسم",
          value: "department",
          align:'right'
        },

      ]
    };
  },
  methods: {
    searchKeyword: function() {
      if (this.search == "") this.Persons = this.prev;
      else {
        axios.get(`/person/search/${this.search}`).then(res => {
          this.Persons = res.data.result;
        });
      }
    }
  },
  created() {
    document.body.style = "background-color:#cccccc";
    let el = (document.getElementsByClassName("v-row-group__header").innerHTML =
      "");
    console.log(el);
  }
};
</script>

<style scoped>
.rowStyle {
  margin-left: 50px;
  margin-right: 50px;
}
.iconStyle {
  text-decoration: none;
}
.Align-Center {
  text-align: center;
  color: white;
}
.nav {
  background-color: black;
}
</style>
