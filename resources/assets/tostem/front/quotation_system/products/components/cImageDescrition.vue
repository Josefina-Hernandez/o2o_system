<template>
	<span :class="['image-description', title]" v-if="showImageDescription">
		<span class="description" v-if="description">{{ description }}</span>
		<div>
			<span class="img-description">
				<img :src="image" />
			</span>
		</div>
	</span>
</template>

<script>
	export default {
		props: ['config', 'specCode'],
		data () {
			return {
				description: null,
				image: null,
				title: null
			}
		},
        computed: {
        	showImageDescription () {

        		let result = false

        		_.each(this.config, value => {
        			if (_.includes(value.spec, this.specCode)) {
        				result = true
        				this.image = `/tostem/img/data/${value.image}`
        				this.title = value.title
        				this.description = value.description
        				return false
        			}
        		})
        		return result
        	},
        },
	}
</script>

<style lang="scss">
	.pitch_list {
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

		    span {
		    	display: inline-block;
			    text-align: center;
			    box-sizing: border-box;

			    img {
			    	width: 11rem;
			    }
		    }
	    }
	}

	.image-description img {
		width: 21rem;
	}
</style>