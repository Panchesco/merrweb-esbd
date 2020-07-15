<template>
	<ul>
		<li v-for="(v,key) in item.shortdef" :key="key">{{v}}</li>
	</ul>
</template>
<script>
	export default {
		props: {
			item: {}
		}
	}
</script>