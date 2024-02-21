<template>
	<span class="pitch-image-description" v-if="showImageDescription">
		<span class="description">{{ description }}</span>
		<div>
			<span class="img-description">
				<img :src="getImagePath" />
			</span>
		</div>
	</span>
</template>

<script>
	export default {
		props: ['enable', 'specCode', 'description'],
        computed: {
        	showImageDescription () {
        		if (this.enable != false && this.specCode == 'spec18') {
        			return true
        		}
        		return false
        	},

        	getImagePath () {
        		return `/tostem/img/data/${this.enable}`
        	}
        },
	}
</script>

<style lang="scss">
	.pitch-image-description {
		position: relative;
	    display: inline;
	    min-height: 16rem;
	    padding-left: 3rem;

	    .description {
	    	font-size: 1.2rem;
	    	display: block;
	    }

	    @media(max-width: 677px) {
	    	padding: 5px;
	    }

	    >div {
	    	position: absolute;
	    	left: 3rem;
	    	bottom: -10px;
	    	display: inline-block;

	    	@media(max-width: 677px) {
	    		position: initial;
	    		display: block;
	    	}

		    .img-description {
		    	display: inline-block;
			    text-align: center;
			    box-sizing: border-box;

			    img {
			    	width: 11rem;
			    }
		    }
	    }
	}
</style>