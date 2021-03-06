<template>
	<transition name="fade">
		<div class="b-modal b-is-active" v-show="show">
			<div class="b-modal-background"></div>

			<div class="b-modal-card" :style="'width: ' + width + 'px;'" v-loading="loading" ref="modalBody">
				<header class="b-modal-card-head" v-if="options.header">
					<h2 class="b-modal-card-title">
						{{ title }}

						<span class="b-modal-card-subtitle">
							{{ subtitle }}
						</span>
					</h2>
			
					<button class="b-modal-close" @click="$emit('close')"></button>
				</header>

				<section class="b-modal-card-body" ref="modalCardBody">
					<slot name="content"></slot>
				</section>
				
				<footer class="b-modal-card-foot" v-if="options.footer">
					<slot name="footer"></slot>
				</footer>
			</div>
		</div>
	</transition>
</template>

<script>
	export default {
        props: {
        	//if set to 'true' trigger a loading animation covering the whole modal
        	loading: {
				type: Boolean,
				required: false,
				default: false
			},

			show: {
				type: Boolean,
				required: true
			},

			options: {
				type: Object,
				default: function() {
					return {
						header: true,
						footer: true
					}
				}
			},

			width: {
				type: Number,
				default: 900
			},

			title: {
				type: String,
				default: ''
			},

			subtitle: {
				type: String,
				default: ''
			}
		},

		watch: {
			//close if open and vise versa
			show(status) {
				(status == true) ? this.open() : this.close()
			}
		},

		methods: {
			open() {
				this.show = true

				//hide body scrollbar and apply padding to avoid page "jumping"
                document.documentElement.style.overflowY = 'hidden'
                document.documentElement.style.paddingRight = '17px'
			},

			close() {
				this.show = false

				//show body scrollbar
                document.documentElement.removeAttribute('style')
			}
		},

		/**
		 * Incase the whole component is destroyed.
		 */
		destroyed() {
			//show body scrollbar
            document.documentElement.removeAttribute('style')
		}
    }
</script>

<style scoped>
	.b-modal-background {
		bottom: 0;
		left: 0;
		position: absolute;
		right: 0;
		top: 0;
		background-color: rgba(10, 10, 10, 0.6);
		z-index: 900;
	}

	.b-modal-content,
	.b-modal-card {
		margin: 0;
		max-height: calc(100vh - 20px);
		height: 100%;
		overflow: auto;
		position: relative;
		width: 100%;
		z-index: 950;
		background: #fff;
	}

	@media screen and (min-width: 769px), print {
		.b-modal-content,
		.b-modal-card {
			margin: 10px auto;
			max-height: calc(100vh - 20px);
			width: 500px;
		}
	}

	@media screen and (max-width: 768px), print {
		.b-modal-content,
		.b-modal-card {
			width: 94%;
		}
	}

	.b-modal-close {
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		-moz-appearance: none;
		-webkit-appearance: none;
		background-color: rgba(10, 10, 10, 0.2);
		border: none;
		border-radius: 290486px;
		cursor: pointer;
		display: inline-block;
		-webkit-box-flex: 0;
		-ms-flex-positive: 0;
		flex-grow: 0;
		-ms-flex-negative: 0;
		flex-shrink: 0;
		font-size: 1rem;
		height: 30px;
		max-height: 30px;
		max-width: 30px;
		min-height: 30px;
		min-width: 30px;
		outline: none;
		position: relative;
		vertical-align: top;
		width: 30px;
	}

	.b-modal-close:before, .b-modal-close:after {
		background-color: white;
		content: "";
		display: block;
		left: 50%;
		position: absolute;
		top: 50%;
		transform: translateX(-50%) translateY(-50%) rotate(45deg);
		transform-origin: center center;
	}

	.b-modal-close:before {
		height: 2px;
		width: 50%;
	}

	.b-modal-close:after {
		height: 50%;
		width: 2px;
	}

	.b-modal-close:hover, .b-modal-close:focus {
		background-color: rgba(10, 10, 10, 0.3);
	}

	.b-modal-close:active {
		background-color: rgba(10, 10, 10, 0.4);
	}

	.b-modal-card {
		display: flex;
		flex-direction: column;
		max-height: calc(100vh - 20px);
		overflow: hidden;
	}

	.b-modal-card-head {
		align-items: center;
		background-color: whitesmoke;
		display: flex;
		flex-shrink: 0;
		justify-content: flex-start;
		padding: 10px 20px 0 20px;
		position: relative;
	}

	.b-modal-card-head {
		border-bottom: 1px solid #dbdbdb;
		border-top-left-radius: 2px;
		border-top-right-radius: 2px;
	}

	.b-modal-card-title {
		color: #363636;
		flex-grow: 1;
		flex-shrink: 0;
		font-size: 1.3rem;
		line-height: 1;
	}

	.b-modal-card-subtitle {
		color: #bbb;
		font-size: 80%;
	}

	.b-modal-card-foot {
		padding: 10px 20px 10px 20px;
		position: relative;
		background-color: whitesmoke;
		border-bottom-left-radius: 2px;
		border-bottom-right-radius: 2px;
		border-top: 1px solid #dbdbdb;
		/*justify-content: flex-end;*/
	}

	.b-modal-card-foot .button:not(:last-child) {
		margin-right: 10px;
	}

	.b-modal-card-body {
		-webkit-overflow-scrolling: touch;
		background-color: white;
		flex-grow: 1;
		flex-shrink: 1;
		overflow: auto;
	}

	.b-modal {
		bottom: 0;
		left: 0;
		right: 0;
		top: 0;
		align-items: center;
		display: none;
		justify-content: center;
		overflow: hidden;
		position: fixed !important;
		z-index: 1000;
	}

	.b-modal.b-is-active {
		display: flex;
	}
</style>