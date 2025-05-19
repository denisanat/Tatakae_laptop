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
	<div class="w-full place-items-center login-container">
		<Head title="Login"></Head>

		<h1 class="text-3xl my-5">Login to your account</h1>

		<div class="w-1/4 mx-auto">
			<form @submit.prevent="submit">
				<div class="mb-6">
					<label for="email">Email</label> <br>
					<input type="text" v-model="form.email" class="w-full h-[2.4em] px-2 rounded-sm box-border">
					<small>{{ form.errors.email }}</small>
				</div>

				<div class="mb-6">
					<label for="password">Password</label> <br>
					<input type="text" v-model="form.password" class="w-full h-[2.4em] px-2 rounded-sm box-border">
					<small>{{ form.errors.password }}</small>
				</div>

				<div class="flex items-center gap-2">
					<label for="remember">Remember me</label>
					<input type="checkbox" v-model="form.remember">
				</div>

				<div>
					<p class="text-slate-600">
						Don't have an account? 
						<a href="/register" class="text-link text-red-500">Create one</a>
					</p>
					<button class="btn w-full bg-red-500 text-white h-[2.7em] my-5 rounded-sm" :disabled="form.processing">Login</button>
				</div>
			</form>
		</div>
	</div>
</template>

<style>
input {
	border: 2px solid black;
}

.login-container {
	font-size: 1.2em;
}
</style>