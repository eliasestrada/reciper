<template>
	<div class="input-field">
		<input class="validate" :type="type" :name="nameAttr" :id="idAttr" :class="classAttr" autocomplete="off" required>
				<i class="material-icons noselect position-absolute visibility-icon" @click="changeType">
					{{ icon }}
				</i>
		<slot name="content"></slot>
	</div>
</template>

<script>
export default {
	data() {
		return {
			type: 'password',
			icon: 'visibility'
		}
	},

	props: {
		nameAttr: { default: '' },
		idAttr: { default: '' },
		classAttr: { default: '' }
	},
	 
	methods: {
		changeType() {
			if (this.type === 'password') {
				this.type = 'text'
				this.icon = 'visibility_off'
			} else {
				this.type = 'password'
				this.icon = 'visibility'
			}
		}
	}
}
</script>