<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>إنشاء مستخدم</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field
                    v-model="user.name"
                    label="الاسم"
                    name="name"
                    prepend-icon="mdi-rename-box"
                    type="text"
                  ></v-text-field>
                  <v-text-field
                    v-model="user.username"
                    label="اسم المستخدم"
                    name="username"
                    prepend-icon="mdi-account"
                    type="text"
                  ></v-text-field>

                  <v-text-field
                    v-model="user.password"
                    :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="show2 ? 'text' : 'password'"
                    name="input-10-2"
                    label="كلمة المرور"
                    value
                    class="input-group--focused"
                    prepend-icon="mdi-lock"
                    @click:append="show2 = !show2"
                  ></v-text-field>
                    <v-row justify="space-around">
                      <v-switch v-model="user.type" value="admin" class="ma-4" label="متحكم"></v-switch>
                      <v-switch v-model="user.type" value="user" class="ma-4" label="مستخدم"></v-switch>
                    </v-row>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="create" color="primary">إنشاء</v-btn>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import axios from "axios";
export default {
  props: {
    source: String
  },
  data() {
    return {
      show2: false,
      user:{name: "",
            username: "",
            password: "",
            type: ""
        }
    };
  },
  methods: {
    create: function(){
       axios
        .post("/user/store", {User:this.user})
        .then(res => {
           if (res.data.status) {
             this.$swal({
              icon: "success",
              title: "تم",
              text: "تمت العملية بنجاح",
            });
           }
        });
    }
  }
};
</script>
