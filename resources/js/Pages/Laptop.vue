<script setup>
defineProps({
	laptop: Object,
})
</script>



<template>
	<div>
		<h1>{{ laptop.name }}</h1>
		<p>{{ laptop.price }}</p>
		<p>{{ laptop.model }}</p>
	</div>
</template>