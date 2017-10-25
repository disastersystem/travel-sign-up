<template>
	<nav class="main">
        <h1 class="trip__title">Elvecruise på Douro</h1>
        
        <sign-up-form></sign-up-form>
    </nav>
</template>

<script>
	import SignUpForm from '../components/SignUpForm'

	export default {
		components: {
			'sign-up-form': SignUpForm
		}
	}
</script>