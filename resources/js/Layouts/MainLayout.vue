<template>
	<div class="w-vw flex flex-col">

		<header class="h-[100px] px-6 bg-red-500 orbiton-font flex items-center justify-between">
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

		<main class="m-5">
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

body {
  /* background: linear-gradient(to bottom, #ffffff, #f1f1f1); */
  background-color: #f9f9f9;
}

section {
  box-shadow: 0 1px 5px rgba(0,0,0,0.05);
  border-radius: 8px;
}

</style>