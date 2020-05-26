import { __ } from '@wordpress/i18n'
const { Component } = wp.element
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
 			this.props.onChange(parseInt(value))
 		} else {
 			console.warn('WKG_Post_Selector doit recevoir la propriété \'onChange={value, post => func()}\'')
 		}
 	}

	render () {
    let options = []
    if (this.props.posts_options) {
      for (const post_type in this.props.posts_options) {
        const post_options = this.props.posts_options[post_type]
        if (post_options) {
          options.push({value: 0, label: post_options.post_type_label, disabled: true})
          if (post_options.options) {
            for (var post_option of post_options.options) {
              options.push({value: post_option.value, label: post_option.label, disabled: post_option.disabled})
            }
          }
        }
      }
    } else {
      options.push({value: 0, label: this.props.label_loading ? this.props.label_loading : __("Loading...", 'woodkit'), disabled: true})
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
  const { getPostTypes } = select('core')
  const { getPostsOptions } = select('wkg/commons')

  /********************************************************/
  /* GET POSTS OPTIONS                                    */
  /********************************************************/
  if (!props.post_types) {
    // default post types
    let types = getPostTypes()
    if (types) {
      // exclude media (please use WKG_Media_Selector) and gutenberg blocks
      props.post_types = types.filter(type => type.slug !== 'attachment' && type.slug !== 'wp_block').map(type => type.slug)
    }
  }
  let posts_options = getPostsOptions(props.post_types)
  return { posts_options }
})

export default compose(
    applyWithSelect,
)(WKG_Post_Selector)
