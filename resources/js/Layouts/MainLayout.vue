<template>
	<div class="p-8">

		<header class="flex items-center">
			<span class="text-red-500 text-4xl">Tatakae Laptop</span>

			<div>
				<nav class="text-2xl flex">
					<div>
						<Link 
						href="/"
						:class="{ 'text-red-500': $page.component === 'Home' }"
						>Home</Link>
					</div>

					<div v-if="$page.props.auth.user">
						<Link href="/logout" 
						method="post" 
						as="button" 
						type="button"
						>Logout</Link>
					</div>

					<div v-else>
						<Link 
						href="/register"
						:class="{ 'text-red-500': $page.component === 'Register' }"
						>Register</Link>

						<Link 
						href="/login"
						:class="{ 'text-red-500': $page.component === 'Login' }"
						>Login</Link>
					</div>
				</nav>
			</div>
			
		</header>

		<main>
			<slot />
		</main>

	</div>
</template>