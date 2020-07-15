<template>
    <div :class="appdata.slug">
    <form>
    <b-loading :is-full-page="isFullPage" :active.sync="isLoading" :can-cancel="true"></b-loading>
    <b-input v-model="appdata._wpnonce" type="hidden"></b-input>
    <input type="text" name="q" id="q" v-model="appdata.q" />&nbsp;
    <button type="submit" disabled v-if="appdata.q.length < 2">Search</button>  
    <button type="submit" @click="searchQuery" v-if="appdata.q.length > 1">Search</button>  
    </form>
    
	<hr v-if="isLoading===false">
	<div v-if="total_results>0">
		<ul v-for="(item,key) in data" :data="data" :key="key">
			<li class="lang">{{language(item.meta.lang)}}</li>
			<li class="fl" >{{item.fl}}</li>
			<li class="shortdef"><Shortdef v-bind:item="item"></Shortdef></li>
		</ul>
	</div>
	<ul v-if="suggestions.length>0" :suggestions="suggestions">
		<li><p>Nothing found for <b>{{this.appdata.q}}</b>.</p><p>Perhaps you meant one of these?</p></li>
		<ul>
			<li v-for="(item,key) in suggestions" :key="key"><a href="#" @click="suggestion(item)">{{item}}</a></li>
		</ul>
	</ul>
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
            isLoading: false,
            isFullPage: true,
           appdata: this.$appdata,
           data: [],
           suggestions: [],
           total_results: 0,
           item: {}
        }
    },
    computed: {
 
	},
    methods: {

        searchQuery() {
	        
	        event.preventDefault()
	        
            this.isLoading = true
            this.total_results = 0
            this.data = []
            this.suggestions = []
            
            var formData = new FormData();
            formData.append('_wpnonce',this.appdata._wpnonce)
            formData.append('action',this.appdata.action)
            formData.append('q',this.appdata.q)
            
    		this.$http.post(this.appdata.url,formData)
			.then( ( response ) => {
					
					this.isLoading = false;
					
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
        },
        language(lang) {
	        
	        return (lang=='en') ? 'English' : 'Spanish'
        }
    },
    mounted() {
       
    }
}

</script>
<style lang="scss">
</style>
