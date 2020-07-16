<template>
	<ul>
		<li v-for="(v,index) in item.shortdef" :key="index">{{v}}</li>
	</ul>
</template>
<script>
	export default {
		props: {
			item: {}
		}
	}
</script>