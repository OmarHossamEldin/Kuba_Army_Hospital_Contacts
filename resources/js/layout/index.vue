<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app right>
      <v-list dense>
        <inertia-link href="/user/dashboard" class="linkStyle">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-view-dashboard</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>لائحة التحكم</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
        <inertia-link href="/department/create" class="linkStyle">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-office-building</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>اضافة اقسام</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
        <inertia-link href="/office/create" class="linkStyle">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-map-marker</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>إضافة مكان تواجد</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
        <inertia-link href="/person/create" class="linkStyle">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi mdi-account-box</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>إضافة جهة اتصال</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
        <inertia-link href="/person" class="linkStyle">
          <v-list-item>
            <v-list-item-action>
              <v-icon >mdi mdi-account-box-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>جهات الاتصال</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
        <inertia-link v-if=" $page.auth.user.role=='admin'" class="linkStyle" href="/user/create">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-account-arrow-left-outline</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>إنشاء مستخدم</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
        <inertia-link class="linkStyle" href="/user/logout">
          <v-list-item>
            <v-list-item-action>
              <v-icon>mdi-logout</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>تسجيل الخروج</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </inertia-link>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="#2F4F4F" dark>
      <v-toolbar-title>
        <inertia-link class="linkStyle" href="/">
          <v-icon dark>mdi mdi-home</v-icon>
        </inertia-link>
      </v-toolbar-title>

      <v-spacer></v-spacer>
        {{ $page.auth.user.name }}
      <v-toolbar-title></v-toolbar-title>

      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
    </v-app-bar>

    <v-main>
      <v-container>
        <v-row>
          <v-col>
            <slot></slot>
          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <v-footer color="#2F4F4F" app>
      <v-spacer></v-spacer>

      <span
        class="white--text"
      >جميع الحقوق محفوظه لفرع نظم المعلومات بالمجمع الطبي ق.م بك القبة &copy; {{new Date().getFullYear()}}-{{new Date().getFullYear()+1}}</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: "app",
  props: {
    source: String
  },
  data: () => ({
    drawer: null
  })
};
</script>

<style scoped>
.linkStyle {
  text-decoration: none;
  color: white;
}
</style>
