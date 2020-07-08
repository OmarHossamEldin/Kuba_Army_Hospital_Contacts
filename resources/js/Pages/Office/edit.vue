<template>
  <app>
    <v-container>
      <v-row align="center" justify="center">
        <v-select v-model="OfficeInfo.department_id" :items="departments" item-text="name"
          item-value="id" label="القسم" required></v-select>
      </v-row>
      <v-row>
        <v-col cols="4">
          <v-text-field v-model="OfficeInfo.name" label="اسم مكان التواجد"></v-text-field>
        </v-col>
        <v-col cols="4">
          <div class="my-2">
            <v-btn depressed @click="updateOffice" large color="primary">تعديل مكان التواجد</v-btn>
          </div>
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
  props: ["departments", "OfficeInfo"],
  components: {
    app
  },
  data() {
    return {
      department: "",
      office: "",
    };
  },
  methods: {
    updateOffice: function() {
      axios
        .post(`/office/${this.OfficeInfo.id}/update`, {
          department: this.OfficeInfo.department_id,
          office: this.OfficeInfo.name
        })
        .then(res => {
            
          if (res.data.status) this.$swal({
                icon: "success",
                title: "تم",
                text: "تمت العملية بنجاح"
              });

        });
    },

  }
};
</script>

<style>
</style>
