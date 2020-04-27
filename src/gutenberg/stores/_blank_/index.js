const { apiFetch } = wp
const { registerStore } = wp.data

const DEFAULT_STATE = {
	blankdata: null,
}

const actions = {
	/** fetchs *******/
	fetch_blankdata (path) {
		return {
			type: 'FETCH_BLANKDATA',
			path,
		}
	},
	/** sets *******/
	set_blankdata (blankdata) {
		return {
			type: 'SET_BLANKDATA',
			blankdata,
		}
	}
}

registerStore('wkg/_blank_', {
	/***********************************************
	 * Private Store's Setters
	 */
	reducer ( state = DEFAULT_STATE, action ) {
		switch ( action.type ) {
			case 'SET_BLANKDATA':
				return {
					...state,
					blankdata: action.blankdata,
				}
		}
		return state
	},
	/**
	 * Private Store's action control
	 */
	controls: {
		FETCH_BLANKDATA (action) {
			return apiFetch({ path: action.path })
		},
	},
	/**
	 * Private Store's Getters
	 * Played when selector is called, just before
	 */
	resolvers: {
		* get_blankdata () {
			const blankdata = yield actions.fetch_blankdata('/wkg/v1/rest-api-slug/blankdata/')
			return actions.set_blankdata(blankdata)
		},
	},
	/***********************************************
	 * Public Store's Setters
	 */
	actions,
	/**
	 * Public Store's Getters
	 */
	selectors: {
		get_blankdata(state) {
			return state.blankdata
		},
	},
})
