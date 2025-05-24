<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
	laptop: Object,
	recomended: Array,
	userScore: Number,
	messages: Array
});

const score = ref(props.userScore || 1);
const comment = ref('');
const reply = ref('');

const replyingToId = ref(null);

const showReplyBox = (id) => {
	replyingToId.value = id;
	comment.value = '';
	reply.value = '';
}

const submitScore = () => { 
	router.post(`/laptop/${props.laptop.id}/rate`, 
		{ score: score.value }, 
		{ preserveScroll: true }) 
};

const submitComment = () => { 
	router.post(`/laptop/${props.laptop.id}/comment`, { 
		comment: comment.value,
		isResponse: false 
	}, { preserveScroll: true }) 
};

const submitReply = () => {
	router.post(`/laptop/${replyingToId.value}/reply`, { 
		comment: reply.value,
		isResponse: false 
	}, { preserveScroll: true }) 
}

</script>



<template>
	<div class="grid grid-cols-5 gap-5">
		<section class="col-span-2 p-5 flex flex-col items-center bg-white">
			<h1 class="text-3xl">{{ laptop.name }}</h1>
			<img 
				:src="laptop.image_link" 
				:alt="`${laptop.name} image`" 
				class="w-3/5"
			/>
			<div class="w-[100%]">
			<p class="inter-font-bold text-2xl"><span class="text-red-500">Score: </span>{{ laptop.page_score }}</p>
			<div class="flex justify-between">
				<p class="inter-font-bold text-2xl"><span class="text-red-500">Users score: </span>{{ laptop.user_score }}</p>

				<form @submit.prevent="submitScore">
					<select v-model="score">
						<option value="1">1 ⭐</option>
						<option value="2">2 ⭐</option>
						<option value="3">3 ⭐</option>
						<option value="4">4 ⭐</option>
						<option value="5">5 ⭐</option>
					</select>
					<button type="submit" class="clickable_button">Submit Score</button>
				</form>
			</div>
			<p class="inter-font-bold text-2xl inter-font">{{ laptop.site_link }}</p>
			</div>
		</section>

		<section id="specs_div" class="col-span-3 p-5 flex flex-col gap-3 inter-font-bold text-2xl bg-white">
			<p><span class="text-red-500">Price: </span>{{ laptop.price }}€</p>
			<p><span class="text-red-500">Model: </span>{{ laptop.model }}</p>
			<p><span class="text-red-500">Processor: </span>{{ laptop.processor }}</p>
			<p><span class="text-red-500">Graphics Card: </span>{{ laptop.graphics_card }}</p>
			<p><span class="text-red-500">Memory: </span>{{ laptop.memory }}</p>
			<p><span class="text-red-500">Storage: </span>{{ laptop.storage }}</p>
			<p><span class="text-red-500">Display: </span>{{ laptop.display }}</p>
		</section>
	</div>

	<div class="grid grid-cols-5 gap-5 mt-5">

		<section id="comment_section" class="p-5 col-span-4 bg-white">
			<h2 class="text-3xl">Comments</h2>

			<form @submit.prevent="submitComment" class="mt-4">
				<input 
					type="text" 
					v-model="comment" 
					class="w-1/2 h-[2.4em] px-2 rounded-sm box-border" 
					placeholder="Comment something about this laptop"
				>
				<button class="primary-btn clickable_button">Submit</button>
			</form>

			<div>
				<ul v-for="message in messages" :key="message.id" class="my-10">
					<li class="">
						<p>{{ message.user_id }}</p>
						<p class="text-gray-600">{{ message.message }}</p>
					</li>
					<button @click="showReplyBox(message.id)" class="clickable_button">Reply</button>
					<button @click="showAnswers(message.id)" class="clickable_button">Show replies</button>
					

					<!-- Reply Box -->
					<div v-if="replyingToId === message.id">
						<input type="text" v-model="reply" placeholder="Your answer...">
						<button @click="submitReply" class="clickable_button">Submit</button>
					</div>
				</ul>
			</div>
		</section>

		<section class="bg-white p-5">
			<h2 class="text-3xl">Related</h2>

			<ul class="flex flex-wrap flex-col my-4 justify-around">
				<li 
					v-for="laptop in recomended" 
					:key="laptop.id" 
					class="flex justify-center"
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
	</div>

</template>

<style>
.clickable_button {
	background-color: #fb2c36;
	color: white;
	margin: 4px;
	padding: 4px;
	border-radius: 2px;
	box-sizing: border-box;

	font-family: "Inter", sans-serif;
  	font-optical-sizing: auto;
  	font-weight: 700;
  	font-style: normal;
}
</style>