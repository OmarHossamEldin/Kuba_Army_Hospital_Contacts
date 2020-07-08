<template>
  <app class="appimg">
    <div class="arabicDirections">
    </div>
  </app>
</template>

<script>
import app from "../../layout";
import auth from "../../utils/Auth";
export default {
  name: "Dashoard",
  components: {
    app
  },
  created() {
    //auth();
  }
};
</script>

<style scoped>
.arabicDirections {
  text-align:right;
}

.appimg{
  background-image: url("/../images/phone.jpg");
  background-size: cover;
} 

</style>
