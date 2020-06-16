if (typeof wp !== 'undefined' && typeof wp.blocks !== 'undefined') { // block editor (Gutenberg) is active
	const { apiFetch } = wp
	const { registerStore } = wp.data
	
	const DEFAULT_STATE = {
		posts_options: null,
		terms_options: null,
		cf7_options: null,
		icons: null,
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
		setPostsOptions (posts_options, post_types) {
			return {
				type: 'SET_POSTS_OPTIONS',
				posts_options,
				post_types,
			}
		},
		setTermsOptions (terms_options, taxonomies) {
			return {
				type: 'SET_TERMS_OPTIONS',
				terms_options,
				taxonomies,
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
					let posts_options = state.posts_options
					if (!action.post_types) {
						posts_options = action.posts_options
					} else {
						posts_options = {...posts_options, ...action.posts_options}
					}
					state = {
						...state,
						posts_options
					}
					return state
				case 'SET_TERMS_OPTIONS':
					let terms_options = state.terms_options
					if (!action.taxonomies) {
						terms_options = action.terms_options
					} else {
						terms_options = {...terms_options, ...action.terms_options}
					}
					state = {
						...state,
						terms_options
					}
					return state
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
				return apiFetch({ path: action.path  })
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
		 * They proceed to ASYNCH calls (like REST API calls !)
		 */
		resolvers: {
			* getPostsOptions (post_types = null) {
				const posts_options = yield actions.fetchPostsOptions('/wkg/v1/commons/posts_options/' + (post_types ? '?post_types='+post_types.join(',') : ''))
				return actions.setPostsOptions(posts_options, post_types)
			},
			* getTermsOptions (taxonomies = null) {
				const terms_options = yield actions.fetchTermsOptions('/wkg/v1/commons/terms_options/' + (taxonomies ? '?taxonomies='+taxonomies.join(',') : ''))
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
			getPostsOptions(state, post_types) {
				if (post_types) {
					let res = []
					for (var post_type of post_types) {
						res[post_type] = state.posts_options ? state.posts_options[post_type] : null
					}
					return res
				}
				return state.posts_options
			},
			getTermsOptions(state, taxonomies) {
				if (taxonomies) {
					let res = []
					for (var tax of taxonomies) {
						res[tax] = state.terms_options ? state.terms_options[tax] : null
					}
					return res
				}
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