<template>
	<div>
		<nav class="main">
	        <h1 class="trip__title">Elvecruise på Douro</h1>
	    </nav>

		<main>
			<sign-up-form></sign-up-form>
		</main>
	</div>
</template>

<script>
	import SignUpForm from '../components/SignUpForm'

	export default {
		components: {
			'sign-up-form': SignUpForm
		}
	}
</script>

<style scoped>
	nav.main {
		/*border-bottom: 1px solid #ddd;*/
		background: #4A5263;
		padding: 10px 20px;
		display: flex;
		align-items: center;
		/*height: ;*/
	}

	.trip__title {
		flex: 1;
		margin: 10px;
		color: #fff;
	}

	main {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 70vh;
	}
</style>