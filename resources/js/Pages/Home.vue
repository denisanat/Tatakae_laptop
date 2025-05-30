<script setup>
import { ref, watch, reactive } from "vue";
import { Link, router } from "@inertiajs/vue3"
import { debounce } from "lodash";

const props = defineProps({
	page: Object,
	searchTerm: String,
	models: Array,
	processors: Array,
	graphics_cards: Array,
	memory_cards: Array,
	storages: Array,
	displays: Array,

	filters: Object,
});

const filters = reactive({
    model: props.filters.model || '',
    processor: props.filters.processor || '',
    graphics_card: props.filters.graphics_card || '',
	memory: props.filters.memory || '',
	storage: props.filters.storage || '',
	display: props.filters.display || '',
	power_supply: props.filters.power_supply || '',
	sort: props.filters.sort || '',
});

watch(
	filters,
	debounce((newFilters) => {
		const cleanedFilters = {};

        Object.keys(newFilters).forEach( key => {
            if (newFilters[key])
                cleanedFilters[key] = newFilters[key];
        });

		router.get('/', cleanedFilters, { preserveState: true })

	}, 500),
	{ deep: true }
);

// Changes the string of "previous page" and "next page"
const getPaginationLabel = (label) => {
	if ( label.includes('Previous') )
		return "<<";

	else if ( label.includes('Next') )
		return ">>";

	else
		return label;
}
</script>



<template>
	
	<section class="mb-4 p-2 flex flex-wrap bg-white" id="filters_box">

		<!-- SELECTS -->
		<input type="search" placeholder="Search" v-model="filters.search" class="select_not_selected">


		<!-- Model -->
		<select	v-if="filters.model" v-model="filters.model" class="select_selected" >
			<option value="">Model</option>
			<option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
		</select>

		<select	v-else v-model="filters.model" class="select_not_selected" >
			<option value="">Model</option>
			<option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
		</select>


		<!-- Processors -->
		<select v-if="filters.processor" v-model="filters.processor" class="select_selected">
			<option value="">Processors</option>
			<option v-for="processor in processors" :value="processor.id">{{ processor.name }}</option>
		</select>

		<select v-else v-model="filters.processor" class="select_not_selected">
			<option value="">Processors</option>
			<option v-for="processor in processors" :value="processor.id">{{ processor.name }}</option>
		</select>


		<!-- Graphic cards -->
		<select v-if="filters.graphics_card" v-model="filters.graphics_card" class="select_selected">
			<option value="">Graphics cards</option>
			<option v-for="card in graphics_cards" :value="card.id">{{ card.name }}</option>
		</select>

		<select v-else v-model="filters.graphics_card" class="select_not_selected">
			<option value="">Graphic cards</option>
			<option v-for="card in graphics_cards" :value="card.id">{{ card.name }}</option>
		</select>


		<!-- Memory cards -->
		<select v-if="filters.memory" v-model="filters.memory" class="select_selected">
			<option value="">Memory cards</option>
			<option v-for="memory in memory_cards" :value="memory.id">{{ memory.name }}</option>
		</select>

		<select v-else v-model="filters.memory" class="select_not_selected">
			<option value="">Memory cards</option>
			<option v-for="memory in memory_cards" :value="memory.id">{{ memory.name }}</option>
		</select>


		<!-- Storages -->
		<select v-if="filters.storage" v-model="filters.storage" class="select_selected">
			<option value="">Storages</option>
			<option v-for="storage in storages" :value="storage.id">{{ storage.name }}</option>
		</select>

		<select v-else v-model="filters.storage" class="select_not_selected">
			<option value="">Storages</option>
			<option v-for="storage in storages" :value="storage.id">{{ storage.name }}</option>
		</select>


		<!-- Display -->
		<select v-if="filters.display" v-model="filters.display" class="select_selected">
			<option value="">Screen</option>
			<option v-for="display in displays" :value="display.id">{{ display.name }}</option>
		</select>

		<select v-else v-model="filters.display" class="select_not_selected">
			<option value="">Screen</option>
			<option v-for="display in displays" :value="display.id">{{ display.name }}</option>
		</select>


		<!-- Sort -->
		<select v-if="filters.sort" v-model="filters.sort" class="select_selected">
			<option value="">Sort</option>
			<option value="10">Score</option>
			<option value="11">User Score</option>
			<option value="12">Price</option>
			<option value="1">Processor</option>
			<option value="2">Graphics Card</option>
			<option value="3">Memory</option>
			<option value="4">Storage</option>
			<option value="5">Display</option>
		</select>

		<select v-else v-model="filters.sort" class="select_not_selected">
			<option value="">Sort</option>
			<option value="10">Score</option>
			<option value="11">User Score</option>
			<option value="12">Price</option>
			<option value="1">Processor</option>
			<option value="2">Graphics Card</option>
			<option value="3">Memory</option>
			<option value="4">Storage</option>
			<option value="5">Display</option>
		</select>

	</section>

	

	<section class="p-5 bg-white">

		<!-- Pagination links -->
		<div class="flex justify-between">
			<p>{{ page.total }} results</p>
			
			<div>
				<template v-for="link in page.links" :key="link.label">
					<Link 
						v-if="link.url" 
						v-html="getPaginationLabel(link.label)"
						:href="link.url"
						class="p-1 mx-1 select-none"
						:class="{ 'text-red-500': link.active }"
					/>
					<span
						v-else
						v-html="getPaginationLabel(link.label)"
						class="p-1 mx-1 text-gray-400 select-none"
					/>
				</template>
			</div>
		</div>

		<ul class="grid grid-cols-2 md:grid-cols-6 gap-x-4 gap-y-2 my-5 place-items-center">
			<li 
				v-for="laptop in page.data" 
				:key="laptop.id" 
				class="w-full flex justify-center my-5"
			>
				<Link 
					:href="`/laptop/${laptop.id}`"
					class="aspect-square w-[70%] flex items-center justify-center flex-col relative"
				>
					<p class="absolute top-2 left-2 bg-white bg-opacity-80 px-2 py-1 text-xl rounded z-10 orbiton-font text-black">{{ laptop.page_score }}</p>
					<p class="absolute top-2 right-2 bg-white bg-opacity-10 px-2 py-1 text-xl rounded z-10 orbiton-font text-red-500">{{ laptop.user_score }}</p>
					<img 
						:src="laptop.image_link" 
						:alt="`${laptop.name} image`" 
						class=""
					/>
					<p>{{ `${laptop.name} ` }}
					<span class="bg-red-500 text-white inter-font-bold p-1">{{ `${laptop.price}€` }}</span></p>
				</Link>
			</li>
		</ul>
	</section>

	

</template>



<style lang="css">

#filters_box * {
	width: 20em;
	min-width: 8em;
	height: 3em;
	margin: 5px 20px;
	padding: 0px 10px;
}

option {
	background-color: white;
	color: black;
}

.select_not_selected {
	border: 2px solid black;
	background-color: white;
}

.select_selected {
	background-color: #fb2c36;
	color: white;

	font-family: "Inter", sans-serif;
  	font-optical-sizing: auto;
  	font-weight: 700;
  	font-style: normal;
}
</style>