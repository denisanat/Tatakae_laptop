<template>
	<div class="h-dvh">

		<header class="flex items-center justify-between bg-red-500 orbiton-font h-1/10 px-6 w-screen box-border">
			<span class="text-white text-5xl">Tatakae Laptop</span>

			<div>
				<nav class="text-4xl flex">
					<div class="mx-3">
						<Link 
						href="/"
						:class="{ 'text-white': $page.component === 'Home' }"
						class="inter-font-bold"
						>Home</Link>
					</div>

					<div v-if="$page.props.auth.user" >
						<Link href="/logout" 
						method="post" 
						as="button" 
						type="button"
						class="inter-font-bold mx-3"
						>Logout</Link>
					</div>

					<div v-else>
						<Link 
						href="/register"
						:class="{ 'text-white': $page.component === 'Register' }"
						class="inter-font-bold mx-3"
						>Register</Link>

						<Link 
						href="/login"
						:class="{ 'text-white': $page.component === 'Login' }"
						class="inter-font-bold mx-3"
						>Login</Link>
					</div>
				</nav>
			</div>
			
		</header>

		<main class="h-9/10 box-border">
			<slot />
		</main>

	</div>
</template>

<style>
.orbiton-font {
	font-family: "Orbitron", sans-serif;
  	font-optical-sizing: auto;
  	font-weight: 500;
  	font-style: normal;
}

.inter-font, div {
  	font-family: "Inter", sans-serif;
  	font-optical-sizing: auto;
  	font-weight: 400;
  	font-style: normal;
}

.inter-font-bold {
  	font-family: "Inter", sans-serif;
  	font-optical-sizing: auto;
  	font-weight: 700;
  	font-style: normal;
}
</style>