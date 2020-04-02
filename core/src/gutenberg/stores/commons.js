if (window.wp !== undefined) {

	const { apiFetch } = wp
	const { registerStore } = wp.data

	const DEFAULT_STATE = {
		posts_options: null,
		terms_options: null,
		cf7_options: null,
		icons: null
	}

	const actions = {
		/** fetchs *******/
		fetchPostsOptions (path) {
			return {
				type: 'FETCH_POSTS_OPTIONS',
				path,
			}
		},
		fetchTermsOptions (path) {
			return {
				type: 'FETCH_TERMS_OPTIONS',
				path,
			}
		},
		fetchCf7Options (path) {
			return {
				type: 'FETCH_CF7_OPTIONS',
				path,
			}
		},
		fetchIcons (path) {
			return {
				type: 'FETCH_ICONS',
				path,
			}
		},
		/** sets *******/
		setPostsOptions (posts_options) {
			return {
				type: 'SET_POSTS_OPTIONS',
				posts_options,
			}
		},
		setTermsOptions (terms_options) {
			return {
				type: 'SET_TERMS_OPTIONS',
				terms_options,
			}
		},
		setCf7Options (cf7_options) {
			return {
				type: 'SET_CF7_OPTIONS',
				cf7_options,
			}
		},
		setIcons (icons) {
			return {
				type: 'SET_ICONS',
				icons,
			}
		}
	}

	registerStore('wkg/commons', {
		/***********************************************
		 * Private Store's Setters
		 */
		reducer ( state = DEFAULT_STATE, action ) {
			switch ( action.type ) {
				case 'SET_POSTS_OPTIONS':
					return {
						...state,
						posts_options: action.posts_options,
					}
				case 'SET_TERMS_OPTIONS':
					return {
						...state,
						terms_options: action.terms_options,
					}
				case 'SET_CF7_OPTIONS':
					return {
						...state,
						cf7_options: action.cf7_options,
					}
				case 'SET_ICONS':
					return {
						...state,
						icons: action.icons,
					}
			}
			return state
		},
		/**
		 * Private Store's action control
		 */
		controls: {
			FETCH_POSTS_OPTIONS (action) {
				return apiFetch({ path: action.path })
			},
			FETCH_TERMS_OPTIONS (action) {
				return apiFetch({ path: action.path })
			},
			FETCH_CF7_OPTIONS (action) {
				return apiFetch({ path: action.path })
			},
			FETCH_ICONS (action) {
				return apiFetch({ path: action.path })
			},
		},
		/**
		 * Private Store's Getters
		 * Played when selector is called, just before
		 */
		resolvers: {
			* getPostsOptions () {
				const posts_options = yield actions.fetchPostsOptions('/wkg/v1/commons/posts_options/')
				return actions.setPostsOptions(posts_options)
			},
			* getTermsOptions () {
				const terms_options = yield actions.fetchTermsOptions('/wkg/v1/commons/terms_options/')
				return actions.setTermsOptions(terms_options)
			},
			* getCf7Options () {
				const cf7_options = yield actions.fetchCf7Options('/contact-form-7/v1/contact-forms/')
				return actions.setCf7Options(cf7_options)
			},
			* getIcons () {
				const icons = yield actions.fetchIcons('/wkg/v1/commons/icons/')
				return actions.setIcons(icons)
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
			getPostsOptions(state) {
				return state.posts_options
			},
			getTermsOptions(state) {
				return state.terms_options
			},
			getCf7Options (state) {
				let options = []
				if (state.cf7_options) {
					state.cf7_options.forEach((form) => {
						options.push({value: form.id, label: form.title})
					})
				}
				return options
			},
			getIcons(state) {
				return state.icons
			},
		},
	})
}
