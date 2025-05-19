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
	<div class="w-full place-items-center login-container">
		<Head title="Register"></Head>

		<h1 class="text-3xl my-5">Create account</h1>

		<div class="w-1/4 mx-auto">
			<form @submit.prevent="submit">
				<div class="mb-6">
					<label for="name">Name</label>	<br>
					<input type="text" v-model="form.name" class="w-full h-[2.4em] px-2 rounded-sm box-border">
					<small>{{ form.errors.name }}</small>
				</div>

				<div class="mb-6">
					<label for="email">Email</label>	<br>
					<input type="text" v-model="form.email" class="w-full h-[2.4em] px-2 rounded-sm box-border">
					<small>{{ form.errors.email }}</small>
				</div>

				<div class="mb-6">
					<label for="password">Password</label>	<br>
					<input type="text" v-model="form.password" class="w-full h-[2.4em] px-2 rounded-sm box-border">
					<small>{{ form.errors.password }}</small>
				</div>

				<div class="mb-6">
					<label for="password_confirmation">Confirm password</label>	<br>
					<input type="text" v-model="form.password_confirmation" class="w-full h-[2.4em] px-2 rounded-sm box-border">
				</div>

				<div>
					<p class="text-slate-600">Alredy a user? <a href="/login" class="text-link text-red-500">Login</a></p>
					<button class="btn w-full bg-red-500 text-white h-[2.7em] my-5 rounded-sm" :disabled="form.processing">Register</button>
				</div>
			</form>
		</div>
	</div>
</template>