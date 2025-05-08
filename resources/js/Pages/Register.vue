<script setup>
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

defineProps({
	errors: Object
})

const form = useForm({
	name: null,
	email: null,
	password: null,
	password_confirmation: null,
})

const submit = () => {
	form.post('/register', {
		onError: () => form.reset('password', 'password_confirmation'),
	});
}
</script>



<template>
	<Head title="Register"></Head>

	<h1 class="title">Register yourself</h1>

	<div>
		<form @submit.prevent="submit">
			<div class="mb-6">
				<label for="name">Name</label>	
				<input type="text" v-model="form.name">
				<small>{{ form.errors.name }}</small>
			</div>

			<div class="mb-6">
				<label for="email">Email</label>	
				<input type="text" v-model="form.email">
				<small>{{ form.errors.email }}</small>
			</div>

			<div class="mb-6">
				<label for="password">Password</label>	
				<input type="text" v-model="form.password">
				<small>{{ form.errors.password }}</small>
			</div>

			<div class="mb-6">
				<label for="password_confirmation">Confirm password</label>	
				<input type="text" v-model="form.password_confirmation">
			</div>

			<div>
				<p>Alredy a user? <a href="/login" class="text-link">Login</a></p>
				<button class="primary-btn" :disabled="form.processing">Register</button>
			</div>
		</form>
	</div>
</template>