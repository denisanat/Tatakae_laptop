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
	
	<div class="flex mb-4">

		<!-- Selects-->
		<input type="search" placeholder="Search" v-model="filters.search" class="filters_selects">

		<!-- Models -->
		<select v-model="filters.model" class="filters_selects" placeholder="texto de ejemplo">
			<option value=""></option>
			<option v-for="model in models" :key="model.id" :value="model.id">{{ model.name }}</option>
		</select>

		<!-- Processors -->
		<select v-model="filters.processor" class="filters_selects">
			<option value=""></option>
			<option v-for="processor in processors" :value="processor.id">{{ processor.name }}</option>
		</select>

		<!-- Graphics cards -->
		<select v-model="filters.graphics_card" class="filters_selects">
			<option value=""></option>
			<option v-for="card in graphics_cards" :value="card.id">{{ card.name }}</option>
		</select>

		<!-- Memory cards -->
		<!-- <select v-model="filters.memory" class="filters_selects">
			<option value=""></option>
			<option v-for="memory in memories" :value="memory.id">{{ memory.name }}</option>
		</select> -->

		<!-- Storage cards -->
		<!-- <select v-model="filters.storage" class="filters_selects">
			<option value=""></option>
			<option v-for="storage in storages" :value="storage.id">{{ storage.name }}</option>
		</select> -->

		<!-- Display -->
		<!-- <select v-model="filters.display" class="filters_selects">
			<option value=""></option>
			<option v-for="display in displays" :value="display.id">{{ display.name }}</option>
		</select> -->

		<!-- Power Supply -->
		<!-- <select v-model="filters.power_supply" class="filters_selects">
			<option value=""></option>
			<option v-for="power_supply in power_supplies" :value="power_supply.id">{{ power_supply.name }}</option>
		</select> -->

		<input type="range" min="1" max="10">

	</div>

	<ul>
		<li v-for="laptop in page.data" :key="laptop.id">
			<Link :href="`/laptop/${laptop.id}`">
				{{ laptop.name }}
			</Link>
		</li>
	</ul>

	<!-- Pagination links -->
	<div>
		<template v-for="link in page.links" :key="link.label">
			<Link 
				v-if="link.url" 
				v-html="getPaginationLabel(link.label)"
				:href="link.url"
				class="p-1 mx-1"
				:class="{ 'text-red-500': link.active }"
			/>
			<span
				v-else
				v-html="getPaginationLabel(link.label)"
				class="p-1 mx-1 text-gray-400"
			/>
		</template>

		<p>{{ page.total }} results</p>
	</div>

</template>



<style lang="css">

.filters_selects {
	border: 1px solid black;
	border-radius: 3px;
	margin: 3px;
	width: 200px;
}
</style>