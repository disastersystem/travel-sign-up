<template>
	<div>
		<nav class="main">
	        <h1 class="trip__title">Elvecruise på Douro</h1>
	    </nav>

		<main>
			<enrolment-form></enrolment-form>
		</main>
	</div>
</template>

<script>
	var Trip = {}

	import EnrolmentForm from '../components/EnrolmentForm'

	export default {
		data() {
			return {
				shared: Trip
			}
		},

		components: {
			'enrolment-form': EnrolmentForm
		},

		mounted() {
			//
		}
	}
</script>

<style scoped>
	nav.main {
		background: #4A5263;
		padding: 10px 20px;
		display: flex;
		align-items: center;
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