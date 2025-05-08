<script setup>
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

defineProps({
	errors: Object
})

const form = useForm({
	email: null,
	password: null,
	remember: null,
})

const submit = () => {
	form.post('/login', {
		onError: () => form.reset('password'),
	});
}
</script>



<template>
	<Head title="Login"></Head>

	<h1 class="title">Login to you account</h1>

	<div>
		<form @submit.prevent="submit">
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

			<div>
				<label for="remember">Remember me</label>
				<input type="checkbox" v-model="form.remember">
			</div>

			<div>
				<p>Dont have an account? <a href="/register" class="text-link">Register</a></p>
				<button class="primary-btn" :disabled="form.processing">Login</button>
			</div>
		</form>
	</div>
</template>