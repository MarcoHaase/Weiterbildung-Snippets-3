<template>
  <div class="card">
    <div class="card-header">User Profile ID: {{ id }}</div>
    <div class="card-body">
      <p><img src="" /></p>
      <!--<p><b>Name:</b> {{ vorname }} {{ name }}</p>-->
      <!--<p><b>Name:</b> {{ vorname + " " + name }}</p>-->
      <!--<p><b>Name:</b> {{ `${vorname} ${name}` }}</p>-->
      <p class="name"><b>Name:</b> {{ fullname }}</p>
      <p><b>Telefon:</b> {{ telefon }}</p>
      <p><b>Geburtsdatum:</b> {{ gebdatum }}</p>
      <p><b>Alter:</b> {{ alter }} ({{ over18 }})</p>
      <!--
          if ($alter < 18) {

          }else if ($alter == 18) {

          }else{

          }
      -->
      <p v-if="alter < 18">User ist noch nicht volljährig!</p>
      <p v-else-if="alter == 18">User ist gerade 18 geworden!</p>
      <p v-else>User ist über 18 Jahre alt!</p>

      <p v-show="alter < 18">User ist noch nicht volljährig!</p>
      <p v-show="alter == 18">User ist gerade 18 geworden!</p>
      <p v-show="alter > 18">User ist über 18 Jahre alt!</p>
      <input type="checkbox" checked v-if="fschein">
      <input type="checkbox" v-else> Führerschein
      <p><b>Wohnort:</b> {{ wohnort }}</p>
      <p><b>Lieblingsfarben:</b>
      <ul>
          <!--
            foreach ($colors as $key => $color) {
              echo "<li key='$color->id'>".$color->name."</li>"
            }
          -->
          <li v-for="(color, index) in colors" :key="color.id">
            {{ ++index }}  {{ color.name }}
          </li>
      </ul>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: "UserProfile",
  data: () => ({
    vorname: "Max",
    fschein: false,
    name: "Mustermann",
    telefon: "017612345678",
    gebdatum: "01.01.2000",
    alter: 17,
    wohnort: "Musterstadt",
    colors: [
      { id: 1, name: "rot" },
      { id: 2, name: "gelb" },
      { id: 3, name: "grün" },
    ],
  }),
  computed: {
    fullname() {
      return `${this.vorname} ${this.name}`;
    },
    over18() {
      return this.alter > 17 ? "volljährig" : "nicht volljährig";
    },
  },
  props: {
    id: String,
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

<style scoped>
.name {
  border: 1px solid red;
  margin: 5px;
}
</style>
