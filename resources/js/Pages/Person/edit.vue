<template>
  <app>
    <v-container>
    <v-col cols="12" sm="4">
        <v-overflow-btn
          class="my-2"
          :items="departments"
          label="القســم"
          editable
          item-text="name"
          item-value="id"
          v-model="department"
          @change="showOffices(department)"
        ></v-overflow-btn>
      </v-col>
      <v-col cols="12" sm="4">
        <v-overflow-btn
          class="my-2"
          :items="Offices"
          label="مكان التواجد"
          editable
          item-text="name"
          item-value="id"
          v-model="office"
        ></v-overflow-btn>
      </v-col>
      <div class="boundriesDiv">
        <v-row v-for="(person,key) in personforms" :key="key">
          <v-col cols="5">
            <v-text-field v-model="person.name" label="اسم الشخص"></v-text-field>
          </v-col>
          <v-col v-for="(number,key) in person.numbers.length" :key="key" cols="2">
            <v-text-field @keyup="checkPhone(person.numbers[number-1],key,number-1)" v-model="person.numbers[number-1]" label="الرقم"></v-text-field>
          </v-col>
          <v-col cols="1">
            <v-btn @click="addNumber(person.numbers)" absolute dark fab color="pink">
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </div>
      <v-row style="margin-top:50px" align="center" justify="center">
        <v-btn @click="Update" depressed :disabled="disableBtn" large color="primary">حفظ</v-btn>
      </v-row>
    </v-container>
  </app>
</template>

<script>
import app from "../../layout";
import axios from "axios";
import auth from "../../utils/Auth";

export default {
  name: "PersonEdit",
  props: ["PersonInfo", "departments"],
  data() {
    return {
      office: "",
      department: "",
      Offices: "",
      personforms: [{ name: "", numbers: Array(1) }],
      disableBtn:false
    };
  },
  components: {
    app
  },
  methods: {
    addNumber: function(numbers) {
      if (numbers.length != 3) {
        numbers.push("");
      } else {
        return;
      }
    },
    showOffices: function(department){
        axios.get(`/department/get_offices/${department}`)
        .then(res => {
          if (res.data.status) {
            this.Offices = res.data.offices
          }
        });

    },
    checkPhone: function(number,person,index){
      axios.get(`/person/checkPhone/${number}`)
        .then(res => {
          if (res.data.status) {
            if(!res.data.unique){
              this.$swal({
                icon: "error",
                title: "خطأ",
                text: "هذاالرقم مسجل من قبل",
              });
             this.disableBtn = true;
            }else{
              this.disableBtn = false;
            }
          }
        });
    },
    Update: function() {
      
      axios
        .post(`/person/${this.PersonInfo.id}/update`, {
          PersonInfo: this.personforms,
          office: this.office
        })
        .then(res => {
          console.log(res);
          if (res.data.status) {
            this.$swal({
              icon: "success",
              title: "تم",
              text: "تمت العملية بنجاح",
            });
          }
        });
    }
  },
  mounted() {
    this.department= this.PersonInfo.department;
    this.showOffices(this.department);
    this.office= this.PersonInfo.office;
    this.personforms[0].name= this.PersonInfo.name;
    for(let i=0;i<this.PersonInfo.phones.length;i++){
      this.personforms[0].numbers[i]= this.PersonInfo.phones[i];
    }
  }
};
</script>

<style scoped>
.boundriesDiv {
  border: 2px solid #cccccc;
  padding: 10px;
}
</style>
