<template>
	<div>
		<nav class="main">
	        <h1 class="trip__title">{{ shared.tripData.title }}</h1>
	        
	        <enrolment-form v-if="isEmpty == false"></enrolment-form>
	    </nav>

		<main>
			<section
				v-html="shared.tripData.description"
				class="description"
			></section>
		</main>
	</div>
</template>

<script>
	//shared object, among components that import this file and 
	//place shared prop in they vue instance data object
	import store from '../store'

	import data from '../data'
	import EnrolmentForm from '../components/EnrolmentForm'

	export default {
		data() {
			return {
				shared: store
			}
		},

		components: {
			'enrolment-form': EnrolmentForm
		},

		computed: {
			//used together with the v-if directive to prevent rendering 
			//sub components before trip data has been loaded
			isEmpty() {
				return _.isEmpty(this.shared.tripData)
			}
		},

		/**
		 * Get the trip data from the database. Also calculate some
		 * additional properties.
		 */
		mounted() {
			//set data from database
            this.shared.tripData = data

            //calculate and set initial prices now that activites has been loaded from the database
            this.shared.tripData.activities.forEach(function(activity) {
                Vue.set(activity, 'priceAfterDiscount', activity.price - (activity.discountChildren * activity.price / 100))
                Vue.set(activity, 'amountAdults', 0)
                Vue.set(activity, 'amountChildren', 0)
            })
		}
	}
</script>

<style scoped>
	nav.main {
		background: #4A5263;
		padding: 10px 20px;
		display: flex;
		align-items: center;
		justify-content: space-between;
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
		/*height: 70vh;*/
	}

	.description {
		padding: 40px;
		width: 500px;
		color: #fff;
		font-family: 'Roboto';
		font-weight: 300;
		font-size: 15px;
		line-height: 1.4em;
	}
</style>