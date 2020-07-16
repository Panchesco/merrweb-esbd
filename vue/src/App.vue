<template>
    <div id="merrweb-api-wrapper" :class="appdata.slug">
    <form id="merrweb-api">
		<div class="form-group">
			<input v-model="appdata._wpnonce" type="hidden" />
			<input class="form-control" :placeholder="placeholder" type="text" name="q" id="q" v-model="appdata.q" v-on:input="clearResults()" />
			<button :class="btnClass" type="submit" disabled v-if="appdata.q.length < 2">Search</button>  
			<button :class="btnClass" type="submit" @click="searchQuery" v-if="appdata.q.length > 1">Search</button>  
		</div>   
    </form>
	<hr v-if="isLoading==null">
	<div v-if="total_results>0" :class="showResults">
		<p v-html="resultsIntro()"></p>
		<ul v-for="(item,key) in data" :key="key">
			<li class="lang">{{language(item.meta.lang)}}</li>
			<li class="fl" >{{item.fl}}</li>
			<li class="shortdef"><Shortdef v-bind:item="item"></Shortdef></li>
		</ul>
	</div>
	<ul v-if="showSuggs===true" :suggestions="suggestions" :class="showResults">
		<li><p v-html="noResults()"></p></li>
		<ul>
			<li v-for="(item,key) in suggestions" :key="key"><a href="#" @click="suggestion(item)">{{item}}</a></li>
		</ul>
	</ul>
		<!-- AJAX Spinner -->
		<div :id="loadingId" :class="isLoading" @click="clearLoading()">
	    	<div class="status">	
				<div class="lds-spinner">
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
	    </div>
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
			placeholder: this.$appdata.placeholder,
            loadingClass: this.$appdata.loadingClass,
            noResultsMsg: this.$appdata.noResultsMsg,
            resultsMsg: this.$appdata.resultsMsg,
            resultsMsgTxt: "",
            btnClass: "btn btn-primary",
			appdata: this.$appdata,
			data: [],
			suggestions: [],
			total_results: 0,
			item: {},
			showSuggs: false,
			showResults: "hide"
        }
    },
    methods: {
	    clearLoading(){
			    return this.isLoading = ""   
	    },
	    clearResults() {
			this.showResults = "hide"
	    },
	    noResults() {
		    
			return this.noResultsMsg.replace('%s','<span class="search-query">' + this.appdata.q + '</span>')
		},
		resultsIntro() {
			
			if( this.resultsMsg == '') {
				return this.resultsMsg;
			} else {
			
			var html = this.resultsMsg.replace('%s','<span class="search-query">' + this.appdata.q + '</span>')
			return html = html.replace('%d','<span class="total-results">' + this.total_results + '</span>')
			}
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
				
					this.$appdata.q = this.appdata.q
					
					
					this.isLoading = "";
					
					this.showResults = "show"
					
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



#loading-status.loading{
	position: absolute;
	display: flex;
	justify-content: space-around;
	align-items: center;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background: rgba(0,0,0,.4);
	z-index: 9999;
}

#merrweb-api input + button {
	margin-left: .4em;
}

span.search-query {
	font-weight: bold;
}

#loading-status .status{
	display: none;
}

#loading-status.loading .status{

	display: inherit;
	
}

.hide {
	display: none;
}

.lds-spinner {
  color: official;
  display: inline-block;
  position: relative;
  width: 80px;
  height: 80px;
}
.lds-spinner div {
  transform-origin: 40px 40px;
  animation: lds-spinner 1.2s linear infinite;
}
.lds-spinner div:after {
  content: " ";
  display: block;
  position: absolute;
  top: 3px;
  left: 37px;
  width: 6px;
  height: 18px;
  border-radius: 20%;
  background: #fff;
}
.lds-spinner div:nth-child(1) {
  transform: rotate(0deg);
  animation-delay: -1.1s;
}
.lds-spinner div:nth-child(2) {
  transform: rotate(30deg);
  animation-delay: -1s;
}
.lds-spinner div:nth-child(3) {
  transform: rotate(60deg);
  animation-delay: -0.9s;
}
.lds-spinner div:nth-child(4) {
  transform: rotate(90deg);
  animation-delay: -0.8s;
}
.lds-spinner div:nth-child(5) {
  transform: rotate(120deg);
  animation-delay: -0.7s;
}
.lds-spinner div:nth-child(6) {
  transform: rotate(150deg);
  animation-delay: -0.6s;
}
.lds-spinner div:nth-child(7) {
  transform: rotate(180deg);
  animation-delay: -0.5s;
}
.lds-spinner div:nth-child(8) {
  transform: rotate(210deg);
  animation-delay: -0.4s;
}
.lds-spinner div:nth-child(9) {
  transform: rotate(240deg);
  animation-delay: -0.3s;
}
.lds-spinner div:nth-child(10) {
  transform: rotate(270deg);
  animation-delay: -0.2s;
}
.lds-spinner div:nth-child(11) {
  transform: rotate(300deg);
  animation-delay: -0.1s;
}
.lds-spinner div:nth-child(12) {
  transform: rotate(330deg);
  animation-delay: 0s;
}
@keyframes lds-spinner {
  0% {
    opacity: 1;
  }
  100% {
    opacity: 0;
  }
}

</style>
