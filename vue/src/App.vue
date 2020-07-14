<template>
    <div id="nav">
    <form>
    <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    <b-input v-model="appdata._wpnonce" type="hidden"></b-input>
    <input type="text" name="q" id="q" v-model="appdata.q" />&nbsp;
    <button type="submit" disabled v-if="appdata.q.length < 2">Search</button>  
    <button type="submit" @click="searchQuery" v-if="appdata.q.length > 1">Search</button>  
    </form>
    
	<hr v-if="isLoading===false">
	
	<ul v-if="total_results!==0">
		<li v-for="(item,key) in data" :key="key">
			<ul>
				<li v-for="(i,k) in item.shortdef" :key="k"><span :class="item.meta.lang"></span> {{item.fl}} {{i}}</li>
			</ul>
		</li>
	</ul>
	
	<ul v-if="total_results===0">
		<li><p>Nothing found for <b>{{this.appdata.q}}</b>.</p><p>Perhaps you meant one of these?</p></li>
		<li v-for="(item,key) in suggestions" :key="key"><a href="#" @click="suggestion(item)">{{item}}</a></li>
	</ul>

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
           suggestions: [],
           total_results: false
        }
    },
    methods: {
        searchQuery() {
	        
	        event.preventDefault()
	        
            this.isLoading = true
            
            var formData = new FormData();
            formData.append('_wpnonce',this.appdata._wpnonce)
            formData.append('action',this.appdata.action)
            formData.append('q',this.appdata.q)
            
    		this.$http.post(this.appdata.url,formData)
			.then( ( response ) => {
					
					this.isLoading = false;
					
					if(response.data[0].meta!=undefined) {
						
						console.log(response.data)
						this.total_results = response.data.length
						this.data = response.data
						this.suggestions = []
					} else if( response.data.length!=0) {
						this.suggestions = response.data
						this.data = []
						this.total_results = 0
					}
				}) 
				.catch( (errors) => {
					this.isLoading = false;
					console.log(errors);
				})
            
        },
        suggestion(item) {
	        this.suggestions = []
	        this.appdata.q = item
	        this.searchQuery()
        }
    },
    mounted() {
       
    }
    
}

</script>
<style lang="scss">

header {
	margin: 1rem;
}

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

ul {
	list-style: none;
}

ul li {
	list-style: none;
	margin: 0;
	padding: 0;
}

ul li ul {
	display: inline-block;
}

ul li ul li {
	list-style: none;
	margin: 0;
	padding: 0;
}

span.en,
span.es {
	display: inline-block;
	text-transform: capitalize;
	font-style: italic;
	font-size: .9em;
	border: solid 0px #000;
	border-radius: 4px;
	padding: .2em;
}

span.en:before {
	content: 'English';
}

span.es:before {
	content: 'Spanish';
}
</style>
