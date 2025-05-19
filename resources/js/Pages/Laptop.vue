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

const submitScore = () => { router.post(`/laptop/${props.laptop.id}/rate`, { score: score.value }, { preserveScroll: true }) };

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
	<div>
		<h1>{{ laptop.name }}</h1>
		<p>{{ laptop }}</p>
		<p>{{ laptop.model }}</p>
	</div>

	<form @submit.prevent="submitScore">
		<select v-model="score">
			<option value="1">1 ⭐</option>
			<option value="2">2 ⭐</option>
			<option value="3">3 ⭐</option>
			<option value="4">4 ⭐</option>
			<option value="5">5 ⭐</option>
		</select>
		<button type="submit">Enviar</button>
	</form>

	<form @submit.prevent="submitComment">
		<input type="text" v-model="comment">
		<button class="primary-btn">Submit</button>
	</form>

	<div>
		<ul v-for="message in messages" :key="message.id">
			<li>{{ message.message }}</li>
			<button @click="showReplyBox(message.id)">Reply</button>
			<button @click="showAnswers(message.id)">Show replies</button>

			<!-- Reply Box -->
			<div v-if="replyingToId === message.id">
				<input type="text" v-model="reply" placeholder="Your answer...">
				<button @click="submitReply">Submit</button>
			</div>
		</ul>
	</div>
</template>