<template>
  <app>
    <v-container>
      <v-row>
        <v-col cols="8">
          <v-text-field v-model="DepartmentInfo.name" label="اسم القسم"></v-text-field>
        </v-col>
        <v-col cols="4">
          <div class="my-2">
            <v-btn depressed @click="updateDepartment" large color="primary">تعديل قسم</v-btn>
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
  name: "Department",
  props: ["DepartmentInfo"],
  components: {
    app
  },
  data() {
    return {
      department: "",
    };
  },
  methods: {
    updateDepartment: function() {
      axios.post(`/department/${this.DepartmentInfo.id}/update`, 
      { name: this.DepartmentInfo.name })
      .then(res => {
        if (res.data.status)
        this.$swal({
                icon: "success",
                title: "تم",
                text: "تمت العملية بنجاح"
              });
      });
    }

  }
};
</script>

<style>
</style>
