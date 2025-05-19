<script setup>
import { useForm } from '@inertiajs/vue3';

defineProps({
	models: Array,
	processors: Array,
	graphic_cards: Array,
	memory_cards: Array,
	storages: Array,
	displays: Array
})

// LAPTOP -------
const laptop_form = useForm({
	name: null,
	price: null,
	release_date: null,
	site_link: null,
	image_link: null,
	model: null,
	processor: null,
	graphic_card: null,
	memory: null,
	storage: null,
	display: null
})

const submit_laptop = () => {
	laptop_form.post('/create_laptop', {
		onError: () => laptop_form.reset(),
	})
}

// HARDWARE -----
const hardware_form = useForm({
	name: null,
	type: null,
	score: null
})

const submit_hardware = () => {
	hardware_form.post('/create_hardware', {
		onError: () => hardware_form.reset(),
	})
}
</script>

<template>
	<div class="w-full h-full grid grid-cols-2">

		<form @submit.prevent="submit_laptop" class="place-self-center" id="laptop_container" >
			<input type="text" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" placeholder="Name" v-model="laptop_form.name">

			<input type="number" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" placeholder="Price" v-model="laptop_form.price">
			
			<input type="text" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" placeholder="Release date" v-model="laptop_form.release_date">

			<input type="text" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" placeholder="Site link" v-model="laptop_form.site_link">

			<input type="text" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" placeholder="Image link" v-model="laptop_form.image_link">


			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="laptop_form.model">
				<option v-for="model in models" :value="model.id">{{ model.name }}</option>
			</select>

			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="laptop_form.processor">
				<option v-for="processor in processors" :value="processor.id">{{ processor.name }}</option>
			</select>

			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="laptop_form.graphic_card">
				<option v-for="graphic_card in graphic_cards" :value="graphic_card.id">{{ graphic_card.name }}</option>
			</select>

			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="laptop_form.memory_card">
				<option v-for="memory_card in memory_cards" :value="memory_card.id">{{ memory_card.name }}</option>
			</select>

			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="laptop_form.storage">
				<option v-for="storage in storages" :value="storage.id">{{ storage.name }}</option>
			</select>

			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="laptop_form.display">
				<option v-for="display in displays" :value="display.id">{{ display.name }}</option>
			</select>

			<button class="btn w-4/5 bg-red-500 text-white h-[2.7em] my-5 rounded-sm">Create laptop</button>
		</form>

		<form @submit.prevent="submit_hardware" class="place-self-center mb-6" id="hardware_container">
			<input type="text" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" placeholder="Name" v-model="hardware_form.name">

			<select class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="hardware_form.type">
				<option value="1">Model</option>
				<option value="2">Processor</option>
				<option value="3">Graphics Card</option>
				<option value="4">Memory</option>
				<option value="5">Storage</option>
				<option value="6">Display</option>
			</select>

			<input type="text" class="h-[2.4em] w-4/5 px-2 rounded-sm box-border border-2 my-5" v-model="hardware_form.score" placeholder="Score">

			<button class="btn w-4/5 bg-red-500 text-white h-[2.7em] my-5 rounded-sm">Create hardware</button>
		</form>

	</div>
</template>