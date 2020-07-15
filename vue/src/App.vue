<template>
    <div :class="appdata.slug">
    <form>
		<input v-model="appdata._wpnonce" type="hidden" />
		<input type="text" name="q" id="q" v-model="appdata.q" v-on:input="this.clearSuggestions" />
		<button type="submit" disabled v-if="appdata.q.length < 2">Search</button>  
		<button type="submit" @click="searchQuery" v-if="appdata.q.length > 1">Search</button>  
    </form>
	<hr v-if="isLoading==null">
	<div v-if="total_results>0">
		<ul v-for="(item,key) in data" :data="data" :key="key">
			<li class="lang">{{language(item.meta.lang)}}</li>
			<li class="fl" >{{item.fl}}</li>
			<li class="shortdef"><Shortdef v-bind:item="item"></Shortdef></li>
		</ul>
	</div>
	<ul v-if="showSuggs===true" :suggestions="suggestions">
		<li><p>{{noResults}}</p></li>
		<ul>
			<li v-for="(item,key) in suggestions" :key="key"><a href="#" @click="suggestion(item)">{{item}}</a></li>
		</ul>
	</ul>
    <div :id="loadingId" :class="isLoading"></div>
    </div>
</template>
<script>
import Shortdef from '@/components/Shortdef.vue'
export default  {
	components: {
		Shortdef
	},
    data() {
        return {
            isLoading: "",
            isFullPage: true,
            loadingId: this.$appdata.loadingId,
            loadingClass: this.$appdata.loadingClass,
            noResultsMsg: this.$appdata.noResultsMsg,
			appdata: this.$appdata,
			data: [],
			suggestions: [],
			total_results: 0,
			item: {},
			showSuggs: false
        }
    },
	computed: {
		noResults() {
			return this.noResultsMsg.replace('%s',this.appdata.q)
		}
	},
    methods: {
	    clearSuggestions() {
		    console.log('changed');
			this.showSuggs = false
	    },
        searchQuery() {
	        
	        event.preventDefault()
	        
            this.isLoading = this.loadingClass
            this.total_results = 0
            this.data = []
            this.suggestions = []
            this.showSuggs = false
            
            var formData = new FormData();
            formData.append('_wpnonce',this.appdata._wpnonce)
            formData.append('action',this.appdata.action)
            formData.append('q',this.appdata.q)
            
    		this.$http.post(this.appdata.url,formData)
			.then( ( response ) => {
					
					this.isLoading = "";
					
					if(response.data[0].meta!=undefined) {

						for( var i in response.data ) {
							if ( response.data[i].shortdef.length > 0 ) {

									this.data.push(response.data[i])
									this.total_results++
							}
						}
						
					} else if( response.data.length!=0) {
						this.suggestions = response.data
						this.data = []
						this.total_results = 0
						this.showSuggs = true
					}
				}) 
				.catch( (errors) => {
					this.isLoading = "";
					console.log(errors);
				})
            
        },
        suggestion(item) {
	        this.suggestions = []
	        this.appdata.q = item
	        this.searchQuery()
        },
        language(lang) {
	        
	        return (lang=='en') ? 'English' : 'Spanish'
        }
    },
    mounted() {
       
    }
}

</script>
<style>

#loading-status.loading:before {
	display: inline-block;
	padding: .4em;
	background: orange;
	content: "Loading...";
	margin: .8em 0;
	color: #fff;
	letter-spacing: .04em;
	font-family: Helvetica,arial,sans-seriv;
	font-size: .9rem;
}

</style>
