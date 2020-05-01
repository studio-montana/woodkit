const { Component } = wp.element
const { __ } = wp.i18n
const { Button, SelectControl } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

class WKG_Post_Selector extends Component {

  constructor (props) {
    super(props)
    this.state = {
      selected: null
    }
  }

 	componentDidMount () {
 		this.setState({
 			selected: this.props.value && this.props.value.id ? this.props.value.id : this.props.value
 		})
 	}

 	_onChange (value) {
 		if (this.props.onChange) {
 			this.setState({
 				selected: value
 			})
 			let posts = this.props.posts.filter(p => p.id === parseInt(value))
 			this.props.onChange(parseInt(value), posts.length > 0 ? posts[0] : null)
 		} else {
 			console.warn('WKG_Post_Selector doit recevoir la propriété \'onChange={value, post => func()}\'')
 		}
 	}

	render () {
    let options = []
    if (this.props.types) {
      for (var type of this.props.types) {
        if (this.props.posts && this.props.posts[type.slug]) {
          options.push({value: 0, label: type.name, disabled: true})
          this.props.posts[type.slug].forEach((post) => {
    				options.push({value: post.id, label: post.title.rendered, disabled: false})
    			})
        } else {
          options.push({value: 0, label: type.name+' '+__('loading...', 'wooden'), disabled: true})
        }
      }
    } else {
      options.push({value: 0, label: this.props.label_loading ? this.props.label_loading : 'Chargement...', disabled: true})
    }
  	return (
			<div className="wkg-post-selector">
				<SelectControl
          label={this.props.label}
					options={options}
					onChange={value => this._onChange(value)}
					value={this.state.selected}
				/>
			</div>
    )
  }
}

const applyWithSelect = withSelect((select, props) => {
		const { getEntityRecords, getPostTypes } = select('core')

    /** parse types */
    let types = getPostTypes()
    if (types) {
      if (props.post_types) {
        types = types.filter(type => props.post_types.includes(type.slug))
      } // exclude media (please use WKG_Media_Selector) and gutenberg blocks
      types = types.filter(type => type.slug !== 'attachment' && type.slug !== 'wp_block')
    }

    /** retrieve posts */
    let posts = []
    let query = {...{
      per_page : -1, // set -1 to display ALL
      // exclude : 50, // or pass multiple values in an array, e.g. [ 1, 9098 ]
      // parent_exclude : 43, // or [ 43, 44, 98 ]
      // orderby : 'date',
      // order : 'asc',
      // status : 'publish', // or [ 'publish', 'draft', 'future' ]
      // categories : [ 5, 10, 15 ], // category ID or IDs
      // tags : 4, // tag ID, you can pass multiple too [ 4, 7 ]
      // search : 'search query',
    }, ...props.query}
    if (types) {
      for (var type of types) {
        posts[type.slug] = getEntityRecords('postType', type.slug, query)
      }
    }
    return { posts, types}
})

export default compose(
    applyWithSelect,
)(WKG_Post_Selector)
