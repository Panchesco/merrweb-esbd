<template>
    <div id="nav">
    <form>
    <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    <b-input v-model="appdata._wpnonce" type="hidden"></b-input>
            <b-field>
            <b-input placeholder="Search..."
                type="search"
                icon="magnify"
                icon-clickable
                @icon-click="searchIconClick"
                v-model="appdata.q">
            </b-input>
        </b-field>
    </form>
    <b-table :data="data" :columns="columns"></b-table>
    </div>
</template>
<script>

export default  {
    data() {
        return {
            isLoading: false,
            isFullPage: true,
           appdata: this.$appdata,
           data: [],
           columns: [{field:'id',label:'ID'},{'field':'result','label':'Result'}],
        }
    },
    methods: {
        searchIconClick() {
            this.isLoading = true
            console.log('clicked')
            
            var formData = new FormData();
            formData.append('_wpnonce',this.appdata._wpnonce)
            formData.append('action','methods')
            
        }
    },
    mounted() {
       
    }
    
}

</script>
<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
